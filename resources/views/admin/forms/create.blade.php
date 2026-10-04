@extends('admin.layouts.app')

@section('title', 'Buat Form Baru')

@push('styles')
    <style>
        .form-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            letter-spacing: 0.3px;
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #0f172a;
            background: #ffffff;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .text-danger {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 0.35rem;
            display: block;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        /* Modern Toggle */
        .modern-toggle-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin-top: 2rem;
        }
        
        .modern-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }
        
        .modern-switch input { opacity: 0; width: 0; height: 0; }
        
        .modern-slider {
            position: absolute; cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #cbd5e1;
            transition: .3s; border-radius: 24px;
        }
        
        .modern-slider:before {
            position: absolute; content: "";
            height: 18px; width: 18px;
            left: 3px; bottom: 3px;
            background-color: white;
            transition: .3s; border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .modern-switch input:checked + .modern-slider { background-color: var(--primary-color); }
        .modern-switch input:checked + .modern-slider:before { transform: translateX(22px); }

        /* Dynamic Fields Builder - SaaS Style */
        .field-builder-container {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .field-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem;
            position: relative;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }

        .field-item:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .field-item-header {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .field-drag-handle {
            cursor: grab;
            color: #94a3b8;
            padding-top: 10px;
        }

        .field-options-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            margin-left: 28px;
        }

        .field-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            margin-left: 28px;
        }

        .btn-add-field {
            width: 100%;
            padding: 1rem;
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            color: #475569;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-add-field:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: #eff6ff;
        }

        .btn-remove {
            color: #ef4444;
            background: #fee2e2;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: 0.2s;
        }
        
        .btn-remove:hover {
            background: #fca5a5;
            color: #991b1b;
        }

        /* Template Cards */
        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        .template-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        .template-card:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            transform: translateY(-2px);
        }
        .template-card.active {
            border-color: var(--primary-color);
            background: #eff6ff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
        }
        .template-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem auto;
            background: #f1f5f9;
            color: #64748b;
            transition: all 0.2s;
        }
        .template-card.active .template-icon {
            background: var(--primary-color);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div style="max-width: 900px; margin: 0 auto;">
        
        <div style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0;">Form Builder</h2>
            <p style="color: #64748b; margin-top: 4px; font-size: 0.95rem;">Buat formulir pendaftaran, survei, atau kuesioner kustom.</p>
        </div>

        <form action="{{ route('admin.forms.store') }}" method="POST" id="form-builder">
            @csrf

            <!-- Section 0: Template Selection -->
            <div class="form-card">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="copy" style="color: var(--primary-color);"></i> Gunakan Template Cepat (Opsional)
                </h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Pilih template untuk mengisi kolom form secara otomatis. Ini akan mereset form di bawah.</p>
                
                <div class="template-grid">
                    <div class="template-card active" onclick="applyTemplate('blank', this)">
                        <div class="template-icon"><i data-feather="file"></i></div>
                        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 4px;">Formulir Kosong</h4>
                        <p style="font-size: 0.75rem; color: #64748b;">Mulai dari nol</p>
                    </div>
                    <div class="template-card" onclick="applyTemplate('ppdb', this)">
                        <div class="template-icon"><i data-feather="users"></i></div>
                        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 4px;">Pendaftaran PPDB</h4>
                        <p style="font-size: 0.75rem; color: #64748b;">Penerimaan Siswa</p>
                    </div>
                    <div class="template-card" onclick="applyTemplate('contact', this)">
                        <div class="template-icon"><i data-feather="message-square"></i></div>
                        <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 4px;">Form Kontak/Saran</h4>
                        <p style="font-size: 0.75rem; color: #64748b;">Buku tamu & feedback</p>
                    </div>
                </div>
            </div>

            <!-- Section 1: Pengaturan Dasar Form -->
            <div class="form-card">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="info" style="color: var(--primary-color);"></i> Informasi Dasar
                </h3>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label" for="title">Judul Formulir <span style="color:#ef4444;">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Contoh: Formulir Pendaftaran Ekskul" required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="slug">URL Slug (Tautan Pendek)</label>
                        <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Otomatis jika dibiarkan kosong">
                        @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="description">Deskripsi / Instruksi Formulir</label>
                    <textarea id="description" name="description" class="form-control" rows="3" placeholder="Tuliskan petunjuk pengisian formulir di sini...">{{ old('description') }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Section 2: Pembuat Pertanyaan -->
            <div class="form-card">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 8px;">
                    <i data-feather="layout" style="color: var(--primary-color);"></i> Susunan Pertanyaan (Fields)
                </h3>

                <div class="field-builder-container" id="fields-container">
                    <!-- Fields will be injected here via JS -->
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="button" class="btn-add-field" id="add-field-btn">
                        <i data-feather="plus-circle"></i> Tambah Pertanyaan Baru
                    </button>
                </div>
                
                <input type="hidden" name="fields" id="fields-json">
                @error('fields') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <!-- Publish Settings -->
            <div class="modern-toggle-wrap">
                <div>
                    <strong style="display: block; color: #0f172a;">Terbitkan Formulir Sekarang</strong>
                    <span style="font-size: 0.85rem; color: #64748b;">Formulir akan langsung dapat diakses oleh publik.</span>
                </div>
                <label class="modern-switch">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked>
                    <span class="modern-slider"></span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; display: flex; gap: 1rem; justify-content: flex-end; position: sticky; bottom: 20px; background: #ffffff; padding: 1.5rem; border-radius: 12px; box-shadow: 0 -4px 20px rgba(0,0,0,0.05); z-index: 10;">
                <a href="{{ route('admin.forms.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.85rem 1.5rem; font-weight: 600; border-radius: 8px; text-decoration: none;">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" style="padding: 0.85rem 2rem; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3); display: flex; align-items: center; gap: 8px;">
                    <i data-feather="save"></i> Simpan Formulir
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleOptions(select) {
            const container = select.closest('.field-item').querySelector('.options-container');
            if (['select', 'radio', 'checkbox'].includes(select.value)) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        // Logic for Dynamic Fields
        function createField(name = '', type = 'text', req = false, optionsStr = '') {
            const container = document.getElementById('fields-container');
            const row = document.createElement('div');
            row.className = 'field-item';
            
            const displayOptions = ['select', 'radio', 'checkbox'].includes(type) ? 'block' : 'none';

            row.innerHTML = `
                <div class="field-item-header">
                    <div class="field-drag-handle"><i data-feather="grid" style="width: 18px; height: 18px;"></i></div>
                    <div style="flex: 2;">
                        <input type="text" placeholder="Pertanyaan / Nama Label" class="form-control f-name" style="font-weight: 600;" value="${name}" required>
                    </div>
                    <div style="flex: 1;">
                        <select class="form-control f-type" onchange="toggleOptions(this)">
                            <option value="text" ${type === 'text' ? 'selected' : ''}>Teks Singkat</option>
                            <option value="textarea" ${type === 'textarea' ? 'selected' : ''}>Paragraf (Panjang)</option>
                            <option value="email" ${type === 'email' ? 'selected' : ''}>Email</option>
                            <option value="number" ${type === 'number' ? 'selected' : ''}>Angka</option>
                            <option value="date" ${type === 'date' ? 'selected' : ''}>Tanggal</option>
                            <option value="select" ${type === 'select' ? 'selected' : ''}>Dropdown Pilihan</option>
                            <option value="radio" ${type === 'radio' ? 'selected' : ''}>Pilihan Ganda (Radio)</option>
                            <option value="checkbox" ${type === 'checkbox' ? 'selected' : ''}>Kotak Centang (Checklist)</option>
                            <option value="file" ${type === 'file' ? 'selected' : ''}>Upload File</option>
                        </select>
                    </div>
                </div>

                <div class="field-options-box options-container" style="display:${displayOptions};">
                    <label style="font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 6px; display: block;">Masukkan opsi pilihan (pisahkan dengan koma):</label>
                    <input type="text" placeholder="Contoh: Opsi 1, Opsi 2" class="form-control f-options" value="${optionsStr}">
                </div>

                <div class="field-footer">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600; color: #475569; font-size: 0.85rem;">
                        <input type="checkbox" class="f-req" style="width: 16px; height: 16px; accent-color: var(--primary-color);" ${req ? 'checked' : ''}> 
                        Wajib Diisi (Required)
                    </label>
                    <button type="button" class="btn-remove" onclick="this.closest('.field-item').remove()" title="Hapus Pertanyaan ini">
                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i> Hapus
                    </button>
                </div>
            `;
            container.appendChild(row);
            if(window.feather) feather.replace();
        }

        // Logic for Templates
        const formTemplates = {
            blank: {
                title: '',
                desc: '',
                fields: [
                    { name: '', type: 'text', req: true, opts: '' }
                ]
            },
            ppdb: {
                title: 'Formulir Pendaftaran Siswa Baru (PPDB)',
                desc: 'Silakan isi data diri calon siswa dengan lengkap dan benar sesuai dengan Kartu Keluarga.',
                fields: [
                    { name: 'Nama Lengkap Calon Siswa', type: 'text', req: true, opts: '' },
                    { name: 'Tempat, Tanggal Lahir', type: 'text', req: true, opts: '' },
                    { name: 'Jenis Kelamin', type: 'radio', req: true, opts: 'Laki-laki, Perempuan' },
                    { name: 'Agama', type: 'select', req: true, opts: 'Islam, Kristen, Katolik, Hindu, Buddha, Konghucu' },
                    { name: 'Asal Sekolah (TK/PAUD)', type: 'text', req: false, opts: '' },
                    { name: 'Nama Orang Tua / Wali', type: 'text', req: true, opts: '' },
                    { name: 'Nomor WhatsApp Aktif', type: 'number', req: true, opts: '' },
                    { name: 'Alamat Lengkap Domisili', type: 'textarea', req: true, opts: '' },
                    { name: 'Upload Berkas Kelahiran (Akta/KK)', type: 'file', req: true, opts: '' }
                ]
            },
            contact: {
                title: 'Formulir Buku Tamu / Hubungi Kami',
                desc: 'Ada pertanyaan, kritik, atau saran? Kirimkan pesan Anda melalui formulir di bawah ini.',
                fields: [
                    { name: 'Nama Lengkap Anda', type: 'text', req: true, opts: '' },
                    { name: 'Alamat Email', type: 'email', req: true, opts: '' },
                    { name: 'Kategori Pesan', type: 'select', req: true, opts: 'Pertanyaan Layanan, Kerjasama / Kemitraan, Laporan Kendala, Kritik & Saran, Lainnya' },
                    { name: 'Isi Pesan / Pertanyaan', type: 'textarea', req: true, opts: '' }
                ]
            }
        };

        function applyTemplate(templateKey, element) {
            // Update active state on cards
            document.querySelectorAll('.template-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');

            const template = formTemplates[templateKey];
            if(!template) return;

            // Fill header fields
            document.getElementById('title').value = template.title;
            document.getElementById('description').value = template.desc;

            // Clear and fill dynamic fields
            const container = document.getElementById('fields-container');
            container.innerHTML = '';
            template.fields.forEach(f => {
                createField(f.name, f.type, f.req, f.opts);
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize with blank template
            createField('', 'text', true, '');

            document.getElementById('add-field-btn').addEventListener('click', function () {
                createField();
            });

            document.getElementById('form-builder').addEventListener('submit', function (e) {
                const fields = [];
                document.querySelectorAll('.field-item').forEach(item => {
                    const type = item.querySelector('.f-type').value;
                    const optionsRaw = item.querySelector('.f-options').value;
                    const options = optionsRaw ? optionsRaw.split(',').map(o => o.trim()).filter(o => o) : [];

                    fields.push({
                        name: item.querySelector('.f-name').value,
                        type: type,
                        required: item.querySelector('.f-req').checked,
                        options: options
                    });
                });
                document.getElementById('fields-json').value = JSON.stringify(fields);
            });
            
            if(window.feather) feather.replace();
        });
    </script>
@endpush