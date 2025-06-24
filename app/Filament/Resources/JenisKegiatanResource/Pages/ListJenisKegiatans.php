<?php

namespace App\Filament\Resources\JenisKegiatanResource\Pages;

use App\Filament\Resources\JenisKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisKegiatans extends ListRecords
{
    protected static string $resource = JenisKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
