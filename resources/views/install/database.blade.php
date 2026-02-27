@extends('install.layout')

@section('content')
    <div class="setup-steps">
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot completed"><i data-feather="check" style="width:14px;"></i></div>
        <div class="step-dot active">4</div>
        <div class="step-dot">5</div>
    </div>

    <div class="setup-title">Memulai Instalasi...</div>
    <p class="setup-description">
        Sistem sedang menyiapkan database dan data awal untuk website sekolah Anda. Harap jangan tutup halaman ini.
    </p>

    <div style="background: #f1f5f9; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 20px;">
        <div id="progress-bar" style="width: 0%; height: 100%; background: var(--accent); transition: width 0.5s ease;">
        </div>
    </div>

    <div id="status-text" style="text-align: center; font-size: 0.85rem; color: var(--text-muted);">
        Menghubungkan ke database...
    </div>

    <div id="error-box"
        style="display: none; background: #fee2e2; color: var(--error); padding: 15px; border-radius: 10px; margin-top: 20px; font-size: 0.85rem;">
    </div>

    <a href="{{ route('install.admin') }}" id="btn-next" class="btn-setup" style="display: none; margin-top: 30px;">
        Lanjutkan ke Akun Admin <i data-feather="arrow-right"></i>
    </a>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const bar = document.getElementById('progress-bar');
                const status = document.getElementById('status-text');
                const errorBox = document.getElementById('error-box');
                const btnNext = document.getElementById('btn-next');

                setTimeout(() => {
                    bar.style.width = '30%';
                    status.innerText = 'Menjalankan Migrasi Tabel...';

                    fetch("{{ route('install.run') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                bar.style.width = '100%';
                                status.innerText = 'Instalasi Database Selesai!';
                                btnNext.style.display = 'flex';
                            } else {
                                bar.style.background = 'var(--error)';
                                status.innerText = 'Terjadi Kesalahan';
                                errorBox.innerText = data.message;
                                errorBox.style.display = 'block';
                            }
                        })
                        .catch(err => {
                            bar.style.background = 'var(--error)';
                            status.innerText = 'Error Koneksi';
                            errorBox.innerText = 'Gagal menghubungi server. Pastikan kredensial DB Anda benar.';
                            errorBox.style.display = 'block';
                        });
                }, 1000);
            });
        </script>
    @endpush
@endsection