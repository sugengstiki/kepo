<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ValidasiPengajuanKegiatanResource\Pages;
use App\Filament\Resources\ValidasiPengajuanKegiatanResource\RelationManagers;
use App\Models\JenisKegiatan;
use App\Models\MasterPoin;
use App\Models\PengajuanKegiatan;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class ValidasiPengajuanKegiatanResource extends Resource
{
    protected static ?string $model = PengajuanKegiatan::class;

    // Model Label (Nama yang akan muncul di UI)
    protected static ?string $modelLabel = 'Validasi';

    // Plural Model Label (Bentuk jamak)
    protected static ?string $pluralModelLabel = 'Validasi';

    // Navigation Icon (Ikon di sidebar)
    // protected static ?string $navigationIcon = 'heroicon-o-check-badge';


    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('nama_kegiatan')->columnSpanFull()->disabled(),
            TextInput::make('tanggal_kegiatan')->label('Tahun')->disabled(),

            ///
            Section::make('Detail Kegiatan')
                ->schema([
                    Placeholder::make('jenis_kegiatan')
                        ->label('Jenis Kegiatan')
                        ->columnSpanFull()
                        ->content(function ($record) {
                            return $record?->masterPoin?->jenisKegiatan?->nama ?? '-';
                        }),
                    
                    Placeholder::make('tingkat')
                        ->label('Tingkat')
                        ->content(function ($record) {
                            return $record?->masterPoin?->tingkat?->nama ?? '-';
                        }),
                    Placeholder::make('peran')
                        ->label('Peran')
                        ->content(function ($record) {
                            return $record?->masterPoin?->peran?->nama ?? '-';
                        }),

                    TextInput::make('poin_diterima')
                        ->label('Poin')                        
                        ->disabled()
                        ->suffix('poin'),                  

                ])->columns(4)->extraAttributes(['class' => '!bg-gray-800']),
            ///
            Select::make('status')
                ->options([
                    'diajukan' => 'Diajukan',
                    'disetujui' => 'Disetujui',
                    'ditolak' => 'Ditolak',
                ])
                ->required(),
            // TextInput::make('file_pendukung')
            //     ->label('Berkas Pendukung')
            //     ->disabled(),

            Placeholder::make('file_pendukung')
                ->label('File Pendukung')
                ->content(function ($record) {
                    if (! $record?->file_pendukung) {
                        return new HtmlString('<span class="text-gray-500 italic">Tidak ada file</span>');
                    }

                    // $url = Storage::url($record->file_pendukung);
                    $url = $record->file_pendukung;

                    return new HtmlString(
                        "<a href='{$url}' target='_blank' class='text-primary-600 underline'>Lihat File</a>"
                    );
                    // if ($record->file_pendukung) {
                    //     return new HtmlString('<a href="{$record->file_pendukung}">{$record->file_pendukung}</a>');
                    // }
                    // return '-';
                }),
                
                
            Textarea::make('catatan_validator')
                ->label('Catatan (Opsional)'),

                //
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mahasiswa.nama')->label('Mahasiswa'),
                TextColumn::make('nama_kegiatan'),
                TextColumn::make('tanggal_kegiatan')->date(),
                TextColumn::make('status')
                    ->badge()
                // ->colors(fn(string $state): string => match ($state){
                //     'diajukan'  => 'warning',
                //     'disetujui' => 'success',
                //     'ditolak'   => 'danger' ,
                // }),
                    ->colors([
                        'warning' => 'diajukan',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                    ]),
                TextColumn::make('catatan_validator')->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListValidasiPengajuanKegiatans::route('/'),
            // 'create' => Pages\CreateValidasiPengajuanKegiatan::route('/create'),
            'edit' => Pages\EditValidasiPengajuanKegiatan::route('/{record}/edit'),
        ];
    }
}
