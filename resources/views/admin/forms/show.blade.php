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
                    <i data-feather="arrow-left"></i> Back to Forms
                </a>
                <a href="{{ route('forms.show.frontend', $form->slug) }}" target="_blank" class="btn btn-primary">
                    <i data-feather="external-link"></i> View Live Form
                </a>
            </div>
        </div>
        <div class="panel-body">
            @if($submissions->count() > 0)
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--border-color);">
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; width: 50px;">#</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Submitted Data</th>
                                <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $index => $submission)
                                <tr style="border-bottom: 1px solid var(--border-color); align-items: flex-start;">
                                    <td style="padding: 1rem; color: var(--text-secondary);">
                                        {{ $submissions->firstItem() + $index }}
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                                            @foreach($submission->data as $key => $value)
                                                <div
                                                    style="background-color: #f9fafb; padding: 0.75rem; border-radius: 6px; border: 1px solid var(--border-color);">
                                                    <strong
                                                        style="color: var(--text-secondary); font-size: 0.75rem; text-transform: uppercase;">{{ str_replace('_', ' ', $key) }}</strong>
                                                    <div style="margin-top: 0.25rem;">
                                                        @if(is_array($value))
                                                            {{ implode(', ', $value) }}
                                                        @elseif(is_string($value) && str_starts_with($value, 'submissions/'))
                                                            <a href="{{ Storage::url($value) }}" target="_blank" class="text-primary" style="display: flex; align-items: center; gap: 0.25rem; color: var(--primary-color); font-size: 0.875rem;">
                                                                <i data-feather="download" style="width: 14px; height: 14px;"></i> Download File
                                                            </a>
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div
                                            style="margin-top: 0.75rem; font-size: 0.75rem; color: var(--text-secondary); display: flex; gap: 1rem;">
                                            @if($submission->ip_address)
                                                <span><i data-feather="map-pin" style="width: 12px; height: 12px;"></i>
                                                    {{ $submission->ip_address }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td
                                        style="padding: 1rem; color: var(--text-secondary); white-space: nowrap; vertical-align: top;">
                                        <div>{{ $submission->created_at->format('M d, Y') }}</div>
                                        <div style="font-size: 0.75rem; margin-top: 0.25rem;">
                                            {{ $submission->created_at->format('h:i A') }}</div>
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
                <div style="text-align: center; padding: 3rem 1rem;">
                    <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                        <i data-feather="inbox" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                    </div>
                    <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--text-primary); margin-bottom: 0.5rem;">No
                        submissions yet</h3>
                    <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">There are no recorded submissions for this
                        form.</p>
                </div>
            @endif
        </div>
    </div>
@endsection