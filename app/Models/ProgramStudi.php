<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama'
    ];

    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
