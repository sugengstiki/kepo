<?php

namespace App\Filament\Resources\ValidasiPengajuanKegiatanResource\Pages;

use App\Filament\Resources\ValidasiPengajuanKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListValidasiPengajuanKegiatans extends ListRecords
{
    protected static string $resource = ValidasiPengajuanKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
