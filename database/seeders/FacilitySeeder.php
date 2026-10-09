<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run()
    {
        $facilities = [
            // Ruang Belajar & Kelas
            [
                'title' => 'Ruang Kelas Smart AC',
                'category' => 'class',
                'badge' => 'Smart Interactive TV',
                'icon' => 'airplay',
                'image' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Ruang kelas sejuk ber-AC lengkap dengan Smart TV interaktif, pencahayaan alami standar optik mata, loker santri, serta rasio siswa ideal untuk efektivitas KBM.',
                'order' => 1
            ],
            [
                'title' => 'Sentra Montessori & Daycare',
                'category' => 'class',
                'badge' => 'Ramah Anak & Stimulasi',
                'icon' => 'smile',
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Lingkungan eksplorasi motorik untuk usia Daycare (bayi/balita) dan Playgroup/TK dengan aparatus Montessori orisinal, lantai busa empuk, dan zona tidur higienis.',
                'order' => 2
            ],
            [
                'title' => 'Perpustakaan & Pojok Baca Digital',
                'category' => 'class',
                'badge' => 'E-Library & Literasi',
                'icon' => 'book',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Koleksi ribuan buku referensi ensiklopedia Islam, literatur sains dunia, pojok baca lesehan yang nyaman, dan komputer katalog e-library.',
                'order' => 3
            ],
            [
                'title' => 'Laboratorium Bahasa Modern',
                'category' => 'class',
                'badge' => 'Bilingual Immersion',
                'icon' => 'globe',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Dilengkapi headset audio-interaktif mandiri untuk praktikum listening, TOEFL/IELTS preparation, dan muhadatsah bahasa Arab fusha.',
                'order' => 4
            ],

            // Laboratorium & IT
            [
                'title' => 'Laboratorium Komputer iMac & Multimedia',
                'category' => 'lab',
                'badge' => 'Apple & High-Spec PC',
                'icon' => 'cpu',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Fasilitas perangkat iMac dan workstation mutakhir dengan akses internet serat optik berkecepatan tinggi untuk materi coding, AI, desain, dan CBT exam.',
                'order' => 5
            ],
            [
                'title' => 'Laboratorium Fisika & Bio-Kimia',
                'category' => 'lab',
                'badge' => 'STEM & Eksperimen',
                'icon' => 'zap',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Ruang praktikum terstandarisasi keamanan tinggi dengan mikroskop digital, glassware lengkap, reagen aman, dan bimbingan laboran berpengalaman.',
                'order' => 6
            ],
            [
                'title' => 'Studio Robotika & Coding Lab',
                'category' => 'lab',
                'badge' => 'Inovasi Robotik',
                'icon' => 'sliders',
                'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Pusat riset dan perakitan mikrokontroler, robotik arena pertandingan, dan 3D printing untuk mengasah nalar komputasi generasi masa depan.',
                'order' => 7
            ],
            [
                'title' => 'Student Smart Card Integrated System',
                'category' => 'lab',
                'badge' => 'Sistem Digital',
                'icon' => 'credit-card',
                'image' => 'https://images.unsplash.com/photo-1556742049-0a67e5574f73?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Kartu pintar santri multifungsi untuk presensi tap digital, peminjaman buku perpustakaan, hingga transaksi nontunai di Irsyadin Mart.',
                'order' => 8
            ],

            // Sarana Ibadah & Adab
            [
                'title' => 'Masjid Jami Al Irsyad',
                'category' => 'worship',
                'badge' => 'Episentrum Ibadah',
                'icon' => 'sun',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Masjid megah ber-AC sebagai pusat sholat fardhu berjamaah, pembiasaan sholat dhuha, halaqah tahfidz Al-Qur\'an bersanad, dan kajian adab nabawiyah.',
                'order' => 9
            ],
            [
                'title' => 'Auditorium & Aula Serbaguna',
                'category' => 'worship',
                'badge' => 'Kapasitas 1.000 Santri',
                'icon' => 'users',
                'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Gedung pertemuan bertaraf nasional berpendingin sentral untuk wisuda tahfidz akbar, seminar parenting, khitobah panggung, dan pameran karya siswa.',
                'order' => 10
            ],

            // Olahraga & Bermain
            [
                'title' => 'Irsyadin Water Pool (Kolam Renang)',
                'category' => 'sport',
                'badge' => 'Renang Sunnah Privat',
                'icon' => 'droplet',
                'image' => 'https://images.unsplash.com/photo-1530549387789-4c1017266635?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Kolam renang representatif berstandar kebersihan tinggi khusus santri LPP Al Irsyad, dengan jadwal dan pengawasan ketat terpisah ikhwan/akhwat.',
                'order' => 11
            ],
            [
                'title' => 'Sporthall & Lapangan Olahraga Terpadu',
                'category' => 'sport',
                'badge' => 'Futsal, Basket, Voli',
                'icon' => 'activity',
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Arena lapangan olahraga multi-fungsi berlantai standar turnamen untuk basket, voli, bulutangkis, futsal, serta arena beladiri Tapak Suci dan Taekwondo.',
                'order' => 12
            ],
            [
                'title' => 'Playground Outdoor & Indoor Tematik',
                'category' => 'sport',
                'badge' => 'Zona Anak Aman',
                'icon' => 'smile',
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Wahana bermain interaktif untuk merangsang motorik kasar dan ketangkasan fisik anak usia dini, dilengkapi pelindung benturan dan pengawasan guru.',
                'order' => 13
            ],

            // Layanan & Keamanan
            [
                'title' => 'Sistem Pengawasan CCTV 24 Jam',
                'category' => 'service',
                'badge' => 'Keamanan Terpadu',
                'icon' => 'shield',
                'image' => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Titik kamera pengawas berteknologi tinggi di seluruh koridor, ruang publik, pintu gerbang, dan area bermain untuk menjamin rasa aman santri dan walisantri.',
                'order' => 14
            ],
            [
                'title' => 'Armada Antar-Jemput Siswa Nyaman',
                'category' => 'service',
                'badge' => 'Mitra Transportasi Resmi',
                'icon' => 'truck',
                'image' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Layanan antar-jemput ber-AC terawat dengan pengemudi berpengalaman, rute teratur menjangkau seluruh kawasan perumahan strategis di Karawang.',
                'order' => 15
            ],
            [
                'title' => 'UKS & Layanan Dokter Sekolah',
                'category' => 'service',
                'badge' => 'Kesehatan Santri',
                'icon' => 'heart',
                'image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Klinik UKS representatif dengan tempat tidur medis, stok obat pertolongan pertama, dan pemeriksaan kesehatan gigi serta fisik berkala oleh dokter mitra.',
                'order' => 16
            ],
            [
                'title' => 'Cafetaria Sehat, Irsyadin Mart & Catering',
                'category' => 'service',
                'badge' => 'Halalan Thayyiban',
                'icon' => 'coffee',
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Penyediaan asupan gizi higienis bersertifikasi halal, bebas pengawet berbahaya, serta minimarket sekolah untuk kebutuhan santri dan walisantri.',
                'order' => 17
            ],
            [
                'title' => 'Admission Office & Ruang Tunggu VIP',
                'category' => 'service',
                'badge' => 'Pelayanan Ramah',
                'icon' => 'briefcase',
                'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=700',
                'desc' => 'Pusat layanan informasi SPMB terpadu yang nyaman, ber-AC, dan staf ramah siap melayani konsultasi pendaftaran santri baru dan tamu sekolah.',
                'order' => 18
            ]
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
