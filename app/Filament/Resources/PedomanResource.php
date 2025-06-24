<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedomanResource\Pages;
use App\Filament\Resources\PedomanResource\RelationManagers;
use App\Models\Pedoman;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PedomanResource extends Resource
{
    protected static ?string $model = Pedoman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('jenis_kegiatan')
                ->label('Jenis Kegiatan')
                ->required()
                ->maxLength(255),
            Repeater::make('pedomanDetail')
                ->label('Detail Poin')
                ->relationship('pedomanDetail')
                ->schema([
                    Select::make('peran')
                        ->label('Peran')
                        ->options([
                            'Ketua' => 'Ketua',
                            'Pengurus' => 'Pengurus',
                            'Anggota' => 'Anggota',
                            'Juara 1' => 'Juara 1',
                            'Juara 2' => 'Juara 2',
                            'Juara 3' => 'Juara 3',
                        ])
                        ->required(),
                    Select::make('tingkat')
                        ->label('Tingkat')
                        ->options([
                            'Kampus' => 'Kampus',
                            'Kota' => 'Kota',
                            'Provinsi' => 'Provinsi',
                            'Nasional' => 'Nasional',
                            'Internasional' => 'Internasional',
                        ])
                        ->required(),
                    TextInput::make('poin')
                        ->label('Poin')
                        ->numeric()
                        ->required(),
                ])->columns(3)
                
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('jenis_kegiatan')->label('Jenis Kegiatan')->sortable()->searchable(),
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
            'index' => Pages\ListPedoman::route('/'),
            'create' => Pages\CreatePedoman::route('/create'),
            'edit' => Pages\EditPedoman::route('/{record}/edit'),
        ];
    }
}
