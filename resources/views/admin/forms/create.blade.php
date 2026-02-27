@extends('admin.layouts.app')

@section('title', 'Create Form')

@push('styles')
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .text-danger {
            color: var(--danger-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* Dynamic Fields Builder */
        .field-builder {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #f9fafb;
        }

        .field-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
            align-items: center;
        }

        .field-item input,
        .field-item select {
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Build New Form</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.forms.store') }}" method="POST" id="form-builder">
                @csrf

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="title">Form Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="slug">URL Slug (Optional)</label>
                        <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}"
                            placeholder="Auto-generated if left blank">
                        @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Form Description</label>
                    <textarea id="description" name="description" class="form-control"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Form Fields <span class="text-danger">*</span></label>
                    <div class="field-builder" id="fields-container">
                        <div class="field-item" style="flex-wrap: wrap;">
                            <input type="text" placeholder="Field Name (e.g. Full Name)" style="flex:2; min-width: 200px;"
                                class="f-name" required>
                            <select class="f-type" style="flex:1; min-width: 150px;" onchange="toggleOptions(this)">
                                <option value="text">Text (Short Answer)</option>
                                <option value="textarea">Textarea (Long Answer)</option>
                                <option value="email">Email</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                                <option value="select">Dropdown (Select)</option>
                                <option value="radio">Radio Buttons</option>
                                <option value="checkbox">Checklist (Multiple Selection)</option>
                                <option value="file">File Upload</option>
                            </select>
                            <div class="options-container" style="display:none; width: 100%; margin-top: 0.5rem;">
                                <input type="text" placeholder="Options (comma separated, e.g: Option 1, Option 2)"
                                    class="f-options" style="width: 100%;">
                            </div>
                            <label style="display:flex; align-items:center; gap:0.25rem; margin-top: 0.5rem;"><input
                                    type="checkbox" class="f-req"> Required</label>
                        </div>
                    </div>
                    <button type="button" class="btn"
                        style="background-color: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 6px;"
                        id="add-field-btn">
                        <i data-feather="plus" style="width: 16px; height: 16px;"></i> Add Field
                    </button>
                    <input type="hidden" name="fields" id="fields-json">
                    @error('fields') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                    <label for="is_active" style="font-weight: 500;">Publish this form immediately</label>
                </div>

                <div style="margin-top: 2.5rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Save Form
                    </button>
                    <a href="{{ route('admin.forms.index') }}" class="btn"
                        style="background-color: var(--bg-body); border-color: var(--border-color);">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleOptions(select) {
            const container = select.parentElement.querySelector('.options-container');
            if (['select', 'radio', 'checkbox'].includes(select.value)) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('fields-container');
            const addBtn = document.getElementById('add-field-btn');
            const form = document.getElementById('form-builder');
            const jsonInput = document.getElementById('fields-json');

            addBtn.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'field-item';
                row.style.cssText = 'flex-wrap: wrap; border-top: 1px solid var(--border-color); padding-top: 1rem; margin-top: 1rem;';
                row.innerHTML = `
                        <input type="text" placeholder="Field Name" style="flex:2; min-width: 200px;" class="f-name" required>
                        <select class="f-type" style="flex:1; min-width: 150px;" onchange="toggleOptions(this)">
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="email">Email</option>
                            <option value="number">Number</option>
                            <option value="date">Date</option>
                            <option value="select">Dropdown (Select)</option>
                            <option value="radio">Radio Buttons</option>
                            <option value="checkbox">Checklist</option>
                            <option value="file">File Upload</option>
                        </select>
                        <div class="options-container" style="display:none; width: 100%; margin-top: 0.5rem;">
                            <input type="text" placeholder="Options (comma separated)" class="f-options" style="width: 100%;">
                        </div>
                        <label style="display:flex; align-items:center; gap:0.25rem; margin-top: 0.5rem;"><input type="checkbox" class="f-req"> Required</label>
                        <button type="button" onclick="this.parentElement.remove()" style="color:red; background:none; border:none; cursor:pointer;" title="Remove">✕</button>
                    `;
                container.appendChild(row);
                feather.replace();
            });

            form.addEventListener('submit', function (e) {
                const fields = [];
                document.querySelectorAll('.field-item').forEach(item => {
                    const type = item.querySelector('.f-type').value;
                    const optionsRaw = item.querySelector('.f-options').value;
                    const options = optionsRaw ? optionsRaw.split(',').map(o => o.trim()).filter(o => o) : [];

                    fields.push({
                        name: item.querySelector('.f-name').value,
                        type: type,
                        required: item.querySelector('.f-req').checked,
                        options: options
                    });
                });
                jsonInput.value = JSON.stringify(fields);
            });
        });
    </script>
@endpush