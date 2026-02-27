<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;

class FormSeeder extends Seeder
{
    public function run()
    {
        Form::create([
            'title' => 'Formulir Pendaftaran Siswa Baru',
            'slug' => 'pendaftaran-siswa-baru',
            'description' => 'Silakan isi formulir di bawah ini untuk mendaftarkan putra-putri Anda.',
            'is_active' => true,
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'Nama Lengkap Calon Siswa',
                    'name' => 'nama_lengkap',
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => 'Tempat Lahir',
                    'name' => 'tempat_lahir',
                    'required' => true,
                ],
                [
                    'type' => 'date',
                    'label' => 'Tanggal Lahir',
                    'name' => 'tanggal_lahir',
                    'required' => true,
                ],
                [
                    'type' => 'select',
                    'label' => 'Jenis Kelamin',
                    'name' => 'jenis_kelamin',
                    'required' => true,
                    'options' => [
                        ['option' => 'Laki-laki'],
                        ['option' => 'Perempuan'],
                    ],
                ],
                [
                    'type' => 'text',
                    'label' => 'Nama Ayah Kandung',
                    'name' => 'nama_ayah',
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => 'Nama Ibu Kandung',
                    'name' => 'nama_ibu',
                    'required' => true,
                ],
                [
                    'type' => 'number',
                    'label' => 'Nomor WhatsApp Orang Tua',
                    'name' => 'no_wa',
                    'required' => true,
                ],
                [
                    'type' => 'textarea',
                    'label' => 'Alamat Lengkap',
                    'name' => 'alamat',
                    'required' => true,
                ],
                [
                    'type' => 'checkbox',
                    'label' => 'Saya menyatakan data di atas benar',
                    'name' => 'pernyataan',
                    'required' => true,
                ],
            ],
        ]);
    }
}
