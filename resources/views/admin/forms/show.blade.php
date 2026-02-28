@extends('admin.layouts.app')

@section('title', 'Form Submissions')

@section('content')
    <style>
        .submission-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s;
            margin-bottom: 1rem;
        }

        .submission-card:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-md);
        }

        .data-preview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            padding: 1rem;
            font-size: 0.875rem;
        }

        .preview-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .preview-label {
            color: var(--text-secondary);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            font-weight: 600;
        }

        .preview-value {
            color: var(--text-primary);
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Modal Styles - More Robust Centering */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            /* Controlled by JS flex */
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
        }

        .modal-container {
            background: var(--bg-surface);
            border-radius: 16px;
            width: 100%;
            max-width: 650px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.25s ease-out;
            position: relative;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background: var(--bg-body);
            border-top: 1px solid var(--border-color);
            border-radius: 0 0 16px 16px;
            text-align: right;
        }

        .meta-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            background: var(--bg-body);
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.75rem;
        }
    </style>

    <div class="panel">
        <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h2 class="panel-title">Submissions: {{ $form->title }}</h2>
                <div style="font-size: 0.875rem; color: var(--text-secondary); margin-top: 0.25rem;">Total Submissions:
                    {{ $submissions->total() }}
                </div>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('admin.forms.index') }}" class="btn"
                    style="background-color: var(--bg-body); border-color: var(--border-color);">
                    <i data-feather="arrow-left"></i> Back
                </a>
                <a href="{{ route('forms.show.frontend', $form->slug) }}" target="_blank" class="btn btn-primary">
                    <i data-feather="external-link"></i> Live Form
                </a>
                <a href="{{ route('admin.forms.export', $form) }}" class="btn" style="background-color: #10b981; border-color: #10b981; color: white;">
                    <i data-feather="download"></i> Export Excel
                </a>

            </div>
        </div>
        <div class="panel-body">
            @if($submissions->count() > 0)
                <div style="display: flex; flex-direction: column;">
                    @foreach($submissions as $index => $submission)
                            <div class="submission-card">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background: var(--bg-body); border-bottom: 1px solid var(--border-color);">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <span
                                            style="font-weight: 600; color: var(--text-secondary);">#{{ $submissions->firstItem() + $index }}</span>
                                        <span style="font-size: 0.8125rem; color: var(--text-secondary);">
                                            <i data-feather="calendar" style="width: 14px; height: 14px; vertical-align: middle;"></i>
                                            {{ $submission->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                    <button onclick="showDetails({{ $submission->id }})" class="btn"
                                        style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: var(--bg-surface); font-weight: 600;">
                                        <i data-feather="maximize-2" style="width: 13px; height: 13px;"></i> Lihat Detail
                                    </button>
                                </div>
                                <div class="data-preview">
                                    @php $limit = 4;
                                    $count = 0; @endphp
                                    @foreach($submission->data as $key => $value)
                                        @if($count < $limit)
                                            <div class="preview-item">
                                                <span class="preview-label">{{ str_replace(['_', '-'], ' ', $key) }}</span>
                                                <span class="preview-value">
                                                    @if(is_array($value))
                                                        {{ implode(', ', $value) }}
                                                    @else
                                                        {{ Str::limit($value, 40) }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                        @php $count++; @endphp
                                    @endforeach
                                    @if(count($submission->data) > $limit)
                                        <div class="preview-item" style="justify-content: center; align-items: center;">
                                            <span
                                                style="font-size: 0.7rem; color: var(--primary-color); font-weight: 600;">+{{ count($submission->data) - $limit }}
                                                Bidang Lainnya</span>
                                        </div>
                                    @endif
                                </div>
                                <!-- Hidden JSON for Modal -->
                                <script id="submission-{{ $submission->id }}" type="application/json">
                                                {!! json_encode([
                            'id' => $submissions->firstItem() + $index,
                            'date' => $submission->created_at->format('l, d F Y - H:i'),
                            'ip' => $submission->ip_address,
                            'data' => $submission->data
                        ]) !!}
                                            </script>
                            </div>
                    @endforeach
                </div>

                <div style="margin-top: 1.5rem;">
                    {{ $submissions->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 4rem 1rem; opacity: 0.5;">
                    <i data-feather="inbox" style="width: 48px; height: 48px; margin-bottom: 1rem;"></i>
                    <h3>Belum ada kiriman data</h3>
                </div>
            @endif
        </div>
    </div>

    <!-- Final Robust Modal -->
    <div id="detailsModal" class="modal-overlay" onclick="closeModal()">
        <div class="modal-container" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h3 style="margin: 0;">Detail Data #<span id="modalId"></span></h3>
                <button onclick="closeModal()"
                    style="background:none; border:none; cursor:pointer; color:var(--text-secondary); font-size:1.5rem; line-height:1;">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content -->
            </div>
            <div class="modal-footer">
                <button onclick="closeModal()" class="btn btn-primary" style="padding: 0.5rem 1.5rem;">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showDetails(id) {
            const raw = document.getElementById('submission-' + id).textContent;
            const submission = JSON.parse(raw);

            document.getElementById('modalId').textContent = submission.id;
            const body = document.getElementById('modalBody');
            body.innerHTML = '';

            // Meta
            let metaHtml = `
                    <div class="meta-box">
                        <div><strong style="color:var(--text-secondary); display:block; margin-bottom:2px;">TANGGAL</strong>${submission.date}</div>
                        <div><strong style="color:var(--text-secondary); display:block; margin-bottom:2px;">ALAMAT IP</strong>${submission.ip || '-'}</div>
                    </div>
                `;

            // Content
            let dataHtml = '<div style="display:flex; flex-direction:column; gap:1.25rem;">';
            Object.entries(submission.data).forEach(([key, value]) => {
                let displayValue = '';
                if (Array.isArray(value)) {
                    displayValue = value.join(', ');
                } else if (typeof value === 'string' && value.startsWith('submissions/')) {
                    displayValue = `<a href="/storage/${value}" target="_blank" style="color:var(--primary-color); font-weight:600;">Lihat Lampiran</a>`;
                } else {
                    displayValue = value || '-';
                }

                dataHtml += `
                        <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 0.8rem;">
                            <label style="display:block; color:var(--text-secondary); font-size:0.7rem; text-transform:uppercase; font-weight:700; margin-bottom:0.3rem;">${key.replace(/[_-]/g, ' ')}</label>
                            <div style="font-weight:500; color:var(--text-primary); line-height:1.5;">${displayValue}</div>
                        </div>
                    `;
            });
            dataHtml += '</div>';

            body.innerHTML = metaHtml + dataHtml;

            const modal = document.getElementById('detailsModal');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Reset scroll body modal
            document.getElementById('modalBody').scrollTop = 0;
        }

        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close on ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
@endsection