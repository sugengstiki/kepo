<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AngkatanResource\Pages;
use App\Filament\Resources\AngkatanResource\RelationManagers;
use App\Models\Angkatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AngkatanResource extends Resource
{
    protected static ?string $model = Angkatan::class;

    // Model Label (Nama yang akan muncul di UI)
    protected static ?string $modelLabel = 'Bobot Angkatan';

    // Plural Model Label (Bentuk jamak)
    protected static ?string $pluralModelLabel = 'Bobot Angkatan';

    // Navigation Icon (Ikon di sidebar)
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    // Navigation Group (Mengelompokkan menu di sidebar)
    protected static ?string $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tahun')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2099)
                    ->required(),

                Forms\Components\TextInput::make('target_poin')
                    ->label('Target Poin')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('target_poin')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAngkatans::route('/'),
            'create' => Pages\CreateAngkatan::route('/create'),
            'edit' => Pages\EditAngkatan::route('/{record}/edit'),
        ];
    }
}
