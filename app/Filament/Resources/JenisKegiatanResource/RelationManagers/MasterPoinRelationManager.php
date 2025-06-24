<?php

namespace App\Filament\Resources\JenisKegiatanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterPoinRelationManager extends RelationManager
{
    protected static string $relationship = 'masterPoin';

    protected static ?string $modelLabel = 'Indikator';

    // Plural Model Label (Bentuk jamak)
    protected static ?string $pluralModelLabel = 'Indikator';

    protected static ?string $title = 'Indikator';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tingkat_id')
                    ->required()
                    ->relationship('tingkat','nama')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required(),                        
                    ]),
                Forms\Components\Select::make('peran_id')
                    ->required()
                    ->relationship('peran','nama')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nama')
                            ->required(),
                    ]),
                Forms\Components\TextInput::make('poin')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                    
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        
        return $table
            ->recordTitleAttribute('tingkat.nama')
            ->columns([
                Tables\Columns\TextColumn::make('tingkat.nama'),
                Tables\Columns\TextColumn::make('peran.nama'),
                Tables\Columns\TextColumn::make('poin'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
