@extends('install.layout')

@section('content')
    <div class="setup-steps">
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot active">5</div>
    </div>

    <div class="setup-title">Akun Administrator</div>
    <p class="setup-description">
        Terakhir, buatlah akun administrator utama untuk mengelola website sekolah Anda.
    </p>

    <form action="{{ route('install.admin.save') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Admin MATEK" required>
        </div>

        <div class="form-group">
            <label>Email Admin</label>
            <input type="email" name="email" class="form-control" placeholder="admin@sekolah.sch.id" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Min. 8 Karakter" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
        </div>

        <button type="submit" class="btn-setup">
            Selesaikan Instalasi <i data-feather="lock"></i>
        </button>
    </form>
@endsection