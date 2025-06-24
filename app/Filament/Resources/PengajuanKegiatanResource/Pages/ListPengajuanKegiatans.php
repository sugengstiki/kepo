<?php

namespace App\Filament\Resources\PengajuanKegiatanResource\Pages;

use App\Filament\Resources\PengajuanKegiatanResource;
use App\Filament\Resources\PengajuanKegiatanResource\Widgets\StatusPengajuanWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanKegiatans extends ListRecords
{
    protected static string $resource = PengajuanKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [            
            StatusPengajuanWidget::class,
        ];
    }
}
