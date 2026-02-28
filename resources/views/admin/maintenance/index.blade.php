@extends('admin.layouts.app')

@section('title', 'Maintenance Mode')

@push('styles')
    <style>
        .maintenance-container {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            padding: 30px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .status-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .status-icon.active {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .status-icon.inactive {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-header {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .status-desc {
            color: var(--text-secondary);
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .action-btn {
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-off {
            background: #ef4444;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.3);
        }

        .btn-off:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-on {
            background: #10b981;
            color: white;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
        }

        .btn-on:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .secret-box {
            margin-top: 30px;
            background: var(--bg-body);
            padding: 20px;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            text-align: left;
        }

        .secret-box h4 {
            color: var(--text-primary);
            font-size: 1.1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .secret-url {
            background: var(--bg-surface);
            padding: 12px;
            border-radius: 8px;
            font-family: monospace;
            color: var(--primary-color);
            word-break: break-all;
            border: 1px dashed var(--border-color);
            user-select: all;
        }

        .secret-warning {
            font-size: 0.85rem;
            color: #ef4444;
            margin-top: 10px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <div class="maintenance-container">
        @php
            $schoolLogo = \App\Models\Setting::where('key', 'school_logo')->value('value');
        @endphp

        @if($schoolLogo)
            <div style="margin-bottom: 25px;">
                <img src="{{ \Illuminate\Support\Facades\Storage::url($schoolLogo) }}" alt="Logo"
                    style="height: 60px; width: auto;">
            </div>
        @endif

        @if ($isDown)
            <div class="status-icon active">
                <i data-feather="alert-triangle" style="width: 40px; height: 40px;"></i>
            </div>
            <h2 class="status-header">Maintenance Mode is ACTIVE</h2>
            <p class="status-desc">
                Your website is currently offline to the public. Visitors will see a "Service Unavailable" page. You can safely
                perform updates or script changes.
            </p>

            <form action="{{ route('admin.maintenance.toggle') }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="up">
                <button type="submit" class="action-btn btn-on">
                    <i data-feather="power"></i> Disable Maintenance Mode
                </button>
            </form>

            @if(session('maintenance_secret'))
                <div class="secret-box">
                    <h4><i data-feather="key" style="width: 18px; height: 18px;"></i> Admin Bypass Link</h4>
                    <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 15px;">
                        If you get logged out or need to test the site via an Incognito window, use this secret link to bypass the
                        maintenance screen.
                    </p>
                    <div class="secret-url">
                        {{ url('/' . session('maintenance_secret')) }}
                    </div>
                    <p class="secret-warning">
                        Copy this link now! It will disappear when you refresh this page.
                    </p>
                </div>
            @endif

        @endif

        <div class="maintenance-tools" style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 30px; text-align: left;">
            <h3 style="margin-bottom: 20px; font-size: 1.2rem; color: var(--text-primary);"><i data-feather="tool" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 8px;"></i> System Tools</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px;">
                <form action="{{ route('admin.maintenance.clearCache') }}" method="POST">
                    @csrf
                    <button type="submit" class="action-btn" style="width: 100%; justify-content: center; background: var(--bg-body); border: 1px solid var(--border-color); color: var(--text-primary);">
                        <i data-feather="trash-2"></i> Clear Cache
                    </button>
                </form>

                <form action="{{ route('admin.maintenance.optimize') }}" method="POST">
                    @csrf
                    <button type="submit" class="action-btn" style="width: 100%; justify-content: center; background: var(--bg-body); border: 1px solid var(--border-color); color: var(--text-primary);">
                        <i data-feather="zap"></i> Optimize System
                    </button>
                </form>
            </div>

            <h3 style="margin-bottom: 20px; font-size: 1.2rem; color: var(--text-primary);"><i data-feather="upload-cloud" style="width: 18px; height: 18px; vertical-align: middle; margin-right: 8px;"></i> Software Update</h3>
            <div class="secret-box" style="margin-top: 0;">
                <p class="text-secondary" style="font-size: 0.9rem; margin-bottom: 15px;">
                    Upload a <strong>.zip</strong> file containing the updated script. This will extract files to the root directory and run migrations automatically.
                </p>
                <form action="{{ route('admin.maintenance.uploadUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <input type="file" name="update_file" accept=".zip" required style="width: 100%; padding: 10px; background: var(--bg-surface); border: 1px dashed var(--border-color); border-radius: 8px; color: var(--text-primary);">
                    </div>
                    <button type="submit" class="action-btn btn-on" style="width: 100%; justify-content: center;" onclick="return confirm('WARNING: Uploading an update will overwrite existing files. Make sure you have a backup. Proceed?');">
                        <i data-feather="upload"></i> Upload & Install Update
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endsection