<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use App\Models\District;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getPluralLabel(): string
    {
        return 'Pasien';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pasien';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
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
                            ->columns(2),
                    ]),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('Alamat')
                            ->schema([
                                Forms\Components\TextInput::make('address.street')
                                    ->label('Jalan')
                                    ->required(),

                                Select::make('address.district_code')
                                    ->label('Kecamatan')
                                    ->options(District::pluck('district_name', 'district_code'))
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(function ($set) {
                                        $set('address.subdistrict_code', null);
                                    })
                                    ->required(),

                                Select::make('address.subdistrict_code')
                                    ->label('Kelurahan')
                                    ->options(function (callable $get) {
                                        $districtCode = $get('address.district_code');
                                        return $districtCode ? Subdistrict::where('district_code', $districtCode)->pluck('subdistrict_name', 'subdistrict_code') : [];
                                    })
                                    ->searchable()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->label('Detail Alamat'),
                    ])
                    ->label('Informasi Alamat'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')->label('NIK')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_of_birth')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('gender')->label('Jenis Kelamin'),
                TextColumn::make('phone_number')
                    ->label('Nomor Telepon')
                    ->searchable(),
                TextColumn::make('address.street')
                    ->label('Alamat')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
        return [];
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
