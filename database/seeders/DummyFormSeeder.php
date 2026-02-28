<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DummyFormSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Form Kontak Kami
        $formKontak = Form::create([
            'title' => 'Hubungi Kami',
            'slug' => 'hubungi-kami',
            'description' => 'Gunakan formulir ini untuk pertanyaan umum atau bantuan.',
            'is_active' => true,
            'fields' => [
                ['type' => 'text', 'label' => 'Nama Lengkap', 'name' => 'nama', 'required' => true],
                ['type' => 'email', 'label' => 'Alamat Email', 'name' => 'email', 'required' => true],
                ['type' => 'text', 'label' => 'Subjek', 'name' => 'subjek', 'required' => true],
                ['type' => 'textarea', 'label' => 'Pesan', 'name' => 'pesan', 'required' => true],
            ],
        ]);

        // Submissions for Hubungi Kami
        for ($i = 0; $i < 8; $i++) {
            FormSubmission::create([
                'form_id' => $formKontak->id,
                'data' => [
                    'nama' => $faker->name,
                    'email' => $faker->safeEmail,
                    'subjek' => $faker->sentence(3),
                    'pesan' => $faker->paragraph,
                ],
                'ip_address' => $faker->ipv4,
                'user_agent' => $faker->userAgent,
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }

        // 2. Form Pendaftaran Ekskul
        $formEkskul = Form::create([
            'title' => 'Pendaftaran Ekstrakurikuler',
            'slug' => 'daftar-ekskul',
            'description' => 'Daftarkan minat bakat siswa di sini.',
            'is_active' => true,
            'fields' => [
                ['type' => 'text', 'label' => 'Nama Siswa', 'name' => 'nama_siswa', 'required' => true],
                [
                    'type' => 'select',
                    'label' => 'Pilihan Ekskul',
                    'name' => 'ekskul',
                    'required' => true,
                    'options' => [
                        'Basket',
                        'Pramuka',
                        'Coding',
                        'Seni Lukis',
                    ]
                ],
                ['type' => 'text', 'label' => 'Kelas', 'name' => 'kelas', 'required' => true],
                ['type' => 'textarea', 'label' => 'Alasan Mengikuti', 'name' => 'alasan', 'required' => false],
            ],
        ]);

        // Submissions for Ekskul
        $ekskuls = ['Basket', 'Pramuka', 'Coding', 'Seni Lukis'];
        for ($i = 0; $i < 12; $i++) {
            FormSubmission::create([
                'form_id' => $formEkskul->id,
                'data' => [
                    'nama_siswa' => $faker->name,
                    'ekskul' => $faker->randomElement($ekskuls),
                    'kelas' => rand(1, 6) . ' ' . $faker->randomElement(['A', 'B', 'C']),
                    'alasan' => $faker->sentence,
                ],
                'ip_address' => $faker->ipv4,
                'user_agent' => $faker->userAgent,
                'created_at' => $faker->dateTimeBetween('-2 weeks', 'now'),
            ]);
        }
    }
}
