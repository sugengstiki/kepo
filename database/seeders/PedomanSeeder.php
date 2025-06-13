<?php

namespace Database\Seeders;

use App\Models\Pedoman;
use App\Models\PedomanDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PedomanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pedoman = Pedoman::create(['jenis_kegiatan' => 'Organisasi Mahasiswa']);
        PedomanDetail::create(['pedoman_id' => $pedoman->id, 'peran' => 'Ketua', 'tingkat' => 'Kampus', 'poin' => 100]);
        PedomanDetail::create(['pedoman_id' => $pedoman->id, 'peran' => 'Pengurus', 'tingkat' => 'Kampus', 'poin' => 70]);
        PedomanDetail::create(['pedoman_id' => $pedoman->id, 'peran' => 'Anggota', 'tingkat' => 'Kampus', 'poin' => 40]);
    }
}
