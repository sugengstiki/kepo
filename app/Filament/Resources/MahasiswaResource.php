<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MahasiswaResource\Pages;
use App\Filament\Resources\MahasiswaResource\RelationManagers;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('nrp')->required()->unique('mahasiswas', 'nrp', ignoreRecord: true),
            Forms\Components\TextInput::make('nama')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->unique('mahasiswas', 'email', ignoreRecord: true)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    $user = User::where('email', $state)->first();

                    if ($user) {
                        // Jika user ditemukan, set user_id otomatis
                        $set('user_id', $user->id);
                    } else {
                        // Kosongkan user_id kalau email tidak ditemukan
                        $set('user_id', null);
                    }
                }),
            Forms\Components\TextInput::make('tahun_masuk')->required()->numeric()->minValue(2000)->maxValue(date('Y')),
            Forms\Components\Select::make('program_studi_id')
                ->label('Program Studi')
                ->options(ProgramStudi::all()->pluck('nama', 'id'))
                // ->searchable()
                ->required(),
            Forms\Components\Select::make('user_id')
                ->label('Akun Login')
                ->relationship('user', 'email')
                // ->disabled(fn(callable $get) => User::where('email', $get('email'))->exists())
                // ->options(function () {
                //     return User::orderBy('email')->pluck('email', 'id');
                // })
                ->dehydrated()
                ->searchable()
                ->required()
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required(),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->required()
                        ->minLength(8),
                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable(),                                         
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nrp'),
                Tables\Columns\TextColumn::make('nama'),
                Tables\Columns\TextColumn::make('tahun_masuk'),
                Tables\Columns\TextColumn::make('programStudi.nama')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('TotalPoinMahasiswa.total_poin')
                    ->label('Total Poin')
                    ->default(0),

        ])
            ->filters([
                Tables\Filters\SelectFilter::make('program_studi_id')
                    ->label('Program Studi')
                    ->options(ProgramStudi::all()->pluck('nama', 'id')),

                Tables\Filters\SelectFilter::make('tahun_masuk')
                    ->options(function () {
                        return Mahasiswa::query()
                            ->pluck('tahun_masuk', 'tahun_masuk')
                            ->sort();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\Action::make('poin')
                //     ->label('Lihat Poin')
                //     ->url(fn($record) => MahasiswaResource::getUrl('poin', ['record' => $record]))
                //     ->icon('heroicon-o-eye'),
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
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
