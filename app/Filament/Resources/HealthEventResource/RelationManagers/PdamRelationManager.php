<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use App\Models\District;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
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
                Wizard::make([
                    // Step 1: Informasi Dasar
                    Wizard\Step::make('Informasi Dasar')
                        ->description('Masukkan informasi dasar')
                        ->icon('heroicon-o-document')
                        ->schema([
                            // DatePicker::make('sampling_date')
                            //     ->label('Tanggal Sampling')
                            //     ->placeholder('Pilih tanggal pengambilan sampel')
                            //     ->helperText('Masukkan tanggal ketika sampel diambil.')
                            //     ->required(),

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

                                            Forms\Components\Hidden::make('created_by')
                                                ->default(fn() => Auth::id()),

                                            Forms\Components\Hidden::make('updated_by')
                                                ->default(fn() => Auth::id())
                                                ->dehydrated(false)
                                        ])

                                        ->columns(1)
                                        ->label('Informasi Personal'),

                                    Forms\Components\Fieldset::make('Alamat')
                                        ->schema([
                                            // Forms\Components\Select::make('health_center_id')
                                            //     ->label('Puskesmas')
                                            //     ->relationship('healthCenter', 'name')
                                            //     ->placeholder('Pilih puskesmas tempat Anda terdaftar')
                                            //     ->searchable()
                                            //     ->preload()
                                            //     ->helperText('Pilih puskesmas sesuai tempat Anda terdaftar.'),

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

                                            Forms\Components\TextInput::make('address.rt')
                                                ->label('RT')
                                                ->maxLength(3)
                                                ->minLength(3)
                                                ->placeholder('Masukkan RT (3 digit)')
                                                ->helperText('Masukkan RT yang sesuai dengan alamat Anda.')
                                                ->numeric()
                                                ->columnSpan(1),

                                            Forms\Components\TextInput::make('address.rw')
                                                ->label('RW')
                                                ->maxLength(3)
                                                ->minLength(3)
                                                ->placeholder('Masukkan RW (3 digit)')
                                                ->helperText('Masukkan RW yang sesuai dengan alamat Anda.')
                                                ->numeric()
                                                ->columnSpan(1),
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

                    Wizard\Step::make('Hasil Pemeriksaan Lab')
                        ->description('Masukkan hasil pemeriksaan laboratorium')
                        ->icon('heroicon-o-beaker')
                        ->schema([
                            // Mikrobiologi
                            Forms\Components\Fieldset::make('Mikrobiologi')
                                ->schema([
                                    Forms\Components\TextInput::make('total_coliform')
                                        ->label('Total Coliform')
                                        ->placeholder('Masukkan nilai Total Coliform')
                                        ->helperText('Isi dengan hasil tes Total Coliform.'),

                                    Forms\Components\TextInput::make('e_coli')
                                        ->label('E.Coli')
                                        ->placeholder('Masukkan nilai E.Coli')
                                        ->helperText('Isi dengan hasil tes E.Coli.'),
                                ]),

                            // Fisika
                            Forms\Components\Fieldset::make('Fisika')
                                ->schema([
                                    Forms\Components\TextInput::make('tds')
                                        ->label('TDS')
                                        ->placeholder('Masukkan nilai TDS')
                                        ->helperText('Isi dengan hasil tes TDS.'),

                                    Forms\Components\TextInput::make('kekeruhan')
                                        ->label('Kekeruhan')
                                        ->placeholder('Masukkan nilai Kekeruhan')
                                        ->helperText('Isi dengan hasil tes Kekeruhan.'),

                                    Forms\Components\TextInput::make('warna')
                                        ->label('Warna')
                                        ->placeholder('Masukkan nilai Warna')
                                        ->helperText('Isi dengan hasil tes Warna.'),

                                    Forms\Components\TextInput::make('bau')
                                        ->label('Bau')
                                        ->placeholder('Masukkan deskripsi Bau')
                                        ->helperText('Isi dengan hasil pengamatan bau air.'),

                                    Forms\Components\TextInput::make('suhu')
                                        ->label('Suhu')
                                        ->placeholder('Masukkan suhu di laboratorium')
                                        ->helperText('Isi dengan hasil pengukuran suhu dari lab.'),
                                ]),

                            // Kimia
                            Forms\Components\Fieldset::make('Kimia')
                                ->schema([
                                    Forms\Components\TextInput::make('aluminium')
                                        ->label('Al (Aluminium)')
                                        ->placeholder('Masukkan nilai Aluminium')
                                        ->helperText('Isi dengan hasil tes kadar Aluminium.'),

                                    Forms\Components\TextInput::make('arsen')
                                        ->label('Arsen')
                                        ->placeholder('Masukkan nilai Arsen')
                                        ->helperText('Isi dengan hasil tes kadar Arsen.'),

                                    Forms\Components\TextInput::make('kadmium')
                                        ->label('Kadmium')
                                        ->placeholder('Masukkan nilai Kadmium')
                                        ->helperText('Isi dengan hasil tes kadar Kadmium.'),

                                    Forms\Components\TextInput::make('sisa_khlor')
                                        ->label('Sisa Khlor')
                                        ->placeholder('Masukkan nilai Sisa Khlor')
                                        ->helperText('Isi dengan hasil tes kadar Sisa Khlor.'),

                                    Forms\Components\TextInput::make('chrom_val_6')
                                        ->label('Crom Val 6')
                                        ->placeholder('Masukkan nilai Crom Val 6')
                                        ->helperText('Isi dengan hasil tes kadar Crom Val 6.'),

                                    Forms\Components\TextInput::make('fluoride')
                                        ->label('Florida')
                                        ->placeholder('Masukkan nilai Fluoride')
                                        ->helperText('Isi dengan hasil tes kadar Fluoride.'),

                                    Forms\Components\TextInput::make('besi')
                                        ->label('Besi')
                                        ->placeholder('Masukkan nilai Besi')
                                        ->helperText('Isi dengan hasil tes kadar Besi.'),

                                    Forms\Components\TextInput::make('timbal')
                                        ->label('Timbal')
                                        ->placeholder('Masukkan nilai Timbal')
                                        ->helperText('Isi dengan hasil tes kadar Timbal.'),

                                    Forms\Components\TextInput::make('mangan')
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

                                    Forms\Components\TextInput::make('ph')
                                        ->label('pH')
                                        ->placeholder('Masukkan nilai pH')
                                        ->helperText('Isi dengan hasil tes kadar pH air.')
                                ])
                        ]),

                    // Step 4: Keterangan
                    Wizard\Step::make('Keterangan')
                        ->description('Tambahkan keterangan')
                        ->icon('heroicon-o-clipboard')
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
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                // Jika admin atau bidang dinas kesehatan, tidak ada pembatasan data
                if (in_array($user->role, ['admin', 'bidang_dinkes'])) {
                    return $query;
                }

                // Jika puskesmas, hanya melihat data yang terkait dengan puskesmas mereka
                if ($user->role === 'puskesmas') {
                    return $query->whereHas('user.healthCenter', function ($q) use ($user) {
                        $q->where('id', $user->health_center_id);
                    });
                }

                // Jika petugas atau kader, hanya melihat data yang mereka buat
                if (in_array($user->role, ['petugas', 'kader'])) {
                    return $query->whereHas('user.healthCenter', function ($q) use ($user) {
                        $q->where('id', $user->health_center_id);
                    });
                }

                // Default, jika role lain
                return $query->where('id', null); // Tidak menampilkan data apa pun
            })
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Formulir PDAM')
                    ->modalHeading('Buat Formulir PDAM')
                    ->modalButton('Buat Formulir')
                    ->mutateFormDataUsing(function (array $data): array {
                        $event = \App\Models\HealthEvent::find($data['event_id'] ?? null);

                        if ($event) {
                            $data['sampling_date'] = $event->start_date; // Set sampling_date dari event
                        } else {
                            $data['sampling_date'] = now(); // Set nilai default jika event tidak ditemukan
                        }

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
