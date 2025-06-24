<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    // protected $table = 'mahasiswas';
    
    protected $fillable = [
        'nrp','nama', 'email',
        'tahun_masuk','user_id',
        'program_studi_id',
        ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function pengajuanKegiatan()
    {
        return $this->hasMany(pengajuanKegiatan::class);
    }

    public function poinDiterima()
    {
        return $this->hasMany(PengajuanKegiatan::class, 'mahasiswa_id')
            ->where('status', 'diterima');
    }

    public function TotalPoinMahasiswa()
    {
        return $this->hasOne(TotalPoinMahasiswa::class);
    }
}
