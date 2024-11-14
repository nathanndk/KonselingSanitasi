<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PdamRelationManager extends RelationManager
{
    protected static string $relationship = 'Pdam';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        DatePicker::make('sampling_date')
                            ->label('Tanggal Sampling')
                            ->required(),

                        Select::make('patient_id')
                            ->label('Nama Pasien')
                            ->searchable()
                            ->relationship('patient', 'name') // Adjusted to singular
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

                                TextInput::make('created_by')
                                    ->default(fn() => Auth::id())
                                    ->hidden(),

                                TextInput::make('updated_by')
                                    ->default(fn() => Auth::id())
                                    ->hidden(),
                            ]),

                        Select::make('risk_level')
                            ->label('Tingkat Resiko')
                            ->options([
                                'R' => 'Rendah',
                                'S' => 'Sedang',
                                'T' => 'Tinggi',
                                'ST' => 'Sangat Tinggi',
                            ])
                            ->required(),
                    ])
                    ->columns(1),

                // Card: Hasil Pengukuran
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make(4)->schema([
                            TextInput::make('remaining_chlorine')->label('Sisa Chlor')->numeric(),
                            TextInput::make('ph')->label('pH')->numeric(),
                            TextInput::make('tds_measurement')->label('TDS Pengukuran')->numeric(),
                            TextInput::make('temperature_measurement')->label('Suhu Pengukuran')->numeric(),
                        ]),
                    ])
                    ->columns(1)
                    ->label('Hasil Pengukuran'),

                // Card: Hasil Pemeriksaan Lab
                Forms\Components\Card::make()
                    ->schema([
                        // Subgroup: Mikrobiologi
                        Forms\Components\Fieldset::make('Mikrobiologi')
                            ->schema([
                                Forms\Components\Grid::make(4)->schema([
                                    TextInput::make('total_coliform')->label('Total Coliform')->numeric(),
                                    TextInput::make('e_coli')->label('E. Coli')->numeric(),
                                ]),
                            ]),

                        // Subgroup: Fisika
                        Forms\Components\Fieldset::make('Fisika')
                            ->schema([
                                Forms\Components\Grid::make(4)->schema([
                                    TextInput::make('tds_lab')->label('TDS')->numeric(),
                                    TextInput::make('turbidity')->label('Kekeruhan')->numeric(),
                                    TextInput::make('color')->label('Warna'),
                                    TextInput::make('odor')->label('Bau'),
                                    TextInput::make('temperature_lab')->label('Suhu Lab')->numeric(),
                                ]),
                            ]),

                        // Subgroup: Kimia
                        Forms\Components\Fieldset::make('Kimia')
                            ->schema([
                                Forms\Components\Grid::make(4)->schema([
                                    TextInput::make('aluminium')->label('Aluminium')->numeric(),
                                    TextInput::make('arsenic')->label('Arsen')->numeric(),
                                    TextInput::make('cadmium')->label('Kadmium')->numeric(),
                                    TextInput::make('remaining_chlorine_lab')->label('Sisa Khlor')->numeric(),
                                    TextInput::make('chromium_val_6')->label('Crom Val 6')->numeric(),
                                    TextInput::make('fluoride')->label('Florida')->numeric(),
                                    TextInput::make('iron')->label('Besi')->numeric(),
                                    TextInput::make('lead')->label('Timbal')->numeric(),
                                    TextInput::make('manganese')->label('Mangan')->numeric(),
                                    TextInput::make('nitrite')->label('Nitrit')->numeric(),
                                    TextInput::make('nitrate')->label('Nitrat')->numeric(),
                                    TextInput::make('ph_lab')->label('pH Lab')->numeric(),
                                ]),
                            ]),
                    ])
                    ->columns(1)
                    ->label('Hasil Pemeriksaan Lab'),

                // Card: Keterangan
                Forms\Components\Card::make()
                    ->schema([
                        Textarea::make('notes')->label('Keterangan'),
                    ])
                    ->columns(1)
                    ->label('Keterangan'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('sampling_date')
                    ->label('Tanggal Sampling')
                    ->date()
                    ->sortable(),

                // Patient Information
                TextColumn::make('patient.name')
                    ->label('Nama Pasien')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('patient.nik')
                    ->label('NIK')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('patient.date_of_birth')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable(),

                TextColumn::make('patient.gender')
                    ->label('Jenis Kelamin')
                    ->sortable(),

                TextColumn::make('patient.phone_number')
                    ->label('Nomor Telepon')
                    ->sortable(),

                // Address Information
                TextColumn::make('patient.address.street')
                    ->label('Alamat Jalan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('patient.address.district_code')
                    ->label('Kode Kecamatan')
                    ->sortable(),

                TextColumn::make('patient.address.subdistrict_code')
                    ->label('Kode Kelurahan')
                    ->sortable(),

                // PDAM Resource Information
                TextColumn::make('risk_level')
                    ->label('Tingkat Resiko')
                    ->sortable(),

                TextColumn::make('remaining_chlorine')
                    ->label('Sisa Chlor')
                    ->sortable(),

                TextColumn::make('ph')
                    ->label('pH')
                    ->sortable(),

                TextColumn::make('tds_measurement')
                    ->label('TDS Pengukuran')
                    ->sortable(),

                TextColumn::make('temperature_measurement')
                    ->label('Suhu Pengukuran')
                    ->sortable(),

                TextColumn::make('total_coliform')
                    ->label('Total Coliform')
                    ->sortable(),

                TextColumn::make('e_coli')
                    ->label('E. Coli')
                    ->sortable(),

                TextColumn::make('tds_lab')
                    ->label('TDS Lab')
                    ->sortable(),

                TextColumn::make('turbidity')
                    ->label('Kekeruhan')
                    ->sortable(),

                TextColumn::make('color')
                    ->label('Warna'),

                TextColumn::make('odor')
                    ->label('Bau'),

                TextColumn::make('temperature_lab')
                    ->label('Suhu Lab')
                    ->sortable(),

                TextColumn::make('aluminium')
                    ->label('Aluminium')
                    ->sortable(),

                TextColumn::make('arsenic')
                    ->label('Arsen')
                    ->sortable(),

                TextColumn::make('cadmium')
                    ->label('Kadmium')
                    ->sortable(),

                TextColumn::make('remaining_chlorine_lab')
                    ->label('Sisa Khlor')
                    ->sortable(),

                TextColumn::make('chromium_val_6')
                    ->label('Crom Val 6')
                    ->sortable(),

                TextColumn::make('fluoride')
                    ->label('Florida')
                    ->sortable(),

                TextColumn::make('iron')
                    ->label('Besi')
                    ->sortable(),

                TextColumn::make('lead')
                    ->label('Timbal')
                    ->sortable(),

                TextColumn::make('manganese')
                    ->label('Mangan')
                    ->sortable(),

                TextColumn::make('nitrite')
                    ->label('Nitrit')
                    ->sortable(),

                TextColumn::make('nitrate')
                    ->label('Nitrat')
                    ->sortable(),

                TextColumn::make('ph_lab')
                    ->label('pH Lab')
                    ->sortable(),

                // Additional Notes
                TextColumn::make('notes')
                    ->label('Keterangan')
                    ->sortable()
                    ->searchable(),
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
