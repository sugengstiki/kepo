<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedoman extends Model
{
    use HasFactory;
    protected $fillable = ['jenis_kegiatan'];
    public function pedomanDetail()
    {
        return $this->hasMany(PedomanDetail::class);
    }
}
