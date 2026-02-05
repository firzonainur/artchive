<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institutions = [
            'Universitas Negeri Malang',
            'Universitas Brawijaya',
            'Universitas Negeri Surabaya',
            'Universitas Bhineka Nusantara',
        ];

        foreach ($institutions as $name) {
            \App\Models\Institution::firstOrCreate([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
            ]);
        }
    }
}
