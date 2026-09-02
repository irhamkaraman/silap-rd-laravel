<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Infrastruktur & Aksesibilitas',
            'Pelayanan Publik',
            'Fasilitas Kesehatan',
            'Pendidikan & Literasi',
            'Ketenagakerjaan & Sosial',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
