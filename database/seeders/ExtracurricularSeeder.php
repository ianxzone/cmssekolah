<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExtracurricularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = \App\Models\Setting::getExtracurricularCatalog();
        $order = 1;
        foreach ($items as $item) {
            \App\Models\Extracurricular::create([
                'title' => $item['title'],
                'category' => $item['category'],
                'badge' => (isset($item['highlight']) && $item['highlight'] == '1') ? 'Unggulan' : null,
                'icon' => $item['icon'] ?? 'star',
                'image' => $item['image'] ?? null,
                'desc' => ($item['desc'] ?? '') . '<br><br><strong>Jadwal:</strong> ' . ($item['schedule'] ?? '-') . '<br><strong>Pembina/Pelatih:</strong> ' . ($item['coach'] ?? '-') . '<br><strong>Prestasi:</strong> ' . ($item['achievement'] ?? '-'),
                'order' => $order++,
                'is_active' => true,
            ]);
        }
    }
}
