@extends('admin.layouts.app')

@section('title', 'Import WordPress')

@push('styles')
<style>
    /* Hero Banner styles based on dashboard banner */
    .import-hero {
        background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
        border-radius: 8px;
        padding: 30px;
        color: #fff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .import-hero-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .import-hero-icon svg {
        width: 48px;
        height: 48px;
        color: #fff;
    }
    
    .import-hero-content h1 {
        margin: 0 0 10px 0;
        font-size: 24px;
        font-weight: 600;
        color: #fff;
    }
    
    .import-hero-content p {
        margin: 0;
        font-size: 15px;
        opacity: 0.9;
        line-height: 1.5;
    }

    /* Instructions styles */
    .instructions-list {
        margin: 0;
        padding-left: 20px;
        line-height: 1.6;
    }
    
    .instructions-list li {
        margin-bottom: 8px;
    }

    .tip-box {
        background-color: #f0fdf4;
        border-left: 4px solid #16a34a;
        padding: 15px;
        margin-top: 20px;
        border-radius: 4px;
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }
    
    .tip-box svg {
        color: #16a34a;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .tip-box-content h4 {
        margin: 0 0 5px 0;
        color: #166534;
        font-size: 15px;
    }
    
    .tip-box-content p {
        margin: 0;
        color: #15803d;
        font-size: 14px;
    }

    /* Upload Zone styles */
    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        position: relative;
    }
    
    .upload-zone:hover, .upload-zone.dragover {
        border-color: #0ea5e9;
        background-color: #f0f9ff;
    }
    
    .upload-zone-icon {
        margin-bottom: 15px;
    }
    
    .upload-zone-icon svg {
        width: 48px;
        height: 48px;
        color: #94a3b8;
        transition: color 0.3s ease;
    }
    
    .upload-zone:hover .upload-zone-icon svg,
    .upload-zone.dragover .upload-zone-icon svg {
        color: #0ea5e9;
    }
    
    .upload-zone-text {
        font-size: 16px;
        color: #475569;
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .upload-zone-subtext {
        font-size: 13px;
        color: #64748b;
    }
    
    .file-input {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    .selected-file {
        display: none;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background-color: #f1f5f9;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #e2e8f0;
    }
    
    .selected-file.active {
        display: flex;
    }
    
    .file-icon {
        background-color: #e2e8f0;
        width: 40px;
        height: 40px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .file-icon svg {
        width: 20px;
        height: 20px;
        color: #64748b;
    }
    
    .file-info {
        flex-grow: 1;
    }
    
    .file-name {
        font-weight: 500;
        color: #334155;
        font-size: 14px;
        margin-bottom: 3px;
        word-break: break-all;
    }
    
    .file-size {
        font-size: 12px;
        color: #64748b;
    }
    
    .remove-file {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    
    .remove-file:hover {
        background-color: #fee2e2;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }
</style>
@endpush

@section('content')
    <div class="import-hero">
        <div class="import-hero-icon">
            <i data-feather="download-cloud"></i>
        </div>
        <div class="import-hero-content">
            <h1>Import dari WordPress</h1>
            <p>Migrasi konten dari website WordPress Anda ke CMS ini. Export konten dari WordPress (Tools &rarr; Export &rarr; All Content) lalu upload file XML-nya di sini.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 15px; border-radius: 4px; background-color: #fef2f2; color: #991b1b; border: 1px solid #f87171; display: flex; align-items: center; gap: 10px;">
            <i data-feather="alert-circle" style="width: 20px; height: 20px;"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="panel" style="margin-bottom: 20px;">
        <div class="panel-header">
            <h2 class="panel-title">Cara Export dari WordPress</h2>
        </div>
        <div class="panel-body">
            <ol class="instructions-list">
                <li>Login ke dashboard WordPress Anda</li>
                <li>Buka menu <strong>Tools &rarr; Export</strong></li>
                <li>Pilih <strong>All Content</strong> untuk mengexport semua data</li>
                <li>Klik <strong>Download Export File</strong></li>
                <li>Upload file <code>.xml</code> yang telah didownload di form bawah ini</li>
            </ol>
            
            <div class="tip-box">
                <i data-feather="info"></i>
                <div class="tip-box-content">
                    <h4>Catatan Penting</h4>
                    <p>File export WordPress berformat XML (WXR). Ukuran maksimal yang diperbolehkan adalah 50MB.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Upload File WordPress XML</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.wordpress-import.preview') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                
                @error('xml_file')
                    <div class="alert alert-danger" style="margin-bottom: 15px; padding: 10px 15px; border-radius: 4px; background-color: #fef2f2; color: #991b1b; border: 1px solid #f87171; font-size: 14px;">
                        {{ $message }}
                    </div>
                @enderror

                <div class="upload-zone" id="uploadZone">
                    <div class="upload-zone-icon">
                        <i data-feather="upload-cloud"></i>
                    </div>
                    <div class="upload-zone-text">Drag & drop file XML di sini atau klik untuk memilih</div>
                    <div class="upload-zone-subtext">Mendukung file .xml hingga 50MB</div>
                    <input type="file" name="xml_file" id="xmlFile" class="file-input" accept=".xml">
                </div>

                <div class="selected-file" id="selectedFile">
                    <div class="file-icon">
                        <i data-feather="file-text"></i>
                    </div>
                    <div class="file-info">
                        <div class="file-name" id="fileName">wordpress-export.xml</div>
                        <div class="file-size" id="fileSize">1.2 MB</div>
                    </div>
                    <button type="button" class="remove-file" id="removeFile" title="Hapus file">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn" style="display: flex; align-items: center; gap: 8px;">
                        <i data-feather="arrow-right" style="width: 18px; height: 18px;"></i> Analisa & Preview
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('xmlFile');
        const selectedFile = document.getElementById('selectedFile');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const removeFile = document.getElementById('removeFile');
        const importForm = document.getElementById('importForm');
        
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        uploadZone.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', handleFileSelect);

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadZone.classList.add('dragover');
        }

        function unhighlight(e) {
            uploadZone.classList.remove('dragover');
        }

        uploadZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                fileInput.files = files;
                handleFileSelect();
            }
        }

        function handleFileSelect() {
            const files = fileInput.files;
            if (files.length > 0) {
                const file = files[0];
                
                const extension = file.name.split('.').pop().toLowerCase();
                if (extension !== 'xml') {
                    alert('Hanya file XML yang diperbolehkan.');
                    clearFile();
                    return;
                }

                fileName.textContent = file.name;
                fileSize.textContent = formatBytes(file.size);
                
                uploadZone.style.display = 'none';
                selectedFile.classList.add('active');
            }
        }

        function clearFile() {
            fileInput.value = '';
            uploadZone.style.display = 'block';
            selectedFile.classList.remove('active');
        }

        removeFile.addEventListener('click', function(e) {
            e.stopPropagation();
            clearFile();
        });
        
        importForm.addEventListener('submit', function(e) {
            if (fileInput.files.length === 0) {
                e.preventDefault();
                alert('Silakan pilih file XML terlebih dahulu.');
            } else {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i data-feather="loader" class="spin" style="width: 18px; height: 18px; animation: spin 1s linear infinite;"></i> Memproses...';
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
                // Allow the form to submit but don't disable button to ensure submission happens correctly if disabling causes issues,
                // or use setTimeout
                setTimeout(() => submitBtn.disabled = true, 50);
            }
        });

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
    });
</script>
<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .spin {
        animation: spin 1s linear infinite;
    }
</style>
@endpush
