@extends('install.layout')

@section('content')
    <div class="setup-steps">
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot active">3</div>
        <div class="step-dot">4</div>
        <div class="step-dot">5</div>
    </div>

    <div class="setup-title">Konfigurasi Database</div>
    <p class="setup-description">
        Masukkan informasi koneksi database Anda untuk melanjutkan proses instalasi.
    </p>

    <form action="{{ route('install.environment.save') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Aplikasi</label>
            <input type="text" name="app_name" class="form-control" value="CMS Sekolah SDIT" required>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px;">
            <div class="form-group">
                <label>Link Database (Host)</label>
                <input type="text" name="db_host" class="form-control" value="127.0.0.1" required>
            </div>
            <div class="form-group">
                <label>Port</label>
                <input type="text" name="db_port" class="form-control" value="3306" required>
            </div>
        </div>

        <div class="form-group">
            <label>Nama Database</label>
            <input type="text" name="db_database" class="form-control" placeholder="Nama Database" required>
        </div>

        <div class="form-group">
            <label>Username DB</label>
            <input type="text" name="db_username" class="form-control" value="root" required>
        </div>

        <div class="form-group">
            <label>Password DB</label>
            <input type="password" name="db_password" class="form-control" placeholder="Kosongkan jika tidak ada">
        </div>

        <button type="submit" class="btn-setup">
            Simpan & Instal <i data-feather="save"></i>
        </button>
    </form>
@endsection