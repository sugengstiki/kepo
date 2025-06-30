<?php

namespace App\Filament\Widgets;

use App\Models\Mahasiswa;
use App\Models\PengajuanKegiatan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;

class PengajuanOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPengajuan = PengajuanKegiatan::count();

        $diterima = PengajuanKegiatan::where('status', 'disetujui')->count();

        $persentase = $totalPengajuan > 0 ? round(($diterima / $totalPengajuan) * 100) : 0;

        return [
            Stat::make('Total Pengajuan', $totalPengajuan),
            Stat::make('Diterima', $diterima),
            Stat::make('Persentase Diterima', $persentase . '%')
                ->description('Dari total pengajuan')
                ->color($persentase > 70 ? 'success' : ($persentase > 30 ? 'warning' : 'danger')),
        ];
    }
}
