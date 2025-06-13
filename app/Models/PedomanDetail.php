<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedomanDetail extends Model
{
    use HasFactory;
    protected $fillable = ['pedoman_id', 'peran', 'tingkat', 'poin'];
    public function pedoman()
    {
        return $this->belongsTo(Pedoman::class);
    }
}
