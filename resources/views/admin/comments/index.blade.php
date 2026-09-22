@extends('admin.layouts.app')

@section('title', 'Moderasi Komentar')

@push('styles')
<style>
    .filter-pills {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 1.25rem;
    }
    .filter-pill {
        padding: 0.4rem 0.85rem;
        border-radius: 50px;
        font-size: 0.8125rem;
        font-weight: 600;
        text-decoration: none;
        color: var(--text-secondary);
        background: #f1f5f9;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .filter-pill:hover, .filter-pill.active {
        background: var(--primary-color);
        color: white;
    }
    .filter-pill .count {
        background: rgba(0,0,0,0.08);
        padding: 1px 6px;
        border-radius: 10px;
        font-size: 0.72rem;
    }
    .filter-pill.active .count {
        background: rgba(255,255,255,0.25);
    }
    .filter-pill.pending.active {
        background: #d97706;
    }
    .search-input {
        padding: 0.55rem 0.875rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        width: 260px;
        max-width: 100%;
        font-size: 0.84rem;
    }
    .search-input:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    .comment-card-table th {
        padding: 0.85rem 1rem;
        font-size: 0.8125rem;
        color: var(--text-secondary);
        font-weight: 600;
        border-bottom: 2px solid var(--border-color);
        text-align: left;
    }
    .comment-card-table td {
        padding: 1rem;
        font-size: 0.85rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: top;
    }
    .action-btn {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s;
    }
    .action-btn.approve { background: #dcfce7; color: #15803d; }
    .action-btn.approve:hover { background: #bbf7d0; }
    .action-btn.unapprove { background: #fef3c7; color: #b45309; }
    .action-btn.unapprove:hover { background: #fde68a; }
    .action-btn.spam { background: #fee2e2; color: #b91c1c; }
    .action-btn.spam:hover { background: #fecaca; }
    .action-btn.delete { background: #f1f5f9; color: #64748b; }
    .action-btn.delete:hover { background: #fee2e2; color: #b91c1c; }
</style>
@endpush

@section('content')
<div class="panel">
    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 class="panel-title">Moderasi Komentar Artikel</h2>
            <p style="font-size: 0.8125rem; color: var(--text-secondary); margin: 0.25rem 0 0 0;">
                Kelola dan setujui komentar pembaca sebelum ditampilkan ke publik.
            </p>
        </div>
        <form method="GET" action="{{ route('admin.comments.index') }}">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" class="search-input" placeholder="Cari nama, email, isi..." value="{{ request('search') }}">
        </form>
    </div>

    <div class="panel-body">
        <!-- Filter Tabs -->
        <div class="filter-pills">
            <a href="{{ route('admin.comments.index') }}" class="filter-pill {{ request('status') === null || request('status') === '' ? 'active' : '' }}">
                Semua <span class="count">{{ $counts['all'] }}</span>
            </a>
            <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="filter-pill pending {{ request('status') === 'pending' ? 'active' : '' }}">
                <i data-feather="clock" style="width: 13px; height: 13px;"></i>
                Pending Review <span class="count">{{ $counts['pending'] }}</span>
            </a>
            <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" class="filter-pill {{ request('status') === 'approved' ? 'active' : '' }}">
                <i data-feather="check-circle" style="width: 13px; height: 13px;"></i>
                Disetujui <span class="count">{{ $counts['approved'] }}</span>
            </a>
            <a href="{{ route('admin.comments.index', ['status' => 'spam']) }}" class="filter-pill {{ request('status') === 'spam' ? 'active' : '' }}">
                <i data-feather="alert-octagon" style="width: 13px; height: 13px;"></i>
                Spam <span class="count">{{ $counts['spam'] }}</span>
            </a>
        </div>

        @if($comments->count() > 0)
            <div class="table-responsive">
                <table class="comment-card-table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="width: 220px;">Pengirim</th>
                            <th>Komentar</th>
                            <th style="width: 240px;">Pada Artikel</th>
                            <th style="width: 120px;">Status</th>
                            <th style="width: 160px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                            @php
                                $badge = $comment->status_badge;
                            @endphp
                            <tr onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                                <td>
                                    <div style="display: flex; align-items: flex-start; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8125rem; flex-shrink: 0;">
                                            {{ strtoupper(substr($comment->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text-primary);">{{ $comment->name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-secondary); display: flex; align-items: center; gap: 4px;">
                                                <i data-feather="mail" style="width: 11px; height: 11px;"></i> {{ $comment->email }}
                                            </div>
                                            @if($comment->phone)
                                                <div style="font-size: 0.75rem; color: #16a34a; margin-top: 2px; display: flex; align-items: center; gap: 4px;">
                                                    <i data-feather="phone" style="width: 11px; height: 11px;"></i>
                                                    @php
                                                        $cleanPhone = preg_replace('/[^0-9]/', '', $comment->phone);
                                                        $waPhone = str_starts_with($cleanPhone, '0') ? '62' . substr($cleanPhone, 1) : $cleanPhone;
                                                    @endphp
                                                    <a href="https://wa.me/{{ $waPhone }}" target="_blank" style="color: #16a34a; text-decoration: none; font-weight: 600;" title="Chat via WhatsApp">
                                                        {{ $comment->phone }}
                                                    </a>
                                                </div>
                                            @endif
                                            <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 2px;">{{ $comment->created_at->translatedFormat('d M Y, H:i') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="color: var(--text-primary); line-height: 1.5; word-break: break-word;">
                                        {{ $comment->content }}
                                    </div>
                                </td>
                                <td>
                                    @if($comment->post)
                                        <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank" style="color: var(--primary-color); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Lihat Artikel Live">
                                            {{ Str::limit($comment->post->title, 45) }}
                                            <i data-feather="external-link" style="width: 12px; height: 12px;"></i>
                                        </a>
                                    @else
                                        <span style="color: #94a3b8;">Artikel Dihapus</span>
                                    @endif
                                </td>
                                <td>
                                    <span style="display: inline-block; padding: 3px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 700; background: {{ $badge['bg'] }}; color: {{ $badge['color'] }};">
                                        {{ $badge['label'] }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 4px; justify-content: flex-end; flex-wrap: wrap;">
                                        @if($comment->status !== 'approved')
                                            <form method="POST" action="{{ route('admin.comments.status', $comment) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="action-btn approve" title="Setujui & Publikasikan">
                                                    <i data-feather="check" style="width: 13px; height: 13px;"></i> Setujui
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.comments.status', $comment) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="action-btn unapprove" title="Kembalikan ke Pending">
                                                    <i data-feather="clock" style="width: 13px; height: 13px;"></i> Pending
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Hapus Permanen">
                                                <i data-feather="trash-2" style="width: 13px; height: 13px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $comments->links() }}
            </div>
        @else
            <div style="text-align: center; padding: 3rem 1rem; color: var(--text-secondary);">
                <i data-feather="message-square" style="width: 44px; height: 44px; margin-bottom: 0.75rem; color: #cbd5e1;"></i>
                <p style="font-size: 0.95rem; font-weight: 500;">Tidak ada komentar yang ditemukan.</p>
            </div>
        @endif
    </div>
</div>
@endsection
