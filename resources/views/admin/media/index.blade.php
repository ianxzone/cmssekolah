@extends('admin.layouts.app')

@section('title', 'Media Manager')

@push('styles')
    <style>
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .media-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }

        .media-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .media-preview {
            aspect-ratio: 1;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .media-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .media-preview .file-icon {
            font-size: 3rem;
            color: var(--text-secondary);
            opacity: 0.5;
        }

        .media-info {
            padding: 0.75rem;
        }

        .media-name {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.25rem;
        }

        .media-meta {
            font-size: 0.75rem;
            color: var(--text-secondary);
            display: flex;
            justify-content: space-between;
        }

        .media-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            gap: 0.25rem;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .media-card:hover .media-actions {
            opacity: 1;
        }

        .action-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            cursor: pointer;
            box-shadow: var(--shadow-sm);
        }

        .action-btn:hover {
            background: #f9fafb;
        }

        .action-btn.delete:hover {
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .upload-zone {
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            background: #f9fafb;
            transition: border-color 0.2s, background 0.2s;
            cursor: pointer;
            margin-bottom: 2rem;
        }

        .upload-zone:hover {
            border-color: var(--primary-color);
            background: #f5f7ff;
        }
    </style>
@endpush

@section('content')
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">Media Manager</h2>
        </div>
        <div class="panel-body">
            <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" id="upload-form">
                @csrf
                <div class="upload-zone" onclick="document.getElementById('file-input').click()">
                    <div style="color: var(--primary-color); margin-bottom: 1rem;">
                        <i data-feather="upload-cloud" style="width: 48px; height: 48px;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">Click to upload or drag and
                        drop</h3>
                    <p style="color: var(--text-secondary); font-size: 0.875rem;">PNG, JPG, GIF, PDF up to 10MB</p>
                    <input type="file" id="file-input" name="file" style="display: none;" onchange="this.form.submit()">
                </div>
            </form>

            @if($media->count() > 0)
                <div class="media-grid">
                    @foreach($media as $item)
                        <div class="media-card">
                            <div class="media-actions">
                                <button class="action-btn" onclick="copyUrl('{{ $item->url }}')" title="Copy URL">
                                    <i data-feather="link" style="width: 14px; height: 14px;"></i>
                                </button>
                                <form action="{{ route('admin.media.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Delete">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="media-preview">
                                @if($item->is_image)
                                    <img src="{{ $item->url }}" alt="{{ $item->name }}">
                                @else
                                    <div class="file-icon">
                                        <i data-feather="file-text"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="media-info">
                                <div class="media-name" title="{{ $item->name }}">{{ $item->name }}</div>
                                <div class="media-meta">
                                    <span>{{ strtoupper(explode('/', $item->mime_type)[1] ?? 'FILE') }}</span>
                                    <span>{{ number_format($item->size / 1024, 1) }} KB</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 2rem;">
                    {{ $media->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 4rem 1rem;">
                    <div style="color: var(--text-secondary); margin-bottom: 1rem; opacity: 0.3;">
                        <i data-feather="image" style="width: 64px; height: 64px;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 500;">No files uploaded yet</h3>
                    <p style="color: var(--text-secondary);">Upload your first multimedia file above.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyUrl(url) {
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copied to clipboard!');
            });
        }
    </script>
@endpush