<?php

namespace App\Filament\Resources\PedomanResource\Pages;

use App\Filament\Resources\PedomanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPedoman extends ListRecords
{
    protected static string $resource = PedomanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
