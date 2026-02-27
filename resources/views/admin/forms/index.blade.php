@extends('admin.layouts.app')

@section('title', 'Manage Forms')

@section('content')
<div class="panel">
    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="panel-title">All Forms</h2>
        <a href="{{ route('admin.forms.create') }}" class="btn btn-primary">
            <i data-feather="plus"></i> Create New Form
        </a>
    </div>
    <div class="panel-body">
        @if($forms->count() > 0)
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color);">
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Form Title</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Status</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500;">Submissions</th>
                            <th style="padding: 1rem; color: var(--text-secondary); font-weight: 500; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forms as $form)
                            <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 1rem;">
                                    <div style="font-weight: 500;">{{ $form->title }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 0.25rem;">/formulir/{{ $form->slug }}</div>
                                </td>
                                <td style="padding: 1rem;">
                                    @if($form->is_active)
                                        <span style="background-color: rgba(16, 185, 129, 0.1); color: var(--success-color); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Active</span>
                                    @else
                                        <span style="background-color: rgba(239, 68, 68, 0.1); color: var(--danger-color); padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Draft</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem;">
                                    <span style="font-weight: 600; color: var(--primary-color);">{{ $form->submissions_count }}</span>
                                </td>
                                <td style="padding: 1rem; text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="{{ route('admin.forms.show', $form) }}" style="padding: 0.5rem; color: var(--success-color); background-color: rgba(16, 185, 129, 0.1); border-radius: 6px;" title="View Submissions">
                                            <i data-feather="inbox" style="width: 18px; height: 18px;"></i>
                                        </a>
                                        <a href="{{ route('forms.show.frontend', $form->slug) }}" target="_blank" style="padding: 0.5rem; color: var(--text-secondary); border-radius: 6px;" title="View Live Form">
                                            <i data-feather="external-link" style="width: 18px; height: 18px;"></i>
                                        </a>
                                        <a href="{{ route('admin.forms.edit', $form) }}" style="padding: 0.5rem; color: var(--primary-color); background-color: rgba(79, 70, 229, 0.1); border-radius: 6px;" title="Edit">
                                            <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                                        </a>
                                        <form action="{{ route('admin.forms.destroy', $form) }}" method="POST" onsubmit="return confirm('WARNING: Deleting this form will also delete ALL its submissions. Are you sure?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding: 0.5rem; color: var(--danger-color); background-color: rgba(239, 68, 68, 0.1); border: none; border-radius: 6px; cursor: pointer;" title="Delete">
                                                <i data-feather="trash-2" style="width: 18px; height: 18px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 2rem;">
                {{ $forms->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem 1rem;">
                <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                    <i data-feather="inbox" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--text-primary); margin-bottom: 0.5rem;">No forms found</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Create a form to start collecting data.</p>
                <a href="{{ route('admin.forms.create') }}" class="btn btn-primary">
                    <i data-feather="plus"></i> Create New Form
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
