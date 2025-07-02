<?php

namespace App\Filament\Resources\PengajuanKegiatanResource\Widgets;

use App\Models\Mahasiswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;

class StatusPengajuanWidget extends BaseWidget
{
    public $totalPoinDiajukan;
    public $totalKegiatan;

    protected function getStats(): array
    {
        $mahasiswa = Mahasiswa::where('user_id', auth()->id())->first();

        if (!$mahasiswa) {
            return [];
        }

        // Log::info('Data Mahasiswa:', ['mahasiswa' => $mahasiswa?->toArray()]);
        
        
        $totalPengajuan = $mahasiswa->pengajuanKegiatan()->count();
        $diterima = $mahasiswa->pengajuanKegiatan()->where('status', 'disetujui')->count();
        $totalPoin = $mahasiswa->poinDiterima()->sum('poin_diterima');
        $targetPoin = $mahasiswa->angkatan?->target_poin ?? 0;
        $persentase = $totalPengajuan > 0 ? round(($diterima / $totalPengajuan) * 100) : 0;
        
        // Log::info('total Pengajuan:', ['pengajuanKegiatan' => $mahasiswa->pengajuanKegiatan?->toArray()]);
        return [
            Stat::make('Poin', "{$totalPoin} / {$targetPoin}")
                ->description('total poin dari target yang harus dicapai'),
            Stat::make('Pengajuan', "{$diterima} / {$totalPengajuan}")
                ->description('pengajuan yang diterima dari total pengajuan'),
            Stat::make('Persentase Diterima', $persentase . '%')
                ->description('Dari total pengajuan')
                ->color($persentase > 70 ? 'success' : ($persentase > 30 ? 'warning' : 'danger')),
        ];
    }
}
