<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasterPoinResource\Pages;
use App\Filament\Resources\MasterPoinResource\RelationManagers;
use App\Models\JenisKegiatan;
use App\Models\MasterPoin;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterPoinResource extends Resource
{
    protected static ?string $model = MasterPoin::class;

    // Model Label (Nama yang akan muncul di UI)
    protected static ?string $modelLabel = 'Poin';

    // Plural Model Label (Bentuk jamak)
    protected static ?string $pluralModelLabel = 'Poin';

    // Navigation Icon (Ikon di sidebar)
    protected static ?string $navigationIcon = 'heroicon-o-star';

    // Navigation Group (Mengelompokkan menu di sidebar)
    protected static ?string $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\fieldset::make()
                    ->schema([
                        Select::make('jenis_kegiatan_id')
                            ->label('Jenis Kegiatan')                            
                            ->options(JenisKegiatan::all()->pluck('nama', 'id'))
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('peran', null)),

                        TextInput::make('peran')
                            ->required()
                            ->maxLength(255)
                            ->datalist(function (callable $get) {
                                $jenisKegiatanId = $get('jenis_kegiatan_id');
                                if (!$jenisKegiatanId) {
                                    return [];
                                }
                                return MasterPoin::where('jenis_kegiatan_id', $jenisKegiatanId)
                                    ->pluck('peran')
                                    ->unique()
                                    ->toArray();
                            }),

                        Select::make('tingkat')
                            ->options([
                                'kampus' => 'Kampus',
                                'kota' => 'Kota/Kabupaten',
                                'provinsi' => 'Provinsi',
                                'nasional' => 'Nasional',
                                'internasional' => 'Internasional',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('poin')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->suffix('poin'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListMasterPoins::route('/'),
            'create' => Pages\CreateMasterPoin::route('/create'),
            'edit' => Pages\EditMasterPoin::route('/{record}/edit'),
        ];
    }
}
