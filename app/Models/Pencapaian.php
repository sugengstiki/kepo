<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencapaian extends Model
{
    use HasFactory;
    protected $fillable = ['mahasiswa_id', 'target_poin', 'angkatan'];
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
