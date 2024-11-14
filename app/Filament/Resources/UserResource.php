<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengguna')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('username')
                                ->required()
                                ->unique(ignorable: fn ($record) => $record)
                                ->maxLength(255)
                                ->label('Username'),

                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->label('Nama'),

                            TextInput::make('nik')
                                ->label('NIK')
                                ->maxLength(16)
                                ->unique(),

                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->label('Email'),

                            DatePicker::make('date_of_birth')
                                ->label('Tanggal Lahir'),
                        ]),
                    ])->collapsible(),

                Section::make('Keamanan')
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->mutateDehydratedStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(Page $livewire) => ($livewire instanceof CreateUser))
                            ->maxLength(255)
                            ->label('Password'),
                    ])->collapsible(),

                Section::make('Informasi Tambahan')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('health_center_id')
                                ->label('Puskesmas')
                                ->relationship('healthCenter', 'name')
                                ->searchable()
                                ->preload(),

                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ])
                                ->required(),

                            Select::make('role')
                                ->label('Role')
                                ->options([
                                    'admin' => 'Admin',
                                    'kader' => 'Kader',
                                    'petugas' => 'Petugas',
                                    'puskesmas' => 'Puskesmas',
                                    'dinas_kesehatan' => 'Dinas Kesehatan',
                                ])
                                ->required(),
                        ]),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->label('Username'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),

                Tables\Columns\TextColumn::make('nik')
                    ->searchable()
                    ->label('NIK')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->label('Tanggal Lahir')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('healthCenter.name')
                    ->label('Puskesmas')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat Pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Diupdate Pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Definisikan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
