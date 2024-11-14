<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CounselingReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'counselingReports';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Fieldset::make('Informasi Konseling')
                            ->schema([
                                DatePicker::make('counseling_date')
                                    ->label('Tanggal Pelaksanaan Konseling')
                                    ->required()
                                    ->default(now()),

                                Select::make('patient_id')
                                    ->label('Nama Pasien')
                                    ->searchable()
                                    ->relationship('patient', 'name')
                                    ->required()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('nik')
                                            ->label('NIK')
                                            ->required()
                                            ->unique('patients', 'nik')
                                            ->maxLength(16),

                                        TextInput::make('name')
                                            ->label('Nama')
                                            ->required(),

                                        DatePicker::make('date_of_birth')
                                            ->label('Tanggal Lahir')
                                            ->required(),

                                        Select::make('gender')
                                            ->label('Jenis Kelamin')
                                            ->options([
                                                'L' => 'Laki-Laki',
                                                'P' => 'Perempuan',
                                            ])
                                            ->required(),

                                        TextInput::make('phone_number')
                                            ->label('Nomor Telepon')
                                            ->required(),

                                        // Select::make('event_id')
                                        //     ->label('Event Kesehatan')
                                        //     ->relationship('event', 'name')
                                        //     ->nullable(),

                                        // Select::make('address_id')
                                        //     ->label('Alamat')
                                        //     ->relationship('address', 'full_address')
                                        //     ->nullable(),

                                        TextInput::make('created_by')
                                            ->default(fn() => Auth::id())
                                            ->hidden(),

                                        TextInput::make('updated_by')
                                            ->default(fn() => Auth::id())
                                            ->hidden(),
                                    ]),
                            ])
                            ->columns(2),

                        Fieldset::make('Detail Konseling')
                            ->schema([
                                DatePicker::make('home_visit_date')
                                    ->label('Tanggal Kunjungan Rumah')
                                    ->columnSpanFull()
                                    ->nullable(),

                                Textarea::make('condition')
                                    ->label('Kondisi/Masalah')
                                    ->rows(3)
                                    ->required(),

                                Textarea::make('recommendation')
                                    ->label('Saran/Rekomendasi')
                                    ->rows(3)
                                    ->required(),

                                Textarea::make('intervention')
                                    ->label('Intervensi')
                                    ->rows(3)

                                    ->nullable(),

                                Textarea::make('notes')
                                    ->label('Keterangan')
                                    ->rows(3)
                                    ->nullable(),
                            ])
                            ->columns(2),

                        // Field untuk 'created_by' dan 'updated_by' yang disembunyikan
                        TextInput::make('created_by')
                            ->default(fn() => Auth::id())
                            ->hidden(),

                        TextInput::make('updated_by')
                            ->default(fn() => Auth::id())
                            ->hidden(),
                    ])
                    ->columns(1),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = Auth::id();
        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([

                TextColumn::make('counseling_date')
                    ->label('Tanggal Pelaksanaan Konseling')
                    ->date()
                    ->sortable(),

                TextColumn::make('patient.name')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.address.street')
                    ->label('Jalan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('patient.address.subdistrict')
                    ->label('Kelurahan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('patient.address.district')
                    ->label('Kecamatan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('condition')
                    ->label('Kondisi/Masalah'),

                TextColumn::make('recommendation')
                    ->label('Saran/Rekomendasi'),

                TextColumn::make('home_visit_date')
                    ->label('Tanggal Kunjungan Rumah')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('intervention')
                    ->label('Intervensi')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('notes')
                    ->label('Keterangan')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_by')
                    ->label('Dibuat Oleh')
                    ->formatStateUsing(fn($state) => $state ? 'User ID ' . $state : null)
                    ->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('updated_by')
                //     ->label('Diperbarui Oleh')
                //     ->formatStateUsing(fn($state) => $state ? 'User ID ' . $state : null)
                //     ->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('created_at')
                //     ->label('Dibuat Pada')
                //     ->dateTime()
                //     ->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('updated_at')
                //     ->label('Diupdate Pada')
                //     ->dateTime()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
