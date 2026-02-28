<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Load forms with their submissions count
        $forms = Form::withCount('submissions')->latest()->paginate(10);
        return view('admin.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:forms,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'fields' => 'required|string', // We will accept JSON string from frontend
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['fields'] = json_decode($validated['fields'], true);

        Form::create($validated);

        return redirect()->route('admin.forms.index')
            ->with('success', 'Form created successfully.');
    }

    /**
     * Show the specified resource (Submissions).
     */
    public function show(Form $form)
    {
        $submissions = $form->submissions()->latest()->paginate(20);
        return view('admin.forms.show', compact('form', 'submissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        return view('admin.forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:forms,slug,' . $form->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'fields' => 'required|string',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['fields'] = json_decode($validated['fields'], true);

        $form->update($validated);

        return redirect()->route('admin.forms.index')
            ->with('success', 'Form updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $form->delete();

        return redirect()->route('admin.forms.index')
            ->with('success', 'Form deleted successfully.');
    }

    /**
     * Export submissions to CSV.
     */
    public function export(Form $form)
    {
        $submissions = $form->submissions()->latest()->get();

        if ($submissions->isEmpty()) {
            return back()->with('error', 'No submissions to export.');
        }

        // Dynamically get all keys from the data JSON
        $headers = ['No', 'Tanggal', 'Alamat IP'];
        $dataKeys = [];
        foreach ($submissions as $submission) {
            foreach (array_keys($submission->data) as $key) {
                if (!in_array($key, $dataKeys)) {
                    $dataKeys[] = $key;
                    $headers[] = ucwords(str_replace(['_', '-'], ' ', $key));
                }
            }
        }

        $fileName = 'Submissions_' . Str::slug($form->title) . '_' . date('Y-m-d_H-i') . '.csv';

        $response = new StreamedResponse(function () use ($submissions, $dataKeys, $headers) {
            $handle = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write Headers
            fputcsv($handle, $headers);

            // Write Data
            foreach ($submissions as $index => $submission) {
                $row = [
                    $index + 1,
                    $submission->created_at->format('Y-m-d H:i:s'),
                    $submission->ip_address,
                ];

                foreach ($dataKeys as $key) {
                    $value = $submission->data[$key] ?? '';
                    if (is_array($value)) {
                        $row[] = implode(', ', $value);
                    } else {
                        $row[] = $value;
                    }
                }

                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
}
