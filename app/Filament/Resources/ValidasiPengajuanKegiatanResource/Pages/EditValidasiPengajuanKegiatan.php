<?php

namespace App\Filament\Resources\ValidasiPengajuanKegiatanResource\Pages;

use App\Filament\Resources\ValidasiPengajuanKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValidasiPengajuanKegiatan extends EditRecord
{
    protected static string $resource = ValidasiPengajuanKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
