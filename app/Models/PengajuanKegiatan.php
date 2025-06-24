<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanKegiatan extends Model
{
    use HasFactory;
    protected $table = 'pengajuan_kegiatan';
    protected $fillable = [
        'mahasiswa_id',
        'nama_kegiatan',
        'tanggal_kegiatan',
        'file_pendukung',
        'master_poin_id',
        // 'peran_id',
        // 'tingkat_id',
        'status',
        'poin_diterima',
        'catatan_validator'
    ];

    protected $casts = [        
        'poin_diterima' => 'integer',
        'status' => 'string',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function masterPoin(): BelongsTo{
        return $this->belongsTo(MasterPoin::class);
    }
    

    // public function getPoinAttribute()
    // {
    //     if ($this->poin_diterima !== null) {
    //         return $this->poin_diterima;
    //     }

    //     return $this->masterPoin
    //         ->where('jenis_kegiatan_id', $this->jenis_kegiatan_id)
    //         ->where('peran_id', $this->peran_id)
    //         ->where('tingkat_id', $this->tingkat_id)
    //         ->first()?->poin ?? 0;
    // }
}
