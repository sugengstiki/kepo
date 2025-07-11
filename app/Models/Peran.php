<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    use HasFactory;
    protected $table = 'peran';
    protected $fillable = ['nama'];

    public function masterPoin()
    {
        return $this->hasMany(MasterPoin::class);
    }
}
