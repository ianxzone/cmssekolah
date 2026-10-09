@extends('admin.layouts.app')

@section('title', 'Edit Tag')

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Edit Tag: {{ $tag->name }}</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 1.5rem;">
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Tag</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $tag->name) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="slug" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Slug URL</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $tag->slug) }}" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #4b5563; padding-top: 1rem; border-top: 1px solid #e5e7eb;">Pengaturan SEO</label>

                    <label for="description" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1rem;">{{ old('description', $tag->description) }}</textarea>

                    <label for="meta_title" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $tag->meta_title) }}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1rem;">

                    <label for="meta_description" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 1rem;">{{ old('meta_description', $tag->meta_description) }}</textarea>

                    <label for="meta_keywords" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem;">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $tag->meta_keywords) }}" placeholder="pisahkan dengan koma" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border-color); border-radius: 8px;">
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
