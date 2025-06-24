<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    
    protected $fillable = ['mahasiswa_id', 'pedoman_detail_id', 'nama_kegiatan', 'berkas_pendukung', 'poin', 'status_validasi'];
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
    
    public function pedomanDetail()
    {
        return $this->belongsTo(PedomanDetail::class);
    }
}
