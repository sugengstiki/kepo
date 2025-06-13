<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'email'];
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }
    public function Pencapaian()
    {
        return $this->hasMany(Pencapaian::class);
    }
}
