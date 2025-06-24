<?php

namespace App\Filament\Resources\MasterPoinResource\Pages;

use App\Filament\Resources\MasterPoinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterPoins extends ListRecords
{
    protected static string $resource = MasterPoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
