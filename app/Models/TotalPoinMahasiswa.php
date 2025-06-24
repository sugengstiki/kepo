<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalPoinMahasiswa extends Model
{
    use HasFactory;
    protected $fillable = ['mahasiswa_id', 'total_poin', 'terakhir_diperbarui'];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
