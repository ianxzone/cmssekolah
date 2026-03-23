<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MaintenanceController extends Controller
{
    /**
     * List of dangerous file extensions that should never be extracted
     */
    protected $dangerousExtensions = [
        'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar',
        'exe', 'bat', 'sh', 'cmd', 'ps1', 'com',
        'htaccess', 'htpasswd', 'ini', 'conf',
        'py', 'rb', 'pl', 'cgi',
        'asp', 'aspx', 'jsp', 'jspx',
        'dll', 'so', 'dylib'
    ];

    /**
     * Maximum file size in ZIP (in bytes) - 10MB per file
     */
    protected $maxFileSizePerFile = 10485760;

    /**
     * Maximum total uncompressed size - 100MB
     */
    protected $maxTotalSize = 104857600;
    public function index()
    {
        $isDown = app()->isDownForMaintenance();

        // Use standard way to check secret if possible, or just look in storage file
        // Laravel's maintenance token is usually only needed during the request to bypass.
        // We can just generate a new secret each time we turn it on.
        return view('admin.maintenance.index', compact('isDown'));
    }

    public function toggle(Request $request)
    {
        $action = $request->input('action'); // 'up' or 'down'

        if ($action === 'down') {
            // Generate a random secret for bypassing
            $secret = Str::random(16);

            // Call artisan down with the secret
            Artisan::call('down', [
                '--secret' => $secret
            ]);

            // Save the secret temporarily in session so we can display it once
            session()->flash('success', 'Maintenance mode enabled. Setting bypass cookie...');
            session()->flash('maintenance_secret', $secret);

            // Redirect to the secret URL so Laravel natively sets the 'laravel_maintenance' cookie.
            // Afterwards, Laravel will automatically redirect the user to the frontend homepage (/).
            return redirect('/' . $secret);
        } elseif ($action === 'up') {
            Artisan::call('up');
            return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance mode disabled.');
        }

        return redirect()->route('admin.maintenance.index')->with('error', 'Invalid action.');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        return redirect()->route('admin.maintenance.index')->with('success', 'Application cache cleared successfully!');
    }

    public function optimize()
    {
        Artisan::call('optimize');

        return redirect()->route('admin.maintenance.index')->with('success', 'Application optimized successfully!');
    }

    public function uploadUpdate(Request $request)
    {
        $request->validate([
            'update_file' => 'required|mimes:zip|max:51200', // max 50MB
        ]);

        if ($request->hasFile('update_file')) {
            $file = $request->file('update_file');
            
            try {
                // Generate unique temporary directory
                $tempDir = 'updates/' . uniqid('update_', true);
                
                // Store uploaded file temporarily
                $uploadedPath = Storage::disk('local')->put($tempDir, $file);
                $fullPath = storage_path('app/' . $uploadedPath);
                
                $zip = new \ZipArchive;
                
                if ($zip->open($fullPath) !== TRUE) {
                    throw new \Exception('Failed to open the zip file.');
                }
                
                // Validate ZIP contents BEFORE extraction
                $validationResult = $this->validateZipContents($zip);
                
                if (!$validationResult['valid']) {
                    $zip->close();
                    Storage::delete($uploadedPath);
                    throw ValidationException::withMessages([
                        'update_file' => $validationResult['error']
                    ]);
                }
                
                // Extract to isolated directory first
                $extractTo = storage_path('app/updates/extracted/' . uniqid());
                
                if (!file_exists($extractTo)) {
                    mkdir($extractTo, 0755, true);
                }
                
                $zip->extractTo($extractTo);
                $zip->close();
                
                // Additional validation after extraction
                $postExtractValidation = $this->validateExtractedFiles($extractTo);
                
                if (!$postExtractValidation['valid']) {
                    // Clean up
                    $this->deleteDirectory($extractTo);
                    Storage::delete($uploadedPath);
                    throw ValidationException::withMessages([
                        'update_file' => $postExtractValidation['error']
                    ]);
                }
                
                // If all validations pass, proceed with controlled deployment
                // For now, we'll just keep it in isolated directory
                // Admin can manually review and deploy
                
                // Clean up uploaded zip
                Storage::delete($uploadedPath);
                
                return redirect()->route('admin.maintenance.index')
                    ->with('success', 'Update file uploaded and validated successfully. Files are ready for review.')
                    ->with('update_info', [
                        'files_count' => $validationResult['files_count'],
                        'total_size' => $validationResult['total_size'],
                        'location' => $extractTo
                    ]);
                    
            } catch (ValidationException $e) {
                throw $e;
            } catch (\Exception $e) {
                return redirect()->route('admin.maintenance.index')
                    ->with('error', 'Update failed: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('admin.maintenance.index')
            ->with('error', 'No update file uploaded.');
    }
    
    /**
     * Validate ZIP file contents before extraction
     */
    protected function validateZipContents(\ZipArchive $zip): array
    {
        $totalSize = 0;
        $filesCount = 0;
        
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $fileInfo = $zip->statIndex($i);
            $filename = $fileInfo['name'];
            
            // Skip directories
            if (str_ends_with($filename, '/')) {
                continue;
            }
            
            $filesCount++;
            
            // Check file size
            if ($fileInfo['size'] > $this->maxFileSizePerFile) {
                return [
                    'valid' => false,
                    'error' => "File '{$filename}' exceeds maximum size limit (10MB)."
                ];
            }
            
            $totalSize += $fileInfo['size'];
            
            if ($totalSize > $this->maxTotalSize) {
                return [
                    'valid' => false,
                    'error' => 'Total uncompressed size exceeds limit (100MB).'
                ];
            }
            
            // Check for path traversal attacks
            if (strpos($filename, '../') !== false || strpos($filename, '..\\') !== false) {
                return [
                    'valid' => false,
                    'error' => "Path traversal detected in file: '{$filename}'. This is not allowed."
                ];
            }
            
            // Check file extension
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($extension, $this->dangerousExtensions)) {
                return [
                    'valid' => false,
                    'error' => "Dangerous file type detected: '{$filename}' (.*{$extension}). Executable files are not allowed."
                ];
            }
            
            // Check if filename starts with dot (hidden files)
            $basename = basename($filename);
            if (str_starts_with($basename, '.') && !in_array($basename, ['.htaccess'])) {
                return [
                    'valid' => false,
                    'error' => "Hidden files are not allowed: '{$filename}'"
                ];
            }
        }
        
        if ($filesCount === 0) {
            return [
                'valid' => false,
                'error' => 'ZIP file is empty.'
            ];
        }
        
        return [
            'valid' => true,
            'files_count' => $filesCount,
            'total_size' => $totalSize
        ];
    }
    
    /**
     * Validate files after extraction (additional security check)
     */
    protected function validateExtractedFiles(string $directory): array
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($files as $file) {
            if ($file->isFile()) {
                $filePath = $file->getPathname();
                $relativePath = str_replace($directory . DIRECTORY_SEPARATOR, '', $filePath);
                
                // Double-check for dangerous extensions
                $extension = strtolower($file->getExtension());
                if (in_array($extension, $this->dangerousExtensions)) {
                    return [
                        'valid' => false,
                        'error' => "Dangerous file found after extraction: {$relativePath}"
                    ];
                }
                
                // Check for magic bytes (executable content)
                $content = file_get_contents($filePath, false, null, 0, 256);
                if ($this->containsExecutableContent($content)) {
                    return [
                        'valid' => false,
                        'error' => "Executable content detected in: {$relativePath}"
                    ];
                }
            }
        }
        
        return ['valid' => true];
    }
    
    /**
     * Check if content contains executable signatures
     */
    protected function containsExecutableContent(string $content): bool
    {
        $executableSignatures = [
            '<?php',
            '<script language="php">',
            '%PDF-', // PDF
            chr(0x7F) . 'ELF', // ELF binary
            'MZ', // DOS/Windows executable
            '#!/usr/bin/perl',
            '#!/usr/bin/python',
            '#!/bin/bash',
        ];
        
        foreach ($executableSignatures as $signature) {
            if (strpos($content, $signature) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Recursively delete a directory
     */
    protected function deleteDirectory(string $directory): bool
    {
        if (!file_exists($directory)) {
            return true;
        }
        
        if (!is_dir($directory)) {
            return unlink($directory);
        }
        
        foreach (scandir($directory) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            
            $path = $directory . DIRECTORY_SEPARATOR . $item;
            
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
        
        return rmdir($directory);
    }
}
