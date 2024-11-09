<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use App\Models\District;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PatientsRelationManager extends RelationManager
{
    protected static string $relationship = 'patients';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
