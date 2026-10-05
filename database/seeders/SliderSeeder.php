<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\SliderItem;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tema Utama Beranda (Standar & Pearson)
        $mainSlider = Slider::updateOrCreate(
            ['slug' => 'home-hero'],
            [
                'name'        => 'Tema Beranda Utama (Standar & Pearson)',
                'description' => 'Slider utama default beranda menampilkan pengenalan sekolah, Pearson Edexcel UK, kurikulum khas, fasilitas, dan testimoni stakeholder.',
                'is_active'   => true,
                'auto_play'   => true,
                'delay'       => 6000,
            ]
        );

        // Hapus item lama jika ada lalu isi ulang
        $mainSlider->items()->delete();

        $mainSlides = [
            [
                'title'      => "Pendidikan Islam Terpadu & Rabbani\nLPP Al Irsyad Al Islamiyyah",
                'subtitle'   => 'Membina generasi Rabbani dari usia emas anak (Daycare sejak lahir, Playgroup & TK Montessori) hingga SDIT, SMPIT, dan SMAIT berpadu akidah tauhid dan adab nabawiyah.',
                'badge'      => 'SPMB TA 2025/2026 - LPP Al Irsyad Karawang',
                'image'      => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=1920',
                'side_image' => 'images/hero-students.png',
                'btn_text'   => 'Daftar SPMB Online',
                'btn_link'   => '#contact',
                'pills'      => ['Akreditasi A Unggul', 'Tahfidz Bersanad', 'Kelas Internasional ICP'],
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'title'      => 'Kurikulum Internasional Pearson (UK)',
                'subtitle'   => 'International Class Program (ICP) berstandar global Pearson Edexcel UK, memadukan sains internasional dengan adab tauhid Rabbani.',
                'badge'      => 'OFFICIAL PEARSON EDEXCEL PARTNER',
                'image'      => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Pelajari Pearson ICP',
                'btn_link'   => '/pearson-icp',
                'pills'      => ['Pearson Edexcel UK', 'Active English Immersion', 'Global Qualifications'],
                'sort_order' => 2,
                'is_active'  => true,
            ],
            [
                'title'      => 'Integrasi Nilai Qur\'ani, Sains & Adab Nabawiyah',
                'subtitle'   => 'Memadukan Kurikulum Merdeka Nasional dengan bimbingan tahfidz bersanad, pembiasaan adab harian, dan bilingual habit aktif.',
                'badge'      => 'KURIKULUM KHAS TERPADU AL IRSYAD',
                'image'      => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Pelajari Kurikulum Khas',
                'btn_link'   => '/kurikulum-khas',
                'pills'      => ['Tahfidz Bersanad', 'Bina Pribadi Islami', 'STEAM & Coding'],
                'sort_order' => 3,
                'is_active'  => true,
            ],
            [
                'title'      => 'Fasilitas Lengkap & Lingkungan Belajar Representatif',
                'subtitle'   => 'Menghadirkan lingkungan belajar yang aman, nyaman, dan berteknologi tinggi untuk memaksimalkan potensi nalar dan ibadah santri.',
                'badge'      => 'SARANA & PRASARANA MODERN',
                'image'      => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Lihat Seluruh Fasilitas',
                'btn_link'   => '/fasilitas',
                'pills'      => ['Smart Classroom AC', 'Lab Sains & Komputer', 'Masjid Luas & Representatif'],
                'sort_order' => 4,
                'is_active'  => true,
            ],
            [
                'title'      => 'Pilihan Utama Tokoh, Pejabat & Profesional Karawang',
                'subtitle'   => 'Amanah kehormatan dipercaya oleh kalangan pejabat pemda, dokter spesialis, akademisi, dan profesional industri di Karawang.',
                'badge'      => 'KEPERCAYAAN STAKEHOLDER KARAWANG',
                'image'      => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Lihat Testimoni Tokoh',
                'btn_link'   => '#testimonials',
                'pills'      => ['Pejabat Pemda & ASN', 'Dokter & Tenaga Medis', 'Profesional Industri & BUMN'],
                'sort_order' => 5,
                'is_active'  => true,
            ],
        ];

        foreach ($mainSlides as $slide) {
            $mainSlider->items()->create($slide);
        }

        // 2. Contoh Tema Alternatif: Tema Promosi PPDB & Prestasi
        $ppdbSlider = Slider::updateOrCreate(
            ['slug' => 'tema-spmb-prestasi'],
            [
                'name'        => 'Tema Promosi SPMB & Prestasi Santri',
                'description' => 'Tema khusus periode penerimaan santri baru (SPMB) dengan fokus pada kuota pendaftaran, beasiswa, dan prestasi gemilang.',
                'is_active'   => false, // Siap diaktifkan kapan saja
                'auto_play'   => true,
                'delay'       => 5000,
            ]
        );

        $ppdbSlider->items()->delete();

        $ppdbSlides = [
            [
                'title'      => 'Penerimaan Santri Baru (SPMB) Telah Dibuka!',
                'subtitle'   => 'Bergabunglah bersama keluarga besar Al Irsyad Al Islamiyyah Karawang untuk mencetak generasi berkarakter Qur\'ani dan berwawasan global.',
                'badge'      => 'SPMB GELOMBANG UTAMA',
                'image'      => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=1920',
                'side_image' => 'images/hero-students.png',
                'btn_text'   => 'Daftar SPMB Online',
                'btn_link'   => '#contact',
                'pills'      => ['Kuota Terbatas', 'Beasiswa Prestasi', 'Tes Masuk Terjadwal'],
                'sort_order' => 1,
                'is_active'  => true,
            ],
            [
                'title'      => 'Raih Prestasi Gemilang Tingkat Nasional & Internasional',
                'subtitle'   => 'Santri Al Irsyad secara konsisten menorehkan prestasi membanggakan dalam bidang tahfidz bersanad, sains, robotik, dan bahasa asing.',
                'badge'      => 'GENERASI JUARA & BERPRESTASI',
                'image'      => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&q=80&w=1920',
                'side_image' => null,
                'btn_text'   => 'Lihat Galeri Prestasi',
                'btn_link'   => '/blog',
                'pills'      => ['Juara Olimpiade Sains', 'Tahfidz Mutqin', 'Bilingual Active'],
                'sort_order' => 2,
                'is_active'  => true,
            ],
        ];

        foreach ($ppdbSlides as $slide) {
            $ppdbSlider->items()->create($slide);
        }
    }
}
