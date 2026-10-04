@extends('admin.layouts.app')

@section('title', 'Form Submissions')

@section('content')
    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 class="panel-title">Submissions: {{ $form->title }}</h2>
                <div style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 0.25rem;">Total Submissions:
                    {{ $submissions->total() }}</div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.forms.index') }}" class="btn"
                    style="background-color: var(--bg-body); border-color: var(--border-color);">
                    <i data-feather="arrow-left"></i> Back
                </a>
                <a href="{{ route('admin.forms.export', $form->id) }}" class="btn" style="background-color: #10b981; color: white; border: none;">
                    <i data-feather="download"></i> Export CSV
                </a>
                <a href="{{ route('forms.show.frontend', $form->slug) }}" target="_blank" class="btn btn-primary">
                    <i data-feather="external-link"></i> Live Form
                </a>
            </div>
        </div>
        <div class="panel-body">
            @if($submissions->count() > 0)
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color); background: #f8fafc;">
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600; width: 50px;">#</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600;">Ringkasan Data</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600; width: 200px;">Waktu & IP</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 600; text-align: right; width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $index => $submission)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td style="padding: 1rem; color: var(--text-secondary); vertical-align: top;">
                                        {{ $submissions->firstItem() + $index }}
                                    </td>
                                    <td style="padding: 1rem; vertical-align: top;">
                                        @php
                                            $previewData = array_slice($submission->data, 0, 3, true);
                                        @endphp
                                        <div style="display: flex; flex-direction: column; gap: 6px;">
                                            @foreach($previewData as $key => $value)
                                                <div style="line-height: 1.4;">
                                                    <span style="color: #64748b; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">{{ str_replace('_', ' ', $key) }}:</span>
                                                    <span style="color: #0f172a; font-weight: 500;">
                                                        @if(is_array($value))
                                                            {{ Str::limit(implode(', ', $value), 40) }}
                                                        @elseif(is_string($value) && str_starts_with($value, 'submissions/'))
                                                            [Berkas Terlampir]
                                                        @else
                                                            {{ Str::limit($value, 40) }}
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                            
                                            @if(count($submission->data) > 3)
                                                <div style="font-size: 0.75rem; color: #3b82f6; font-weight: 600; margin-top: 4px;">
                                                    + {{ count($submission->data) - 3 }} kolom lainnya
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Hidden Full Data for Modal -->
                                        <div id="submission-data-{{ $submission->id }}" style="display:none;">
                                            <div style="display: grid; gap: 1rem;">
                                                @foreach($submission->data as $key => $value)
                                                    <div style="padding-bottom: 0.75rem; border-bottom: 1px dashed #cbd5e1;">
                                                        <div style="color: #64748b; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">{{ str_replace('_', ' ', $key) }}</div>
                                                        <div style="color: #0f172a; font-size: 0.95rem; font-weight: 500; word-break: break-word;">
                                                            @if(is_array($value))
                                                                {{ implode(', ', $value) }}
                                                            @elseif(is_string($value) && str_starts_with($value, 'submissions/'))
                                                                <a href="{{ route('admin.forms.download', [$form, 'path' => $value]) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 4px; color: #2563eb; background: #eff6ff; padding: 4px 10px; border-radius: 6px; text-decoration: none;">
                                                                    <i data-feather="download" style="width: 14px; height: 14px;"></i> Unduh Berkas
                                                                </a>
                                                            @else
                                                                {!! nl2br(e($value)) !!}
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: var(--text-secondary); vertical-align: top;">
                                        <div style="font-weight: 600; color: #0f172a;">{{ $submission->created_at->format('d M Y') }}</div>
                                        <div style="font-size: 0.8rem; margin-top: 2px;">{{ $submission->created_at->format('H:i') }} WIB</div>
                                        @if($submission->ip_address)
                                            <div style="font-size: 0.75rem; margin-top: 8px; display: flex; align-items: center; gap: 4px; color: #64748b;">
                                                <i data-feather="map-pin" style="width: 12px; height: 12px;"></i> {{ $submission->ip_address }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem; text-align: right; vertical-align: top;">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="openSubmissionModal('{{ $submission->id }}')" style="padding: 6px 12px; font-size: 0.8rem; background: #0ea5e9; border: none;">
                                            <i data-feather="eye" style="width: 14px; height: 14px;"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 2rem;">
                    {{ $submissions->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 4rem 1rem; background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1;">
                    <div style="color: #94a3b8; margin-bottom: 1rem;">
                        <i data-feather="inbox" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem;">Belum ada data masuk</h3>
                    <p style="color: #64748b; margin-bottom: 1.5rem; font-size: 0.9rem;">Formulir ini belum menerima kiriman data apa pun.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Submission -->
    <div id="subModalBackdrop" style="display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.6); z-index: 1050; align-items: center; justify-content: center; padding: 1rem; backdrop-filter: blur(4px);">
        <div style="background: white; border-radius: 16px; width: 100%; max-width: 650px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: modalZoomIn 0.2s ease-out;">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="file-text" style="color: #3b82f6;"></i> Detail Kiriman Data
                </h3>
                <button onclick="closeSubmissionModal()" style="background: none; border: none; cursor: pointer; color: #64748b; padding: 4px; border-radius: 6px; transition: background 0.2s;"><i data-feather="x"></i></button>
            </div>
            <div id="subModalContent" style="padding: 1.5rem; overflow-y: auto; flex: 1;">
                <!-- content injected here -->
            </div>
            <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; text-align: right; background: #f8fafc; border-radius: 0 0 16px 16px;">
                <button onclick="closeSubmissionModal()" class="btn" style="background: white; border: 1px solid #cbd5e1; color: #475569; font-weight: 600;">Tutup</button>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalZoomIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        #subModalBackdrop button[onclick="closeSubmissionModal()"]:hover {
            background: #f1f5f9;
        }
    </style>

    <script>
        function openSubmissionModal(id) {
            const content = document.getElementById('submission-data-' + id).innerHTML;
            document.getElementById('subModalContent').innerHTML = content;
            document.getElementById('subModalBackdrop').style.display = 'flex';
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
        function closeSubmissionModal() {
            document.getElementById('subModalBackdrop').style.display = 'none';
        }
        // Close modal when clicking outside
        document.getElementById('subModalBackdrop').addEventListener('click', function(e) {
            if (e.target === this) closeSubmissionModal();
        });
    </script>
@endsection