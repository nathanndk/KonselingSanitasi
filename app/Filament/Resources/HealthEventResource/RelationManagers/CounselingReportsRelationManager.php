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
                                ->default(now())
                                ->helperText('Pilih tanggal pelaksanaan konseling.'),

                            Select::make('patient_id')
                                ->label('Nama Pasien')
                                ->searchable()
                                ->relationship('patient', 'name')
                                ->required()
                                ->preload()
                                ->helperText('Pilih nama pasien atau tambahkan pasien baru.')
                                ->createOptionForm([
                                    TextInput::make('nik')
                                        ->label('NIK')
                                        ->required()
                                        ->unique('patients', 'nik')
                                        ->maxLength(16)
                                        ->helperText('Masukkan 16 digit NIK unik pasien.'),

                                    TextInput::make('name')
                                        ->label('Nama')
                                        ->required()
                                        ->helperText('Masukkan nama lengkap pasien.'),

                                    DatePicker::make('date_of_birth')
                                        ->label('Tanggal Lahir')
                                        ->required()
                                        ->helperText('Pilih tanggal lahir pasien.'),

                                    Select::make('gender')
                                        ->label('Jenis Kelamin')
                                        ->options([
                                            'L' => 'Laki-Laki',
                                            'P' => 'Perempuan',
                                        ])
                                        ->required()
                                        ->helperText('Pilih jenis kelamin pasien.'),

                                    TextInput::make('phone_number')
                                        ->label('Nomor Telepon')
                                        ->required()
                                        ->helperText('Masukkan nomor telepon pasien.'),

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
                                ->nullable()
                                ->helperText('Pilih tanggal untuk kunjungan rumah, jika ada.'),

                            Textarea::make('condition')
                                ->label('Kondisi/Masalah')
                                ->rows(3)
                                ->required()
                                ->helperText('Jelaskan kondisi atau masalah yang dihadapi pasien.'),

                            Textarea::make('recommendation')
                                ->label('Saran/Rekomendasi')
                                ->rows(3)
                                ->required()
                                ->helperText('Tulis saran atau rekomendasi untuk pasien.'),

                            Textarea::make('intervention')
                                ->label('Intervensi')
                                ->rows(3)
                                ->nullable()
                                ->helperText('Catat intervensi yang dilakukan, jika ada.'),

                            Textarea::make('notes')
                                ->label('Keterangan')
                                ->rows(3)
                                ->nullable()
                                ->helperText('Tambahkan keterangan tambahan jika diperlukan.'),
                        ])
                        ->columns(2),
                ])
                ->columns(1),
        ]);
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
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_by'] = Auth::id();
                        $data['updated_by'] = Auth::id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = Auth::id();
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
