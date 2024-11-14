<?php

namespace App\Filament\Resources;

use App\Filament\Exports\SanitationConditionExporter;
use App\Filament\Resources\SanitationConditionResource\Pages;
use App\Models\SanitationCondition;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\ExportAction;

class SanitationConditionResource extends Resource
{
    protected static ?string $model = SanitationCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Laporan';

    public static function getPluralLabel(): string
    {
        return 'Konseling Sanitasi';
    }

    public static function getNavigationLabel(): string
    {
        return 'Konseling Sanitasi';
    }



    public static function form(Form $form): Form
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


    public static function table(Table $table): Table
    {
        return $table
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
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SanitationConditionExporter::class)
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
            'index' => Pages\ListSanitationConditions::route('/'),
            // 'create' => Pages\CreateSanitationCondition::route('/create'),
            // 'edit' => Pages\EditSanitationCondition::route('/{record}/edit'),
        ];
    }
}
