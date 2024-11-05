<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Address;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getPluralLabel(): string
    {
        return 'Pasien';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pasien';
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Card::make()
            ->schema([
                // Fieldset for grouping personal information fields
                Forms\Components\Fieldset::make('Informasi Personal')
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->maxLength(16),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Tanggal Lahir')
                            ->required(),

                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor Telepon')
                            ->maxLength(15),
                    ])
                    ->columns(2), // Display personal info fields in two columns
            ]),

            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Fieldset::make('Alamat')
                        ->schema([
                            Forms\Components\TextInput::make('address.street')
                                ->label('Jalan')
                                ->required(),

                            Forms\Components\TextInput::make('address.subdistrict')
                                ->label('Kelurahan')
                                ->required(),

                            Forms\Components\TextInput::make('address.district')
                                ->label('Kecamatan')
                                ->required(),

                            Forms\Components\TextInput::make('address.city')
                                ->label('Kota')
                                ->required(),

                            Forms\Components\TextInput::make('address.province')
                                ->label('Provinsi')
                                ->required(),
                        ])
                        ->columns(2)
                        ->label('Detail Alamat'),
                ])
                ->label('Informasi Alamat'),
        ]);
}



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')->label('NIK')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Nomor Telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address.street')
                    ->label('Alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Tanggal Diupdate')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
