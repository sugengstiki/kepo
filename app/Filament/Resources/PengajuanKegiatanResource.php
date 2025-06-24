<?php

// app/Filament/Resources/PengajuanKegiatanResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanKegiatanResource\Pages;
// use App\Filament\Resources\PengajuanKegiatanResource\RelationManagers;

use App\Models\JenisKegiatan;
use App\Models\Mahasiswa;
use App\Models\MasterPoin;
use App\Models\PengajuanKegiatan;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Url;

class PengajuanKegiatanResource extends Resource
{
    protected static ?string $model = PengajuanKegiatan::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Kegiatan';
    protected static ?string $modelLabel = 'Pengajuan Kegiatan';
    protected static ?string $navigationLabel = 'Ajukan Kegiatan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('mahasiswa_id')
                    ->default(function () {
                        return Mahasiswa::where('user_id', Auth::id())->first()->id;
                    }),
            Forms\Components\TextInput::make('nama_kegiatan')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),

            Select::make('tanggal_kegiatan')
                ->label('Tahun Kegiatan / Periode')
                ->options(
                    collect(range(2000, Carbon::now()->year))
                        ->mapWithKeys(fn($year) => [$year => $year])
                        ->reverse()
                )
                ->required()
                ->columnSpanFull(),

            Forms\Components\Fieldset::make()
                    ->schema([
                        

                        Forms\Components\Select::make('jenis_kegiatan_id')
                            ->label('Jenis Kegiatan')
                            ->options(JenisKegiatan::all()->pluck('nama', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                // $set('peran_id', null);
                                // $set('tingkat_id', null);
                            })
                            ->dehydrated(false),
                             

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('tingkat_id')
                                    ->label('Tingkat')
                                    ->options(function (callable $get) {
                                        $jenisKegiatanId = $get('jenis_kegiatan_id');
                                        // $peranId = $get('peran_id');

                                        if (!$jenisKegiatanId) {
                                            return [];
                                        }

                                        // Dapatkan tingkat yang tersedia untuk kombinasi ini
                                        return MasterPoin::with('tingkat')
                                            ->where('jenis_kegiatan_id', $jenisKegiatanId)
                                            // ->where('peran_id', $peranId)
                                            ->get()
                                            ->pluck('tingkat.nama', 'tingkat.id')
                                            ->unique();
                                    })
                                    ->required()
                                    ->reactive()
                                    ->dehydrated(false) // HAPUS dehydrated(false)
                                    ->default(function ($record) {
                                        return $record?->masterPoin?->tingkat_id;
                                    })
                                    ->afterStateUpdated(function (callable $get, callable $set) {
                                        $jenisKegiatanId = $get('jenis_kegiatan_id');
                                        $peranId = $get('peran_id');
                                        $tingkatId = $get('tingkat_id');

                                        if ($jenisKegiatanId && $peranId && $tingkatId) {
                                            $masterPoin = MasterPoin::where('jenis_kegiatan_id', $jenisKegiatanId)
                                                ->where('peran_id', $peranId)
                                                ->where('tingkat_id', $tingkatId)
                                                ->first();

                                            if ($masterPoin) {
                                                $set('master_poin_id', $masterPoin->id);
                                                $set('poin_diterima', $masterPoin->poin);
                                            }
                                        }
                                    }),
                                Forms\Components\Select::make('peran_id')
                                    ->label('Peran')
                                    ->options(function (callable $get) {
                                        $jenisKegiatanId = $get('jenis_kegiatan_id');
                                        if (!$jenisKegiatanId) {
                                            return [];
                                        }

                                        // Dapatkan peran yang tersedia untuk jenis kegiatan ini
                                        return MasterPoin::with('peran')
                                            ->where('jenis_kegiatan_id', $jenisKegiatanId)
                                            ->get()
                                            ->pluck('peran.nama', 'peran.id')
                                            ->unique();
                                    })
                                    ->required()
                                    ->reactive()
                                    ->dehydrated(false) 
                                    ->default(function ($record) {
                                        return $record?->masterPoin?->peran_id;
                                    })
                                    ->afterStateUpdated(function (callable $get, callable $set) {
                                        $jenisKegiatanId = $get('jenis_kegiatan_id');
                                        $peranId = $get('peran_id');
                                        $tingkatId = $get('tingkat_id');

                                        if ($jenisKegiatanId && $peranId && $tingkatId) {
                                             $masterPoin = MasterPoin::where('jenis_kegiatan_id', $jenisKegiatanId)
                                                ->where('peran_id', $peranId)
                                                ->where('tingkat_id', $tingkatId)
                                                ->first();

                                            if ($masterPoin) {
                                                $set('master_poin_id', $masterPoin->id);
                                                $set('poin_diterima', $masterPoin->poin);
                                            }
                                        }
                                    }),
                                

                                Forms\Components\TextInput::make('poin_diterima')
                                    ->disabled()
                                    ->dehydrated()
                                    ->placeholder('Pilih jenis, peran & tingkat')
                                    ->suffix('poin'),

                                Hidden::make('master_poin_id')
                                    ->afterStateHydrated(function (?string $state, callable $set) {
                                        $masterPoin = MasterPoin::find($state);
                                        if(!$masterPoin){
                                            return [];
                                        }
                                        // Log::info('MasterPoin' . $masterPoin->jenis_kegiatan_id);
                                        $set('jenis_kegiatan_id', $masterPoin->jenis_kegiatan_id);
                                        $set('tingkat_id', $masterPoin->tingkat_id);
                                        $set('peran_id', $masterPoin->peran_id);
                                        
                                    })
                                    
                            ]),

                        
                    ]),

            Forms\Components\TextInput::make('file_pendukung')
                ->label('Link Google Drive')
                ->required()
                ->url()
                // ->rules([Url::default()])
                ->placeholder('https://drive.google.com/...')
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_kegiatan')
                    ->label('Tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('masterPoin.jenisKegiatan.nama')
                    ->label('Jenis Kegiatan'),

                Tables\Columns\TextColumn::make('masterPoin.tingkat.nama'),
                Tables\Columns\TextColumn::make('masterPoin.peran.nama'),


                Tables\Columns\TextColumn::make('status')
                    // ->enum([
                    //     'diajukan' => 'Diajukan',
                    //     'diterima' => 'Diterima',
                    //     'ditolak' => 'Ditolak',
                    // ])
                    ->badge()
                    ->colors([
                        'warning' => 'diajukan',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                    ]),

                Tables\Columns\TextColumn::make('poin_diterima')
                    ->label('Poin')
                    ->formatStateUsing(fn($state) => $state ? number_format($state, 0) . ' poin' : '-'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'diajukan' => 'Diajukan',
                        'diterima' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('master_poin_id')
                    ->label('Jenis Kegiatan')
                    ->relationship('masterPoin.jenisKegiatan', 'nama'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->status === 'diajukan'),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => $record->status === 'diajukan'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function (Collection $records) {
                        $records->where('status', 'diajukan')->each->delete();
                    })
                    ->label('Hapus Pengajuan')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()
            ->whereHas('mahasiswa', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['masterPoin','masterPoin.jenisKegiatan', 'masterPoin.peran', 'masterPoin.tingkat']);
        // ->with(['masterPoin', 'masterPoin.jenisKegiatan']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajuanKegiatans::route('/'),
            'create' => Pages\CreatePengajuanKegiatan::route('/create'),
            // 'view' => Pages\ViewPengajuanKegiatan::route('/{record}'),
            'edit' => Pages\EditPengajuanKegiatan::route('/{record}/edit'),
        ];
    }
}
