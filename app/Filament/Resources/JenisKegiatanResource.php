<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisKegiatanResource\Pages;
use App\Filament\Resources\JenisKegiatanResource\RelationManagers;
use App\Models\JenisKegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisKegiatanResource extends Resource
{
    protected static ?string $model = JenisKegiatan::class;

    // Model Label (Nama yang akan muncul di UI)
    protected static ?string $modelLabel = 'Jenis Kegiatan';

    // Plural Model Label (Bentuk jamak)
    protected static ?string $pluralModelLabel = 'Jenis Kegiatan';

    // Navigation Icon (Ikon di sidebar)
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    // Navigation Group (Mengelompokkan menu di sidebar)
    protected static ?string $navigationGroup = 'Data Master';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            // Input field for the activity type name.
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true) // Ensure the name is unique, ignoring the current record on edit.
                    ->label('Nama Jenis Kegiatan'),
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
            RelationManagers\MasterPoinRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJenisKegiatans::route('/'),
            'create' => Pages\CreateJenisKegiatan::route('/create'),
            'edit' => Pages\EditJenisKegiatan::route('/{record}/edit'),
        ];
    }
}
