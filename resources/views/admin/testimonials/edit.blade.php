@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')

    <div class="panel" style="max-width: 800px; margin: 0 auto;">
        <div class="panel-header">
            <h2 class="panel-title">Edit Testimonial: {{ $testimonial->name }}</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', $testimonial->name) }}" required autofocus>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Role <span class="text-danger">*</span></label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="parent" {{ old('role', $testimonial->role) == 'parent' ? 'selected' : '' }}>Orang Tua
                            (Parent)</option>
                        <option value="student" {{ old('role', $testimonial->role) == 'student' ? 'selected' : '' }}>
                            Siswa/Siswi (Student)</option>
                        <option value="alumni" {{ old('role', $testimonial->role) == 'alumni' ? 'selected' : '' }}>Alumni
                        </option>
                    </select>
                    @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="profession">Profession / Occupation</label>
                    <input type="text" id="profession" name="profession" class="form-control"
                        value="{{ old('profession', $testimonial->profession) }}"
                        placeholder="e.g. Pegawai Swasta, Dokter, etc.">
                    @error('profession') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="content">Testimonial Content <span class="text-danger">*</span></label>
                    <textarea id="content" name="content" class="form-control" rows="5"
                        required>{{ old('content', $testimonial->content) }}</textarea>
                    @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="image">Photo (Optional)</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*"
                        onchange="previewImage(this)">
                    <div id="imagePreview" style="margin-top: 1rem; display: {{ $testimonial->image ? 'block' : 'none' }};">
                        <img id="preview"
                            src="{{ $testimonial->image ? \Illuminate\Support\Facades\Storage::url($testimonial->image) : '#' }}"
                            alt="Preview"
                            style="max-width: 150px; border-radius: 8px; border: 1px solid var(--border-color);">
                    </div>
                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                    <label for="is_active" style="cursor: pointer; font-weight: 500;">Active (Show on homepage)</label>
                    @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Update Testimonial
                    </button>
                    <a href="{{ route('admin.testimonials.index') }}" class="btn"
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
        function previewImage(input) {
            const previewDiv = document.getElementById('imagePreview');
            const previewImg = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewDiv.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                // Keep original image if no new file is selected, but usually change event means a file was selected or cleared
                previewImg.src = '#';
                previewDiv.style.display = 'none';
            }
        }
    </script>
@endpush