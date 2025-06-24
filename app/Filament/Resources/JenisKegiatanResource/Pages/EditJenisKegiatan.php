<?php

namespace App\Filament\Resources\JenisKegiatanResource\Pages;

use App\Filament\Resources\JenisKegiatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisKegiatan extends EditRecord
{
    protected static string $resource = JenisKegiatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     $record = $this->record;
    //     // dd($record->masterPoin);
    //     // Isi state dari relasi masterPoin
    //     if ($record->masterPoin) {
    //         $data['jenis_kegiatan_id'] = $record->masterPoin->jenis_kegiatan_id;
    //         $data['peran_id'] = $record->masterPoin->peran_id;
    //         $data['tingkat_id'] = $record->masterPoin->tingkat_id;
    //     }

    //     return $data;
    // }
}
