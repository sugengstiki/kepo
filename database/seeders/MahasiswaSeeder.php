<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create(['nrp' => '123456', 'nama' => 'John Doe', 'email' => 'john@example.com', 'tahun_masuk' => 2021]);
        Mahasiswa::create(['nrp' => '654321', 'nama' => 'Jane Smith', 'email' => 'jane@example.com', 'tahun_masuk' => 2022]);
    }
}
