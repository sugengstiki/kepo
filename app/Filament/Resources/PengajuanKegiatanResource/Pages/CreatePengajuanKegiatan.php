<?php

namespace App\Filament\Resources\PengajuanKegiatanResource\Pages;

use App\Filament\Resources\PengajuanKegiatanResource;
use App\Models\MasterPoin;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreatePengajuanKegiatan extends CreateRecord
{
    protected static string $resource = PengajuanKegiatanResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
