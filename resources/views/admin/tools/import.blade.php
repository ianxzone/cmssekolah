@extends('admin.layouts.app')

@section('title', 'Import dari WordPress')
@section('header', 'Import Content')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">WordPress WXR Import (XML)</h3>
    </div>
    <div class="card-body">
        <p class="mb-4 text-secondary">
            Gunakan fitur ini untuk memigrasi konten dari website WordPress Anda. 
            Modul ini akan mengimpor <strong>Postingan, Halaman, Kategori, dan Tag</strong>. 
            Gambar juga akan didownload otomatis ke server jika link gambar masih aktif.
        </p>

        <form action="{{ route('admin.tools.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <label class="form-label">Pilih File XML (WXR)</label>
                <input type="file" name="xml_file" class="form-control" accept=".xml" required>
                <small class="text-secondary">File ekspor dari WordPress (Tools -> Export)</small>
            </div>

            <div class="alert alert-info py-2" style="font-size: 0.9rem;">
                <strong>Catatan:</strong> Ukuran file besar mungkin memerlukan waktu proses lebih lama. Jangan tutup halaman ini saat proses berjalan.
            </div>

            <button type="submit" class="btn btn-primary">
                <i data-feather="upload" style="width: 16px; height: 16px; margin-right: 5px;"></i> Mulai Import Sekarang
            </button>
        </form>

        @if(session('import_logs'))
            <div class="mt-5">
                <h4 class="mb-3">Log Eksekusi Terakhir:</h4>
                <div style="max-height: 300px; overflow-y: auto; background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; font-family: monospace; font-size: 0.85rem;">
                    @foreach(session('import_logs') as $log)
                        <div class="mb-1 text-success">> {{ $log }}</div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
