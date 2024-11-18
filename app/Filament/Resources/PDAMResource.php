<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PdamExporter;
use App\Filament\Resources\PDAMResource\Pages;
use App\Models\District;
use App\Models\Pdam;
use App\Models\Subdistrict;
use Filament\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction as ActionsExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PDAMResource extends Resource
{
    protected static ?string $model = Pdam::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Laporan';

    public static function getPluralLabel(): string
    {
        return 'PDAM';
    }

    public static function getNavigationLabel(): string
    {
        return 'PDAM';
    }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Wizard::make([
                    // Step 1: Informasi Dasar
                    Wizard\Step::make('Informasi Dasar')
                        ->description('Masukkan informasi dasar')
                        ->icon('heroicon-o-document')
                        ->schema([
                            DatePicker::make('sampling_date')
                                ->label('Tanggal Sampling')
                                ->placeholder('Pilih tanggal pengambilan sampel')
                                ->helperText('Masukkan tanggal ketika sampel diambil.')
                                ->required(),

                            Select::make('patient_id')
                                ->label('Nama Pasien')
                                ->searchable()
                                ->relationship('patient', 'name')
                                ->required()
                                ->preload()
                                ->helperText('Pilih pasien dari daftar. Anda juga dapat menambahkan pasien baru.')
                                ->createOptionForm([
                                    Forms\Components\Fieldset::make('Informasi Personal')
                                        ->schema([
                                            Forms\Components\TextInput::make('nik')
                                                ->label('NIK')
                                                ->required()
                                                ->maxLength(16)
                                                ->minLength(16)
                                                ->placeholder('Masukkan NIK 16 digit')
                                                ->helperText('NIK adalah Nomor Induk Kependudukan yang terdapat pada KTP.'),

                                            Forms\Components\TextInput::make('name')
                                                ->label('Nama')
                                                ->required()
                                                ->maxLength(50)
                                                ->placeholder('Masukkan nama lengkap')
                                                ->helperText('Gunakan nama sesuai identitas resmi.'),

                                            Forms\Components\DatePicker::make('date_of_birth')
                                                ->label('Tanggal Lahir')
                                                ->required()
                                                ->rule('before_or_equal:today')
                                                ->placeholder('Pilih tanggal lahir')
                                                ->helperText('Masukkan tanggal lahir sesuai dokumen resmi.')
                                                ->maxDate(now()),

                                            Forms\Components\Select::make('gender')
                                                ->label('Jenis Kelamin')
                                                ->options([
                                                    'L' => 'Laki-laki',
                                                    'P' => 'Perempuan',
                                                ])
                                                ->required()
                                                ->placeholder('Pilih jenis kelamin')
                                                ->helperText('Pilih salah satu sesuai jenis kelamin.'),

                                            Forms\Components\TextInput::make('phone_number')
                                                ->label('Nomor Telepon')
                                                ->minLength(10)
                                                ->maxLength(15)
                                                ->placeholder('Masukkan nomor telepon aktif')
                                                ->helperText('Gunakan nomor telepon yang aktif dan dapat dihubungi.'),
                                        ])
                                        ->columns(1)
                                        ->label('Informasi Personal'),

                                    Forms\Components\Fieldset::make('Alamat')
                                        ->schema([
                                            Forms\Components\Select::make('health_center_id')
                                                ->label('Puskesmas')
                                                ->relationship('healthCenter', 'name')
                                                ->placeholder('Pilih puskesmas tempat Anda terdaftar')
                                                ->searchable()
                                                ->preload()
                                                ->helperText('Pilih puskesmas sesuai tempat Anda terdaftar.'),

                                            Forms\Components\Textarea::make('address.street')
                                                ->label('Jalan')
                                                ->placeholder('Masukkan nama jalan')
                                                ->helperText('Cantumkan nama jalan tempat Anda tinggal saat ini.'),

                                            Forms\Components\Select::make('address.district_code')
                                                ->label('Kecamatan')
                                                ->options(District::pluck('district_name', 'district_code'))
                                                ->searchable()
                                                ->reactive()
                                                ->placeholder('Pilih kecamatan')
                                                ->helperText('Isi dengan kecamatan tempat tinggal Anda.')
                                                ->afterStateUpdated(function ($set) {
                                                    $set('address.subdistrict_code', null);
                                                }),

                                            Forms\Components\Select::make('address.subdistrict_code')
                                                ->label('Kelurahan')
                                                ->options(function (callable $get) {
                                                    $districtCode = $get('address.district_code');
                                                    return $districtCode
                                                        ? Subdistrict::where('district_code', $districtCode)->pluck('subdistrict_name', 'subdistrict_code')
                                                        : [];
                                                })
                                                ->searchable()
                                                ->placeholder('Pilih kelurahan')
                                                ->helperText('Isi dengan kelurahan tempat tinggal Anda.'),
                                        ])
                                        ->columns(1)
                                        ->label('Detail Alamat'),
                                ]),

                            Select::make('risk_level')
                                ->label('Tingkat Resiko')
                                ->options([
                                    'R' => 'Rendah',
                                    'S' => 'Sedang',
                                    'T' => 'Tinggi',
                                    'ST' => 'Sangat Tinggi',
                                ])
                                ->required()
                                ->placeholder('Pilih tingkat resiko')
                                ->helperText('Pilih tingkat resiko berdasarkan hasil pemeriksaan.'),
                        ]),

                    // Step 2: Hasil Pengukuran
                    Wizard\Step::make('Hasil Pengukuran')
                        ->description('Isi hasil pengukuran')
                        ->icon('heroicon-o-chart-bar')
                        ->schema([
                            Forms\Components\TextInput::make('remaining_chlorine')
                                ->label('Sisa Chlor')
                                ->placeholder('Masukkan nilai sisa chlor')
                                ->helperText('Isi dengan hasil pengukuran sisa chlor.'),

                            Forms\Components\TextInput::make('ph')
                                ->label('pH')
                                ->placeholder('Masukkan nilai pH')
                                ->helperText('Isi dengan hasil pengukuran pH.'),

                            Forms\Components\TextInput::make('tds_measurement')
                                ->label('TDS Pengukuran')
                                ->placeholder('Masukkan nilai TDS')
                                ->helperText('Isi dengan hasil pengukuran Total Dissolved Solids (TDS).'),

                            Forms\Components\TextInput::make('temperature_measurement')
                                ->label('Suhu Pengukuran')
                                ->placeholder('Masukkan suhu')
                                ->helperText('Isi dengan hasil pengukuran suhu air.'),
                        ]),

                    // Step 3: Hasil Pemeriksaan Lab
                    Wizard\Step::make('Hasil Pemeriksaan Lab')
                        ->description('Masukkan hasil pemeriksaan laboratorium')
                        ->icon('heroicon-o-beaker')
                        ->schema([
                            Forms\Components\TextInput::make('odor')
                                ->label('Bau')
                                ->placeholder('Masukkan deskripsi bau')
                                ->helperText('Isi dengan hasil pengamatan bau air.'),

                            Forms\Components\TextInput::make('temperature_measurement')
                                ->label('Suhu Lab')
                                ->placeholder('Masukkan suhu di laboratorium')
                                ->helperText('Isi dengan hasil pengukuran suhu dari lab.'),

                            Forms\Components\TextInput::make('fluoride')
                                ->label('Florida')
                                ->placeholder('Masukkan nilai Florida')
                                ->helperText('Isi dengan hasil tes kadar Fluoride.'),

                            Forms\Components\TextInput::make('iron')
                                ->label('Besi')
                                ->placeholder('Masukkan nilai Besi')
                                ->helperText('Isi dengan hasil tes kadar Besi.'),

                            Forms\Components\TextInput::make('lead')
                                ->label('Timbal')
                                ->placeholder('Masukkan nilai Timbal')
                                ->helperText('Isi dengan hasil tes kadar Timbal.'),

                            Forms\Components\TextInput::make('manganese')
                                ->label('Mangan')
                                ->placeholder('Masukkan nilai Mangan')
                                ->helperText('Isi dengan hasil tes kadar Mangan.'),

                            Forms\Components\TextInput::make('nitrite')
                                ->label('Nitrit')
                                ->placeholder('Masukkan nilai Nitrit')
                                ->helperText('Isi dengan hasil tes kadar Nitrit.'),

                            Forms\Components\TextInput::make('nitrate')
                                ->label('Nitrat')
                                ->placeholder('Masukkan nilai Nitrat')
                                ->helperText('Isi dengan hasil tes kadar Nitrat.'),
                        ]),

                    // Step 4: Keterangan
                    Wizard\Step::make('Keterangan')
                        ->description('Tambahkan keterangan')
                        ->icon('heroicon-o-home')
                        ->schema([
                            Forms\Components\Textarea::make('notes')
                                ->label('Keterangan')
                                ->placeholder('Masukkan keterangan tambahan')
                                ->helperText('Isi dengan keterangan tambahan terkait sampel atau hasil pemeriksaan.')
                                ->rows(5)
                                ->maxLength(255),
                        ]),
                ])
                ->columnSpanFull(),
            ]);
    }





    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sampling_date')
                    ->label('Tanggal Sampling')
                    ->date('d F Y')
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
                    ->date('d F Y')
                    ->sortable(),

                    TextColumn::make('patient.gender')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(function ($state) {
                        return $state === 'L' ? 'Laki-laki' : ($state === 'P' ? 'Perempuan' : '-');
                    })
                    ->default('-')
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
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                switch ($user->role) {
                    case 'Petugas':
                        $query->where('created_by', $user->id);
                        break;

                    case 'Kader':
                        $query->where('created_by', $user->id);
                        break;

                    case 'Puskesmas':
                        $query->where('health_center_id', $user->health_center_id);
                        break;
                }

                return $query;
            })
            ->filters([
                // Define any filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ActionsExportAction::make()
                    ->exporter(PdamExporter::class)
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
            'index' => Pages\ListPDAMS::route('/'),
            // 'create' => Pages\CreatePDAM::route('/create'),
            'edit' => Pages\EditPDAM::route('/{record}/edit'),
        ];
    }
}
