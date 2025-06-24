<?php

namespace App\Filament\Resources\MasterPoinResource\Pages;

use App\Filament\Resources\MasterPoinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterPoin extends EditRecord
{
    protected static string $resource = MasterPoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
