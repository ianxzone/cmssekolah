@extends('theme::layouts.app')

@section('title', $form->title . ' - ' . config('app.name'))
@section('meta_description', $form->description ?? 'Securely submit your information using our online form.')

@push('styles')
<style>
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        background: var(--bg-surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(to right, #4f46e5, #4338ca);
        color: white;
        padding: 3rem 2rem;
        text-align: center;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .form-description {
        opacity: 0.9;
        font-size: 1.125rem;
        max-width: 500px;
        margin: 0 auto;
    }

    .form-body {
        padding: 3rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 0.25rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        background-color: #f9fafb;
        color: var(--text-primary);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        background-color: var(--bg-surface);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .error-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: block;
    }

    .submit-btn-wrapper {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endpush

@section('content')
    <div class="form-container">
        <header class="form-header">
            <h1 class="form-title">{{ $form->title }}</h1>
            @if($form->description)
                <p class="form-description">{{ $form->description }}</p>
            @endif
        </header>

        <div class="form-body">
            <form action="{{ route('forms.submit', $form->slug) }}" method="POST">
                @csrf

                @php
                    $fields = is_string($form->fields) ? json_decode($form->fields, true) : $form->fields;
                @endphp

                @if(is_array($fields) && count($fields) > 0)
                    @foreach($fields as $field)
                        @php
                            $inputName = str_replace(' ', '_', strtolower($field['name']));
                            $isRequired = !empty($field['required']) ? 'required' : '';
                        @endphp

                        <div class="form-group">
                            <label class="form-label" for="{{ $inputName }}">
                                {{ $field['name'] }}
                                @if($isRequired)
                                    <span class="required" title="Required">*</span>
                                @endif
                            </label>

                            @if($field['type'] === 'textarea')
                                <textarea 
                                    name="{{ $inputName }}" 
                                    id="{{ $inputName }}" 
                                    class="form-control" 
                                    {{ $isRequired }}>{{ old($inputName) }}</textarea>

                            @elseif(in_array($field['type'], ['select', 'radio', 'checkbox']) && isset($field['options']))
                                @php
                                    $rawOptions = $field['options'];
                                    if (is_string($rawOptions)) {
                                        $options = array_map('trim', explode(',', $rawOptions));
                                    } else {
                                        // Handle potential array of strings OR array of objects from seeders
                                        $options = array_map(function($opt) {
                                            return is_array($opt) ? ($opt['option'] ?? $opt['label'] ?? $opt['value'] ?? '') : $opt;
                                        }, $rawOptions);
                                    }
                                @endphp

                                @if($field['type'] === 'select')
                                    <select name="{{ $inputName }}" id="{{ $inputName }}" class="form-control" {{ $isRequired }}>
                                        <option value="" disabled {{ old($inputName) ? '' : 'selected' }}>Select an option...</option>
                                        @foreach($options as $option)
                                            <option value="{{ $option }}" {{ old($inputName) == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <div class="options-wrapper" style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.5rem;">
                                        @foreach($options as $option)
                                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                                <input 
                                                    type="{{ $field['type'] }}" 
                                                    name="{{ $field['type'] === 'checkbox' ? $inputName.'[]' : $inputName }}" 
                                                    value="{{ $option }}"
                                                    {{ ($field['type'] === 'checkbox' ? (is_array(old($inputName)) && in_array($option, old($inputName))) : (old($inputName) == $option)) ? 'checked' : '' }}
                                                    {{ $field['type'] === 'radio' ? $isRequired : '' }}>
                                                {{ $option }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endif

                            @else
                                <input 
                                    type="{{ in_array($field['type'], ['number', 'email', 'date', 'file']) ? $field['type'] : 'text' }}" 
                                    name="{{ $inputName }}" 
                                    id="{{ $inputName }}" 
                                    class="form-control" 
                                    value="{{ old($inputName) }}" 
                                    {{ $isRequired }}>
                            @endif

                            @error($inputName)
                                <span class="error-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger" style="background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2);">
                        <i data-feather="alert-circle"></i>
                        <span>This form has no configured fields. Please contact the administrator.</span>
                    </div>
                @endif

                <div class="submit-btn-wrapper">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                        Submit Form <i data-feather="send" style="width: 18px; height: 18px; margin-left: 0.5rem;"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
