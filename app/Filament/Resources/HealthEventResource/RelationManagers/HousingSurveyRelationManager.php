<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class HousingSurveyRelationManager extends RelationManager
{
    protected static string $relationship = 'HousingSurvey';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section: Data Umum
                Forms\Components\Section::make('Data Umum')
                    ->schema([
                        Forms\Components\DatePicker::make('sampling_date')
                            ->label('Tanggal Kunjungan'),

                        Select::make('patient_id')
                            ->label('Nama Pasien')
                            ->searchable()
                            ->relationship('patient', 'name')
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('nik')
                                    ->label('NIK')
                                    ->unique('patients', 'nik')
                                    ->maxLength(16)
                                    ->minLength(16),

                                TextInput::make('name')
                                    ->label('Nama'),

                                DatePicker::make('date_of_birth')
                                    ->label('Tanggal Lahir'),

                                Select::make('gender')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'L' => 'Laki-Laki',
                                        'P' => 'Perempuan',
                                    ]),

                                TextInput::make('phone_number')
                                    ->label('Nomor Telepon'),

                                TextInput::make('created_by')
                                    ->default(fn() => Auth::id())
                                    ->hidden(),

                                TextInput::make('updated_by')
                                    ->default(fn() => Auth::id())
                                    ->hidden(),
                            ]),

                        Forms\Components\TextInput::make('diagnosed_disease')
                            ->label('Penyakit yang Didiagnosis')
                            ->placeholder('Tulis nama penyakitnya jika ada')
                            ->maxLength(100),

                        Forms\Components\TextInput::make('head_of_family')
                            ->label('Nama Kepala Keluarga')
                            ->maxLength(50),

                        Forms\Components\Select::make('drinking_water_source')
                            ->label('Sumber Air Minum')
                            ->options([
                                'ISI_ULANG' => 'Isi Ulang',
                                'AMDK' => 'Air Minum Dalam Kemasan',
                                'SGL' => 'Sumur Gali',
                                'ARTERTIS' => 'Air Tanah',
                                'MATA_AIR' => 'Mata Air'
                            ]),

                        Forms\Components\Select::make('clean_water_source')
                            ->label('Sumber Air Bersih')
                            ->options([
                                'ISI_ULANG' => 'Isi Ulang',
                                'AMDK' => 'Air Minum Dalam Kemasan',
                                'SGL' => 'Sumur Gali',
                                'ARTERTIS' => 'Air Tanah',
                                'MATA_AIR' => 'Mata Air'
                            ]),

                        Forms\Components\Select::make('last_education')
                            ->label('Pendidikan Terakhir Kepala Keluarga')
                            ->placeholder('Misalnya: SD, SMP, SMA')
                            ->options([
                                'tidak_sekolah' => 'Tidak Sekolah',
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA' => 'SMA',
                                'DIII' => 'DIII',
                                'DIV' => 'DIV',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3'

                            ]),

                        Forms\Components\TextInput::make('job')
                            ->label('Pekerjaan Kepala Keluarga')
                            ,

                        Forms\Components\TextInput::make('family_members')
                            ->label('Jumlah Jiwa dalam KK')
                            ->numeric(),

                        Forms\Components\Select::make('house_ownership')
                            ->label('Status Kepemilikan Rumah')
                            ->options([
                                'rumah_sendiri' => 'Rumah Sendiri',
                                'kontrak' => 'Rumah Kontrak',
                            ]),

                        Forms\Components\TextInput::make('house_area')
                            ->label('Luas Rumah (m²)')
                            ->numeric(),
                    ])
                    ->columns(2),

                // Section: Rumah Layak
                Forms\Components\Section::make('Rumah Layak')
                    ->schema([
                        // Lokasi Rumah
                        Forms\Components\Section::make('Lokasi Rumah')
                            ->schema([
                                Forms\Components\Radio::make('landslide_prone')
                                    ->label('Tidak berada di lokasi rawan longsor')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('garbage_site_nearby')
                                    ->label('Tidak berada di lokasi bekas tempat pembuangan sampah akhir')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('high_voltage_area')
                                    ->label('Lokasi tidak berada pada jalur tegangan tinggi')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(1),

                        // Atap Rumah
                        Forms\Components\Section::make('Atap Rumah')
                            ->schema([
                                Forms\Components\Radio::make('roof_strong_no_leak')
                                    ->label('Bangunan kuat, tidak bocor, dan tidak menjadi tempat perindukan tikus')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('roof_drainage')
                                    ->label('Memiliki drainase atap yang memadai untuk limpasan air hujan')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(1),

                        // Langit-langit Rumah
                        Forms\Components\Section::make('Langit-langit Rumah')
                            ->schema([
                                Forms\Components\Radio::make('ceiling_strong_safe')
                                    ->label('Bangunan kuat dan aman')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('ceiling_clean_no_dust')
                                    ->label('Mudah dibersihkan dan tidak menyerap debu')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('ceiling_flat_adequate_air')
                                    ->label('Permukaan rata dan mempunyai ketinggian yang memungkinkan adanya pertukaran udara yang cukup')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('ceiling_clean_condition')
                                    ->label('Kondisi dalam keadaan bersih')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(2),

                        // Dinding Rumah
                        Forms\Components\Section::make('Dinding Rumah')
                            ->schema([
                                Forms\Components\Radio::make('wall_strong_waterproof')
                                    ->label('Dinding bangunan kuat dan kedap air')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('wall_smooth_no_cracks')
                                    ->label('Permukaan rata, halus, tidak licin, dan tidak retak')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('wall_no_dust_easy_clean')
                                    ->label('Permukaan tidak menyerap debu dan mudah dibersihkan')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('wall_bright_color')
                                    ->label('Warna yang terang dan cerah')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('wall_clean_condition')
                                    ->label('Dinding dalam keadaan bersih')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(2),

                        // Ruangan untuk Tempat Tidur
                        Forms\Components\Section::make('Ruangan untuk Tempat Tidur')
                            ->schema([
                                Forms\Components\Radio::make('bedroom_clean_condition')
                                    ->label('Kondisi dalam keadaan bersih')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('bedroom_lighting')
                                    ->label('Pencahayaan yang diperlukan sesuai aktivitas dalam kamar (>60 LUX)')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('bedroom_area_minimum')
                                    ->label('Luas ruang tidur minimum 9 m²')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('ceiling_height_minimum')
                                    ->label('Tinggi langit-langit minimum 2,4 m')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(2),

                        // Ruangan Umum
                        Forms\Components\Section::make('Ruangan Umum')
                            ->schema([
                                Forms\Components\Radio::make('general_room_no_hazardous_materials')
                                    ->label('Tidak terdapat bahan yang mengandung bahan beracun, bahan mudah meledak, dan bahan lain yang berbahaya')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('general_room_safe_easily_cleaned')
                                    ->label('Bangunan kuat, aman, mudah dibersihkan, dan mudah pemeliharaannya')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(2),

                        // Lantai Rumah
                        Forms\Components\Section::make('Lantai Rumah')
                            ->schema([
                                Forms\Components\Radio::make('floor_waterproof')
                                    ->label('Lantai bangunan kedap air')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('floor_smooth_no_cracks')
                                    ->label('Permukaan rata, halus, tidak licin, dan tidak retak')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(2),
                    ])
                    ->columns(1),

                // Section: Sarana Sanitasi
                Forms\Components\Section::make('Sarana Sanitasi')
                    ->schema([
                        Forms\Components\Section::make('Ketersediaan Air')
                            ->schema([
                                Forms\Components\Radio::make('safe_drinking_water_source')
                                    ->label('Menggunakan sumber Air Minum yang layak')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('drinking_water_location')
                                    ->label('Lokasi sumber Air Minum berada di dalam sarana bangunan/on premises')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(1),

                        // Toilet/Sanitasi
                        Forms\Components\Section::make('Toilet/Sanitasi')
                            ->schema([
                                Forms\Components\Radio::make('toilet_usage')
                                    ->label('Buang Air Besar di Jamban')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('own_toilet')
                                    ->label('Jamban milik sendiri')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(1),

                        // Sarana CTPS
                        Forms\Components\Section::make('Sarana CTPS')
                            ->schema([
                                Forms\Components\Radio::make('ctps_facility')
                                    ->label('Memiliki sarana CTPS dengan air mengalir dilengkapi dengan sabun')
                                    ->options([true => 'Ya', false => 'Tidak']),

                                Forms\Components\Radio::make('ctps_accessibility')
                                    ->label('Lokasi sarana CTPS mudah dijangkau pada saat Waktu-waktu kritis CTPS')
                                    ->options([true => 'Ya', false => 'Tidak']),
                            ])
                            ->columns(1),
                    ])
                    ->columns(1),

                // Section: Perilaku
                Forms\Components\Section::make('Perilaku')
                    ->schema([
                        Forms\Components\Radio::make('bedroom_window_open')
                            ->label('Jendela kamar tidur selalu dibuka setiap hari')
                            ->options([true => 'Ya', false => 'Tidak']),

                        Forms\Components\Radio::make('living_room_window_open')
                            ->label('Jendela kamar keluarga selalu dibuka setiap hari')
                            ->options([true => 'Ya', false => 'Tidak']),
                    ])
                    ->columns(1),

                // Section: Hasil Sanitarian Kit
                Forms\Components\Section::make('Hasil Sanitarian Kit')
                    ->schema([
                        Forms\Components\Radio::make('noise_level')
                            ->label('Kebisingan (<85 dBA)')
                            ->options([true => 'Ya', false => 'Tidak']),

                        Forms\Components\Radio::make('humidity')
                            ->label('Kelembaban (40-60%RH)')
                            ->options([true => 'Ya', false => 'Tidak']),
                    ])
                    ->columns(1),

                // Section: Keterangan
                Forms\Components\Section::make('Keterangan')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->placeholder('Tambahkan catatan tambahan jika ada'),
                    ])
                    ->columns(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('sampling_date')
                    ->label('Tanggal Kunjungan')
                    ->date(),

                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('diagnosed_disease')
                    ->label('Penyakit yang Didiagnosis')
                    ->limit(50),

                Tables\Columns\TextColumn::make('head_of_family')
                    ->label('Nama Kepala Keluarga (KK)')
                    ->searchable()
                    ->sortable(),

                    Tables\Columns\TextColumn::make('drinking_water_source')
                    ->label('Sumber Air Minum')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'SUMUR' => 'Sumur',
                        'PDAM' => 'PDAM',
                        'AIR_HUJAN' => 'Air Hujan',
                        'MATA_AIR' => 'Mata Air',
                        'ISI_ULANG' => 'Isi Ulang',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('clean_water_source')
                    ->label('Sumber Air Bersih')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'SUMUR' => 'Sumur',
                        'PDAM' => 'PDAM',
                        'AIR_HUJAN' => 'Air Hujan',
                        'MATA_AIR' => 'Mata Air',
                        'ISI_ULANG' => 'Isi Ulang',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('last_education')
                    ->label('Pendidikan Terakhir Kepala Keluarga')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'tidak_sekolah' => 'Tidak Sekolah',
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'DIII' => 'DIII',
                        'DIV' => 'DIV',
                        'S1' => 'S1',
                        'S2' => 'S2',
                        'S3' => 'S3',
                        default => $state,
                    })
                    ->limit(20),

                Tables\Columns\TextColumn::make('job')
                    ->label('Pekerjaan Kepala Keluarga')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'PETANI' => 'Petani',
                        'PNS' => 'PNS',
                        'TNIPOLRI' => 'TNI/POLRI',
                        'PEDAGANG' => 'Pedagang',
                        'BURUH' => 'Buruh',
                        'WIRASWASTA' => 'Wiraswasta',
                        'SUPIR' => 'Supir',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('family_members')
                    ->label('Jumlah Jiwa dalam KK')
                    ->sortable(),

                Tables\Columns\TextColumn::make('house_ownership')
                    ->label('Status Kepemilikan Rumah')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'rumah_sendiri' => 'Rumah Sendiri',
                        'kontrak' => 'Rumah Kontrak',
                        default => $state,
                    }),


                Tables\Columns\TextColumn::make('house_area')
                    ->label('Luas Rumah (m²)')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
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
