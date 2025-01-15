<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use App\Enums\TingkatResiko;
use App\Models\District;
use App\Models\Patient;
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
    protected static ?string $title = 'PDAM';

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
                                ->columnSpanFull()
                                ->getSearchResultsUsing(
                                    fn(string $search): array =>
                                    Patient::query()
                                        ->where('nik', 'like', "%{$search}%") // Pencarian berdasarkan NIK
                                        ->orWhere('name', 'like', "%{$search}%") // Tambahkan pencarian nama jika dibutuhkan
                                        ->limit(50)
                                        ->get()
                                        ->mapWithKeys(fn($patient) => [$patient->id => "{$patient->name} ({$patient->nik})"]) // Format: Nama (NIK)
                                        ->toArray()
                                )
                                ->getOptionLabelUsing(
                                    fn($value): ?string =>
                                    Patient::find($value)?->name // Tampilkan hanya Nama Pasien saat dipilih
                                )
                                ->required()
                                ->placeholder('Pilih nama pasien')
                                ->helperText('Cari pasien menggunakan NIK atau nama.')
                                ->createOptionUsing(function (array $data): int {
                                    // Logika penyimpanan data baru
                                    $record = Patient::create($data);

                                    // Mengembalikan primary key dari record yang baru dibuat
                                    return $record->getKey();
                                })
                                ->createOptionForm([
                                    // Form pembuatan pasien baru tetap diisi sesuai kebutuhan Anda
                                    Forms\Components\Fieldset::make('Informasi Personal')
                                        ->schema([
                                            TextInput::make('nik')
                                                ->label('NIK')
                                                ->maxLength(16)
                                                ->minLength(16)
                                                ->unique()
                                                ->placeholder('Masukkan NIK 16 digit')
                                                ->helperText('NIK adalah Nomor Induk Kependudukan yang terdapat di KTP.')
                                                ->numeric()
                                                ->columnSpanFull(),
                                            TextInput::make('name')
                                                ->label('Nama')
                                                ->required()
                                                ->maxLength(50)
                                                ->placeholder('Masukkan nama lengkap Anda sesuai KTP')
                                                ->helperText('Gunakan nama sesuai identitas resmi.')
                                                ->columnSpanFull(),
                                            DatePicker::make('date_of_birth')
                                                ->label('Tanggal Lahir')
                                                ->required()
                                                ->rule('before_or_equal:today')
                                                ->placeholder('Pilih tanggal lahir')
                                                ->helperText('Masukkan tanggal lahir Anda.')
                                                ->maxDate(now())
                                                ->columnSpanFull(),
                                            Select::make('gender')
                                                ->label('Jenis Kelamin')
                                                ->options([
                                                    'L' => 'Laki-laki',
                                                    'P' => 'Perempuan',
                                                ])
                                                ->required()
                                                ->placeholder('Pilih jenis kelamin')
                                                ->helperText('Pilih salah satu sesuai jenis kelamin Anda.')
                                                ->columnSpanFull(),
                                            TextInput::make('phone_number')
                                                ->label('Nomor Telepon')
                                                ->minLength(10)
                                                ->maxLength(15)
                                                ->numeric()
                                                ->unique()
                                                ->placeholder('Masukkan nomor telepon aktif')
                                                ->helperText('Gunakan nomor telepon yang aktif dan dapat dihubungi.')
                                                ->columnSpanFull(),
                                        ])
                                        ->columnSpanFull(),
                                ]),

                            Select::make('risk_level')
                                ->label('Tingkat Resiko')
                                ->validationMessages([
                                    'required' => 'Tingkat Resiko wajib diisi.',
                                ])
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
                                ->helperText('Isi dengan hasil pengukuran sisa chlor.')
                                ->numeric(),

                            Forms\Components\TextInput::make('ph')
                                ->label('pH')
                                ->placeholder('Masukkan nilai pH')
                                ->helperText('Isi dengan hasil pengukuran pH.')
                                ->numeric(),

                            Forms\Components\TextInput::make('tds_measurement')
                                ->label('TDS Pengukuran')
                                ->placeholder('Masukkan nilai TDS')
                                ->helperText('Isi dengan hasil pengukuran Total Dissolved Solids (TDS).')
                                ->numeric(),

                            Forms\Components\TextInput::make('temperature_measurement')
                                ->label('Suhu Pengukuran')
                                ->placeholder('Masukkan suhu')
                                ->helperText('Isi dengan hasil pengukuran suhu air.')
                                ->numeric(),
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
                                        ->helperText('Isi dengan hasil tes Total Coliform.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('e_coli')
                                        ->label('E.Coli')
                                        ->placeholder('Masukkan nilai E.Coli')
                                        ->helperText('Isi dengan hasil tes E.Coli.')
                                        ->numeric(),
                                ]),

                            // Fisika
                            Forms\Components\Fieldset::make('Fisika')
                                ->schema([
                                    Forms\Components\TextInput::make('tds_lab')
                                        ->label('TDS')
                                        ->placeholder('Masukkan nilai TDS')
                                        ->helperText('Isi dengan hasil tes TDS.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('turbidity')
                                        ->label('Kekeruhan')
                                        ->placeholder('Masukkan nilai Kekeruhan')
                                        ->helperText('Isi dengan hasil tes Kekeruhan.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('color')
                                        ->label('Warna')
                                        ->placeholder('Masukkan nilai Warna')
                                        ->helperText('Isi dengan hasil tes Warna.')
                                        ->numeric(),

                                    Forms\Components\Select::make('odor')
                                        ->label('Bau')
                                        ->options([
                                            'bau' => 'Bau',
                                            'tidak_berbau' => 'Tidak berbau',
                                        ])
                                        // ->placeholder('Pilih jenis bau')
                                        ->helperText('Pilih apakah air berbau atau tidak.'),


                                    Forms\Components\TextInput::make('temperature_lab')
                                        ->label('Suhu')
                                        ->placeholder('Masukkan suhu di laboratorium')
                                        ->helperText('Isi dengan hasil pengukuran suhu dari lab.')
                                        ->numeric(),
                                ]),

                            // Kimia
                            Forms\Components\Fieldset::make('Kimia')
                                ->schema([
                                    Forms\Components\TextInput::make('aluminium')
                                        ->label('Al (Aluminium)')
                                        ->placeholder('Masukkan nilai Aluminium')
                                        ->helperText('Isi dengan hasil tes kadar Aluminium.'),

                                    Forms\Components\TextInput::make('arsenic')
                                        ->label('Arsen')
                                        ->placeholder('Masukkan nilai Arsen')
                                        ->helperText('Isi dengan hasil tes kadar Arsen.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('cadmium')
                                        ->label('Kadmium')
                                        ->placeholder('Masukkan nilai Kadmium')
                                        ->helperText('Isi dengan hasil tes kadar Kadmium.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('remaining_chlorine_lab')
                                        ->label('Sisa Khlor')
                                        ->placeholder('Masukkan nilai Sisa Khlor')
                                        ->helperText('Isi dengan hasil tes kadar Sisa Khlor.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('chromium_val_6')
                                        ->label('Crom Val 6')
                                        ->placeholder('Masukkan nilai Crom Val 6')
                                        ->helperText('Isi dengan hasil tes kadar Crom Val 6.'),

                                    Forms\Components\TextInput::make('fluoride')
                                        ->label('Florida')
                                        ->placeholder('Masukkan nilai Fluoride')
                                        ->helperText('Isi dengan hasil tes kadar Fluoride.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('iron')
                                        ->label('Besi')
                                        ->placeholder('Masukkan nilai Besi')
                                        ->helperText('Isi dengan hasil tes kadar Besi.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('lead')
                                        ->label('Timbal')
                                        ->placeholder('Masukkan nilai Timbal')
                                        ->helperText('Isi dengan hasil tes kadar Timbal.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('manganese')
                                        ->label('Mangan')
                                        ->placeholder('Masukkan nilai Mangan')
                                        ->helperText('Isi dengan hasil tes kadar Mangan.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('nitrite')
                                        ->label('Nitrit')
                                        ->placeholder('Masukkan nilai Nitrit')
                                        ->helperText('Isi dengan hasil tes kadar Nitrit.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('nitrate')
                                        ->label('Nitrat')
                                        ->placeholder('Masukkan nilai Nitrat')
                                        ->helperText('Isi dengan hasil tes kadar Nitrat.')
                                        ->numeric(),

                                    Forms\Components\TextInput::make('ph_lab')
                                        ->label('pH')
                                        ->placeholder('Masukkan nilai pH')
                                        ->helperText('Isi dengan hasil tes kadar pH air.')
                                        ->numeric(),
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
                    ->date('d F Y')
                    ->sortable(),

                // Patient Information
                TextColumn::make('patient.name')
                    ->label('Nama Pasien')
                    ->searchable(),

                TextColumn::make('patient.nik')
                    ->label('NIK')
                    ->searchable(),

                // TextColumn::make('patient.date_of_birth')
                //     ->label('Tanggal Lahir')
                //     ->date()
                //     ->sortable(),

                // TextColumn::make('patient.gender')
                //     ->label('Jenis Kelamin')
                //     ->sortable(),

                // TextColumn::make('patient.phone_number')
                //     ->label('Nomor Telepon')
                //     ->sortable(),

                // Address Information
                TextColumn::make('patient.address.street')
                    ->label('Alamat')
                    ->searchable(),

                // TextColumn::make('patient.address.district_code')
                //     ->label('Kode Kecamatan')
                //     ->sortable(),

                // TextColumn::make('patient.address.subdistrict_code')
                //     ->label('Kode Kelurahan')
                //     ->sortable(),

                // PDAM Resource Information
                TextColumn::make('risk_level')
                    ->label('Tingkat Resiko')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            TingkatResiko::Rendah => 'Rendah',
                            TingkatResiko::Sedang => 'Sedang',
                            TingkatResiko::Tinggi => 'Tinggi',
                            TingkatResiko::SangatTinggi => 'Sangat Tinggi',
                            default => '-',
                        };
                    })
                    ->sortable()
                    ->searchable(),


                // TextColumn::make('remaining_chlorine')
                //     ->label('Sisa Chlor')
                //     ->sortable(),

                // TextColumn::make('ph')
                //     ->label('pH')
                //     ->sortable(),

                // TextColumn::make('tds_measurement')
                //     ->label('TDS Pengukuran')
                //     ->sortable(),

                // TextColumn::make('temperature_measurement')
                //     ->label('Suhu Pengukuran')
                //     ->sortable(),

                // TextColumn::make('total_coliform')
                //     ->label('Total Coliform')
                //     ->sortable(),

                // TextColumn::make('e_coli')
                //     ->label('E. Coli')
                //     ->sortable(),

                // TextColumn::make('tds_lab')
                //     ->label('TDS Lab')
                //     ->sortable(),

                // TextColumn::make('turbidity')
                //     ->label('Kekeruhan')
                //     ->sortable(),

                // TextColumn::make('color')
                //     ->label('Warna'),

                // TextColumn::make('odor')
                //     ->label('Bau'),

                // TextColumn::make('temperature_lab')
                //     ->label('Suhu Lab')
                //     ->sortable(),

                // TextColumn::make('aluminium')
                //     ->label('Aluminium')
                //     ->sortable(),

                // TextColumn::make('arsenic')
                //     ->label('Arsen')
                //     ->sortable(),

                // TextColumn::make('cadmium')
                //     ->label('Kadmium')
                //     ->sortable(),

                // TextColumn::make('remaining_chlorine_lab')
                //     ->label('Sisa Khlor')
                //     ->sortable(),

                // TextColumn::make('chromium_val_6')
                //     ->label('Crom Val 6')
                //     ->sortable(),

                // TextColumn::make('fluoride')
                //     ->label('Florida')
                //     ->sortable(),

                // TextColumn::make('iron')
                //     ->label('Besi')
                //     ->sortable(),

                // TextColumn::make('lead')
                //     ->label('Timbal')
                //     ->sortable(),

                // TextColumn::make('manganese')
                //     ->label('Mangan')
                //     ->sortable(),

                // TextColumn::make('nitrite')
                //     ->label('Nitrit')
                //     ->sortable(),

                // TextColumn::make('nitrate')
                //     ->label('Nitrat')
                //     ->sortable(),

                // TextColumn::make('ph_lab')
                //     ->label('pH Lab')
                //     ->sortable(),

                // Additional Notes
                TextColumn::make('notes')
                    ->label('Keterangan')
                    ->limit(10)
                    ->tooltip(fn($record) => $record->notes),

            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                // Jika admin atau bidang dinas kesehatan, tidak ada pembatasan data
                if (in_array($user->role, ['admin', 'dinas_kesehatan'])) {
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
                    ->disableCreateAnother()
                    ->label('Buat Formulir PDAM')
                    ->modalHeading('Buat Formulir PDAM')
                    ->modalButton('Buat Formulir')
                    ->mutateFormDataUsing(function (array $data): array {
                        $event = \App\Models\HealthEvent::find($data['event_id'] ?? null);

                        if ($event) {
                            $data['sampling_date'] = $event->start_date;
                        } else {
                            $data['sampling_date'] = now();
                        }

                        $data['created_by'] = Auth::id();
                        $data['updated_by'] = Auth::id();

                        return $data;
                    }),

            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->modalHeading('Lihat Data PDAM'),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = Auth::id();
                        return $data;
                    })
                    ->modalHeading('Ubah Data PDAM'),
                Tables\Actions\DeleteAction::make()
                ->modalHeading('Hapus Data PDAM'),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ])
        ;
    }
}
