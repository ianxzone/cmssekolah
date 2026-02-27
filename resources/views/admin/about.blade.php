@extends('admin.layouts.app')

@section('title', 'Tentang CMS Sekolah')

@section('content')
    <div class="about-container">
        <div class="about-header">
            <h1>Tentang CMS Sekolah</h1>
            <p>CMS Sekolah adalah platform manajemen pendidikan dan digital marketing modern yang dirancang untuk membantu
                institusi pendidikan mengelola profil, informasi akademik, hingga sistem Penerimaan Peserta Didik Baru
                (PPDB) dengan cepat, ringan, dan aman. Sistem ini dikembangkan secara penuh oleh <strong>CV. Murni Abadi
                    Teknologi</strong>.</p>
        </div>

        <div class="service-grid">
            <!-- Card 1: Edisi Standar -->
            <div class="service-card">
                <div class="card-icon ic-standard">
                    <i data-feather="gift"></i>
                </div>
                <h3>Edisi Standar</h3>
                <span class="badge badge-free">100% Gratis</span>
                <p>Bebas biaya lisensi. Dapat diunduh, diinstal di server sekolah, dan digunakan bebas tanpa batasan waktu
                    untuk keperluan edukasi.</p>
            </div>

            <!-- Card 2: Konsultasi -->
            <div class="service-card">
                <div class="card-icon ic-support">
                    <i data-feather="tool"></i>
                </div>
                <h3>Dukungan Teknis</h3>
                <span class="badge badge-paid">Konsultasi</span>
                <p>Jasa instalasi VPS, troubleshooting, maintenance berkala, atau kustomisasi fitur spesifik dengan tarif
                    transparan dan dukungan profesional.</p>
            </div>

            <!-- Card 3: Cloud -->
            <div class="service-card">
                <div class="card-icon ic-cloud">
                    <i data-feather="cloud"></i>
                </div>
                <h3>Cloud Hosted & Premium</h3>
                <span class="badge badge-premium">Premium</span>
                <p>Solusi terima beres mencakup cloud hosting berkecepatan tinggi, keamanan tingkat lanjut, dan fitur
                    eksklusif premium (PPDB lanjutan, analitik).</p>
            </div>
        </div>

        <div class="cta-section">
            <h2>Siap membangun ekosistem digital untuk sekolah Anda?</h2>
            <p>Jika Anda memiliki pertanyaan teknis atau tertarik menggunakan layanan Cloud Hosted kami, silakan hubungi tim
                CV. Murni Abadi Teknologi.</p>

            <div class="cta-actions">
                <a href="https://wa.me/6285215353973" target="_blank" class="btn-wa">
                    <i data-feather="message-circle"></i>
                    Hubungi via WhatsApp (0852-1535-3973)
                </a>

                <a href="https://www.murniabadi.co.id" target="_blank" class="btn-web">
                    <i data-feather="external-link"></i>
                    Kunjungi Website Murni Abadi Teknologi
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Content Layout */
        .about-container {
            max-width: 1000px;
            margin: 0 auto;
            padding-bottom: 40px;
        }

        .about-header {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
            border: 1px solid #f1f5f9;
            text-align: left;
        }

        .about-header h1 {
            font-family: 'Outfit', 'Inter', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1.5rem;
            letter-spacing: -0.025em;
        }

        .about-header p {
            font-size: 1.125rem;
            line-height: 1.7;
            color: #475569;
        }

        /* Grid Section */
        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .service-card {
            background: #fff;
            padding: 32px;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
            overflow: hidden;
        }

        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            border-color: #e2e8f0;
        }

        .card-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .card-icon i {
            width: 28px;
            height: 28px;
        }

        .ic-standard {
            background: #eff6ff;
            color: #3b82f6;
        }

        .ic-support {
            background: #fef2f2;
            color: #ef4444;
        }

        .ic-cloud {
            background: #f5f3ff;
            color: #8b5cf6;
        }

        .service-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 12px;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 9999px;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-free {
            background: #dcfce7;
            color: #166534;
        }

        .badge-paid {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-premium {
            background: #e0e7ff;
            color: #3730a3;
        }

        .service-card p {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 60px 40px;
            border-radius: 24px;
            text-align: center;
            color: white;
        }

        .cta-section h2 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.1rem;
            color: #94a3b8;
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .cta-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .btn-wa {
            background: #25d366;
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(37, 211, 102, 0.3);
        }

        .btn-wa:hover {
            background: #22c35e;
            transform: scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(37, 211, 102, 0.4);
        }

        .btn-web {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-web:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .about-header {
                padding: 30px 20px;
            }

            .about-header h1 {
                font-size: 1.75rem;
            }

            .cta-section {
                padding: 40px 20px;
            }

            .cta-actions {
                flex-direction: column;
            }

            .btn-wa,
            .btn-web {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection