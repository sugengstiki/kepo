<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TingkatResource\Pages;
use App\Filament\Resources\TingkatResource\RelationManagers;
use App\Models\Tingkat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TingkatResource extends Resource
{
    protected static ?string $model = Tingkat::class;

    // Model Label (Nama yang akan muncul di UI)
    protected static ?string $modelLabel = 'Tingkat';

    // Plural Model Label (Bentuk jamak)
    protected static ?string $pluralModelLabel = 'Tingkat';

    // Navigation Icon (Ikon di sidebar)
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    // Navigation Group (Mengelompokkan menu di sidebar)
    protected static ?string $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true) // Ensure the name is unique, ignoring the current record on edit.
                    ->label('Nama Peran'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            // Column to display the activity type name.
            Tables\Columns\TextColumn::make('nama')
                ->searchable() // Allows searching by name.
                ->sortable(), // Allows sorting by name.

            // Column to display the creation timestamp.
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, but can be shown by the user.

            // Column to display the update timestamp.
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListTingkats::route('/'),
            'create' => Pages\CreateTingkat::route('/create'),
            'edit' => Pages\EditTingkat::route('/{record}/edit'),
        ];
    }
}
