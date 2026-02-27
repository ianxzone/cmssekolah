<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function show($slug)
    {
        $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('forms.show', compact('form'));
    }

    public function store(Request $request, $slug)
    {
        $form = Form::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Dynamic Validation
        $rules = [];
        $fields = $form->fields ?? [];

        foreach ($fields as $field) {
            $fieldName = $field['name'];
            $fieldRules = [];

            if ($field['required'] ?? false) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            if ($field['type'] === 'email') {
                $fieldRules[] = 'email';
            }
            if ($field['type'] === 'number') {
                $fieldRules[] = 'numeric';
            }
            if ($field['type'] === 'date') {
                $fieldRules[] = 'date';
            }

            $rules[$fieldName] = $fieldRules;
        }

        $validatedData = $request->validate($rules);

        FormSubmission::create([
            'form_id' => $form->id,
            'data' => $validatedData,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Terima kasih! Data Anda telah berhasil dikirim.');
    }
}
