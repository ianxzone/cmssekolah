@extends('install.layout')

@section('content')
    <div class="setup-steps">
        <div class="step-dot active">1</div>
        <div class="step-dot">2</div>
        <div class="step-dot">3</div>
        <div class="step-dot">4</div>
        <div class="step-dot">5</div>
    </div>

    <div class="setup-title">Selamat datang di CMS Sekolah</div>
    <p class="setup-description">
        Terima kasih telah memilih CMS Sekolah by MATEK. Panduan ini akan membantu Anda mengonfigurasi website sekolah Anda
        hanya dalam beberapa menit.
    </p>

    <a href="{{ route('install.requirements') }}" class="btn-setup">
        Mulai Instalasi <i data-feather="arrow-right"></i>
    </a>
@endsection