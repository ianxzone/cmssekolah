@extends('install.layout')

@section('content')
    <div class="setup-steps">
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot active">2</div>
        <div class="step-dot">3</div>
        <div class="step-dot">4</div>
        <div class="step-dot">5</div>
    </div>

    <div class="setup-title">Pemeriksaan Sistem</div>
    <p class="setup-description">
        Kami sedang memeriksa apakah server Anda memenuhi persyaratan minimum untuk menjalankan CMS Sekolah.
    </p>

    <div style="margin-bottom: 30px;">
        @php $allPass = true; @endphp
        @foreach($requirements as $label => $pass)
            @php if (!$pass)
            $allPass = false; @endphp
            <div class="requirement-item">
                <span>{{ $label }}</span>
                <i data-feather="{{ $pass ? 'check-circle' : 'x-circle' }}"
                    class="{{ $pass ? 'status-ok' : 'status-fail' }}"></i>
            </div>
        @endforeach
    </div>

    @if($allPass)
        <a href="{{ route('install.environment') }}" class="btn-setup">
            Lanjutkan <i data-feather="arrow-right"></i>
        </a>
    @else
        <button class="btn-setup" disabled style="opacity: 0.5; cursor: not-allowed;">
            Perbaiki Error Untuk Lanjut
        </button>
    @endif
@endsection