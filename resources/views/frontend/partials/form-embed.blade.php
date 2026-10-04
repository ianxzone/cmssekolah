<style>
    /* Global Page Background Integration */
    body {
        background-color: #f8fafc !important; /* Soft gray background to make form pop */
    }

    .form-container {
        max-width: 760px;
        margin: 3rem auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .form-header {
        /* Adjusted to match the School's Green Identity */
        background: linear-gradient(135deg, #065f46 0%, #059669 100%);
        color: white;
        padding: 3.5rem 2.5rem;
        text-align: center;
        position: relative;
    }

    /* Optional: Subtle pattern/overlay for header */
    .form-header::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(circle at top right, rgba(255,255,255,0.15) 0%, transparent 60%);
        pointer-events: none;
    }

    .form-title {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: -0.025em;
        position: relative;
        z-index: 10;
    }

    .form-description {
        opacity: 0.9;
        font-size: 1.05rem;
        max-width: 550px;
        margin: 0 auto;
        line-height: 1.6;
        position: relative;
        z-index: 10;
    }

    .form-body {
        padding: 3rem 4rem;
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 0.25rem;
        font-weight: bold;
    }

    .form-control {
        width: 100%;
        padding: 0.85rem 1.25rem;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background-color: #f8fafc;
        color: #0f172a;
        transition: all 0.2s ease;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-control:hover {
        border-color: #94a3b8;
    }

    .form-control:focus {
        outline: none;
        border-color: #059669;
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
        background-color: #ffffff;
    }

    textarea.form-control {
        min-height: 140px;
        resize: vertical;
        line-height: 1.5;
    }

    /* Radio & Checkbox Styling adjustments */
    .radio-checkbox-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .radio-checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        cursor: pointer;
        font-weight: 500;
        color: #475569;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .radio-checkbox-label:hover {
        background-color: #f1f5f9;
        border-color: #e2e8f0;
        color: #0f172a;
    }

    .radio-checkbox-input {
        width: 1.15rem;
        height: 1.15rem;
        accent-color: #059669; /* Use brand green for the actual checkbox/radio */
        cursor: pointer;
    }

    .error-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: block;
        font-weight: 500;
    }

    .submit-btn-wrapper {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px dashed #cbd5e1;
    }

    .btn-submit-custom {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, #065f46 0%, #059669 100%);
        color: white;
        border: none;
        padding: 1.15rem 2rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        background: linear-gradient(135deg, #064e3b 0%, #047857 100%);
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 2rem 1.5rem;
        }
        .form-header {
            padding: 2.5rem 1.5rem;
        }
        .form-title {
            font-size: 1.75rem;
        }
    }
</style>

<div class="form-container">
    <header class="form-header">
        <h1 class="form-title">{{ $form->title }}</h1>
        @if($form->description)
            <p class="form-description">{{ $form->description }}</p>
        @endif
    </header>

    <div class="form-body">
        @if(session('success'))
            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                <i data-feather="check-circle" style="color: #10b981; width: 22px; height: 22px; flex-shrink: 0;"></i>
                <span style="font-weight: 500;">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 2rem;">
                <div style="font-weight: 600; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="alert-triangle" style="width: 18px; height: 18px; color: #ef4444;"></i>
                    Mohon periksa kembali isian formulir Anda:
                </div>
                <ul style="margin: 0; padding-left: 1.5rem; font-size: 0.875rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data">
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

                        @elseif(in_array($field['type'], ['select', 'radio', 'checkbox']) && !empty($field['options']))
                            @php
                                // Fix: Form builder saves options as an array, but fallback to explode if it's a string
                                $options = is_array($field['options']) ? $field['options'] : array_map('trim', explode(',', $field['options']));
                            @endphp
                            
                            @if($field['type'] === 'select')
                                <select name="{{ $inputName }}" id="{{ $inputName }}" class="form-control" {{ $isRequired }}>
                                    <option value="" disabled selected>Pilih salah satu...</option>
                                    @foreach($options as $option)
                                        <option value="{{ $option }}" {{ old($inputName) == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <div class="radio-checkbox-wrapper">
                                    @foreach($options as $index => $option)
                                        <label class="radio-checkbox-label">
                                            <input class="radio-checkbox-input" type="{{ $field['type'] }}" name="{{ $inputName }}{{ $field['type'] === 'checkbox' ? '[]' : '' }}" value="{{ $option }}" {{ old($inputName) == $option ? 'checked' : '' }} {{ $isRequired && $field['type'] === 'radio' ? 'required' : '' }}>
                                            <span>{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                        @else
                            <input 
                                type="{{ $field['type'] === 'number' ? 'number' : ($field['type'] === 'email' ? 'email' : ($field['type'] === 'file' ? 'file' : ($field['type'] === 'date' ? 'date' : 'text'))) }}" 
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
                <div class="alert alert-danger" style="background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2); padding: 1.5rem; border-radius: 12px; display: flex; gap: 1rem; align-items: center;">
                    <i data-feather="alert-circle"></i>
                    <span>Formulir ini belum memiliki pertanyaan yang dikonfigurasi. Silakan hubungi administrator sekolah.</span>
                </div>
            @endif

            {{-- Security Captcha & Honeypot Section --}}
            @if(\App\Services\CaptchaService::isEnabledFor('forms'))
                @php
                    $captcha = \App\Services\CaptchaService::generateMathCaptcha();
                @endphp
                {{-- Honeypots --}}
                <input type="text" name="_hp_name" style="display:none !important; visibility:hidden !important;" tabindex="-1" autocomplete="off">
                <input type="hidden" name="_hp_time" value="{{ time() }}">

                <div class="form-group" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.25rem; margin-top: 1.5rem;">
                    <label class="form-label" for="captcha_answer" style="font-weight: 600; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i data-feather="shield" style="width: 16px; height: 16px; color: #059669;"></i>
                        Verifikasi Keamanan: Berapa hasil dari <span style="background: #e2e8f0; color: #0f172a; padding: 2px 8px; border-radius: 6px; font-weight: 700;">{{ $captcha['question'] }}</span> <span class="required">*</span>
                    </label>
                    <input type="number" name="captcha_answer" id="captcha_answer" class="form-control" placeholder="Ketik angka jawaban..." required style="max-width: 200px;">
                    @error('captcha')
                        <span class="error-feedback">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <div class="submit-btn-wrapper">
                <button type="submit" class="btn-submit-custom">
                    <span>Kirim Formulir Pendaftaran</span>
                    <i data-feather="send" style="width: 18px; height: 18px;"></i>
                </button>
            </div>
        </form>
    </div>
</div>
