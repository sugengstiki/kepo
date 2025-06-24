<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterPoin extends Model
{
    use HasFactory;
    protected $table = 'master_poin';
    protected $fillable = ['jenis_kegiatan_id', 'peran_id', 'tingkat_id', 'poin'];

    public function jenisKegiatan(): BelongsTo
    {
        return $this->belongsTo(JenisKegiatan::class);
    }

    public function peran(): BelongsTo
    {
        return $this->belongsTo(Peran::class);
    }

    public function tingkat(): BelongsTo
    {
        return $this->belongsTo(Tingkat::class);
    }
}
