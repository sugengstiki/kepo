<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Filament\Resources\KegiatanResource\RelationManagers;
use App\Models\Kegiatan;
use App\Models\Pedoman;
use App\Models\PedomanDetail;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $form->columns(3);
        return $form
            ->schema([
                TextInput::make('nama_kegiatan')->label('Nama Kegiatan/Partisipasi')->required()->maxLength(255)
                ->helperText('Isi dengan nama kegiatan / partisipasi dan tahun pelaksanaan.'),
                Section::make('Jenis Kegiatan')
                    ->description('Pilih jenis kegiatan, tingkat dan peran dari kegiatan diatas')
                    ->schema([
                        Select::make('pedoman_detail_id1')
                            ->relationship('pedomanDetail.pedoman', 'jenis_kegiatan'),
                        Select::make('jenis_kegiatan')
                            ->label('Jenis')
                            ->options(Pedoman::all()->pluck('jenis_kegiatan', 'id'))
                            // ->searchable()
                            ->required()
                            ->reactive()
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($set, $record) {
                                if ($record?->pedoman_detail_id) {
                                    $set('jenis_kegiatan', $record->pedomanDetail->pedoman->id);
                                }
                            }),
             
                        Select::make('tingkat')
                            ->label('Tingkat')
                            // ->relationship('pedoman_detail', 'tingkat')
                            ->options(function (callable $get) {
                                $pedomanId = $get('jenis_kegiatan');
        
                                if (!$pedomanId) return [];
        
                                return PedomanDetail::where('pedoman_id', $pedomanId)
                                    ->pluck('tingkat', 'tingkat')
                                    ->unique()
                                    ->toArray();
                            })
                            ->required()
                            ->reactive()
                            ->dehydrated(false)
                            ->afterStateUpdated(fn($set, $get) => static::setPedomanDetail($set, $get))
                            ->afterStateHydrated(function ($set, $record) {
                                if ($record?->pedoman_detail_id) {
                                    $set('tingkat', $record->pedomanDetail->tingkat);
                                }
                            })
                            ,
        
                        Select::make('peran')
                            ->label('Peran')
                            // ->relationship('pedoman_detail', 'peran')
                            ->options(function (callable $get) {
                                $pedomanId = $get('jenis_kegiatan');
                                if (!$pedomanId) return [];
        
                                return PedomanDetail::where('pedoman_id', $pedomanId)
                                    ->pluck('peran', 'peran')
                                    ->toArray();
                            })
                            ->required()
                            ->reactive()
                            ->dehydrated(false)
                            
                            ->afterStateUpdated(fn($set, $get) => static::setPedomanDetail($set, $get))
                            ->afterStateHydrated(function ($set, $record) {
                                if ($record?->pedoman_detail_id) {
                                    $set('peran', $record->pedomanDetail->peran);
                                }
                            }),
                    ])->columns(3),

                Hidden::make('mahasiswa_id')
                    ->default(1),

                Hidden::make('pedoman_detail_id')
                    ->required()
                    ->afterStateHydrated(function ($set, $get) {
                        self::setPedomanDetail($set, $get);
                    })
                    ->afterStateUpdated(function ($set, $get) {
                        self::setPedomanDetail($set, $get);
                    }),
            
                Hidden::make('status_validasi')
                    ->default('pending'),

                TextInput::make('poin')
                    ->label('Poin')
                    ->disabled()
                    ->default(0)
                    ->dehydrated(),
                
                TextInput::make('berkas_pendukung')
                    ->label('Link Berkas Pendukung (Google Drive)')
                    ->url()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kegiatan')->label('Nama Kegiatan')->sortable()->searchable(),
                TextColumn::make('mahasiswa.nrp')->label('NRP'),
                TextColumn::make('mahasiswa.nama')->label('Nama Mahasiswa'),
                TextColumn::make('pedoman_detail.pedoman.jenis_kegiatan')->label('Jenis Kegiatan'),
                TextColumn::make('pedoman_detail.peran')->label('Peran'),
                TextColumn::make('pedoman_detail.tingkat')->label('Tingkat'),
                TextColumn::make('poin')->label('Poin')->sortable(),
                TextColumn::make('status_validasi')
                    ->badge()
                    ->label('Status Validasi')
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'valid' => 'danger',
                        'tidak valid' => 'danger',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListKegiatans::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'edit' => Pages\EditKegiatan::route('/{record}/edit'),
        ];
    }

    /**
     * Fungsi bantu untuk memilih pedoman_detail_id & poin
     */
    protected static function setPedomanDetail(callable $set, callable $get): void
    {        
        $pedomanId = $get('jenis_kegiatan');
        $peran = $get('peran');
        $tingkat = $get('tingkat');

        // Log::debug("setPedomanDetail $pedomanId - peran: $peran - tingkat: $tingkat");

        if ($pedomanId && $peran && $tingkat) {
            $detail = \App\Models\PedomanDetail::where('pedoman_id', $pedomanId)
                ->where('peran', $peran)
                ->where('tingkat', $tingkat)
                ->first();

            if ($detail) {
                $set('pedoman_detail_id', $detail->id);
                $set('poin', $detail->poin);
                // Log::debug("set pedoman_id " . $detail->id . " dan poin " . $detail->poin);
                return;
            }
        }
        
        Log::info("Pedoman detail ID yang diset: " . ($detail->id ?? 'null'));

        $set('pedoman_detail_id', null);
        $set('poin', 0);
    }
}
