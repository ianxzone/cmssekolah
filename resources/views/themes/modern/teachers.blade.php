@extends('theme::layouts.app')

@section('title', 'Guru & Tenaga Kependidikan - ' . ($settings['school_name'] ?? config('app.name')))

@push('styles')
    <style>
        .teachers-page {
            padding: 0 20px 80px;
            margin: -60px auto 0;
            max-width: 1200px;
            position: relative;
            z-index: 10;
        }

        .page-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 800;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .teachers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .teacher-card {
            background: var(--bg-surface);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            text-align: center;
            padding: 30px;
            border: 1px solid var(--border-color);
        }

        .teacher-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .teacher-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            overflow: hidden;
            border: 4px solid var(--primary-color);
        }

        .teacher-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .teacher-info h3 {
            font-size: 1.25rem;
            color: var(--text-primary);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .teacher-info p {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@section('hero')
    @php
        $heroBg = $settings['hero_bg_image'] ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=1920';
        if (!Str::startsWith($heroBg, ['http://', 'https://', 'data:'])) {
            $heroBg = Storage::url($heroBg);
        }
    @endphp
    <section class="subpage-hero" style="background-image: url('{{ $heroBg }}');">
        <div class="subpage-hero-overlay"></div>
        <div class="container">
            <h1>Guru & Tenaga Kependidikan</h1>
            <div class="subpage-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <i data-feather="chevron-right" style="width: 14px;"></i>
                <span>Guru & Staff</span>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="teachers-page">
        {{-- Old page-header removed --}}

        <div class="teachers-grid">
            @php
                $teachers = json_decode($settings['teachers_data'] ?? '[]', true);
                $fallbackImg = asset('images/default-avatar.png');
                $resolveAsset = function ($path, $default) {
                    if (empty($path))
                        return $default;
                    if (filter_var($path, FILTER_VALIDATE_URL))
                        return $path;
                    return \Illuminate\Support\Facades\Storage::url($path);
                };
            @endphp

            @forelse($teachers as $t)
                <div class="teacher-card">
                    <div class="teacher-img">
                        <img src="{{ $resolveAsset($t['image'] ?? '', 'https://placehold.co/300x300?text=Guru') }}"
                            alt="{{ $t['name'] ?? 'Guru' }}" onerror="this.src='https://placehold.co/300x300?text=User'">
                    </div>
                    <div class="teacher-info">
                        <h3>{{ $t['name'] }}</h3>
                        <p>{{ $t['role'] }}</p>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 100px 0;">
                    <p style="color: var(--text-secondary);">Data guru belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection