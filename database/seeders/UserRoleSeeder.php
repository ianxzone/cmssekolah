<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure primary admin exists
        $admin = User::first();
        if ($admin) {
            $admin->update([
                'role' => User::ROLE_ADMIN ?? 'admin',
            ]);
        }

        // 2. Sample Editor
        User::firstOrCreate(
            ['email' => 'editor@sekolah.com'],
            [
                'name' => 'Ustadz Hilman (Editor)',
                'password' => Hash::make('password'),
                'role' => 'editor',
            ]
        );

        // 3. Sample Author / Penulis
        User::firstOrCreate(
            ['email' => 'penulis@sekolah.com'],
            [
                'name' => 'Siti Rahmawati (Penulis)',
                'password' => Hash::make('password'),
                'role' => 'author',
            ]
        );

        // 4. Sample Contributor
        User::firstOrCreate(
            ['email' => 'kontributor@sekolah.com'],
            [
                'name' => 'Ahmad Fauzi (Kontributor)',
                'password' => Hash::make('password'),
                'role' => 'contributor',
            ]
        );
    }
}
