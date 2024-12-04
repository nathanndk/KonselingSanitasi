<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use App\Models\District;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
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
                Wizard::make([
                    // Step 1: Data Umum
                    Wizard\Step::make('Data Umum')
                        ->description('Masukkan informasi dasar')
                        ->icon('heroicon-o-document')
                        ->schema([
                            // Forms\Components\DatePicker::make('sampling_date')
                            //     ->label('Tanggal Kunjungan')
                            //     ->required()
                            //     ->placeholder('Pilih tanggal kunjungan')
                            //     ->helperText('Masukkan tanggal kunjungan rumah sesuai jadwal.'),

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

                            Forms\Components\TextInput::make('diagnosed_disease')
                                ->label('Dalam 1 bulan terakhir apakah ada anggota rumah tangga yang pernah di diagnosis menderita (Diare/DBD/Leptospirosis/Stunting/TBC/Ispa/Pneumonia/Scabies) ')
                                ->placeholder('Tulis nama penyakitnya jika ada')
                                ->maxLength(100)
                                ->helperText('Isi nama penyakit yang didiagnosis dokter jika ada.'),

                            Forms\Components\TextInput::make('head_of_family')
                                ->label('Nama Kepala Keluarga')
                                ->maxLength(50)
                                ->placeholder('Masukkan nama kepala keluarga')
                                ->helperText('Nama kepala keluarga sesuai dengan kartu keluarga.'),

                            Forms\Components\Select::make('drinking_water_source')
                                ->label('Sumber Air Minum')
                                ->options([
                                    'ISI_ULANG' => 'Isi Ulang',
                                    'AMDK' => 'Air Minum Dalam Kemasan',
                                    'SGL' => 'Sumur Gali',
                                    'ARTERTIS' => 'Air Tanah',
                                    'MATA_AIR' => 'Mata Air',
                                ])
                                ->placeholder('Pilih sumber air minum')
                                ->helperText('Pilih jenis sumber air minum yang digunakan.'),

                            Forms\Components\Select::make('clean_water_source')
                                ->label('Sumber Air Bersih')
                                ->options([
                                    'ISI_ULANG' => 'Isi Ulang',
                                    'AMDK' => 'Air Minum Dalam Kemasan',
                                    'SGL' => 'Sumur Gali',
                                    'ARTERTIS' => 'Air Tanah',
                                    'MATA_AIR' => 'Mata Air',
                                ])
                                ->placeholder('Pilih sumber air bersih')
                                ->helperText('Pilih jenis sumber air bersih yang digunakan.'),

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
                                    'S3' => 'S3',
                                ])
                                ->helperText('Pilih tingkat pendidikan terakhir kepala keluarga.'),

                            Forms\Components\TextInput::make('job')
                                ->label('Pekerjaan Kepala Keluarga')
                                ->placeholder('Masukkan pekerjaan kepala keluarga')
                                ->helperText('Sebutkan jenis pekerjaan kepala keluarga.'),

                            Forms\Components\TextInput::make('family_members')
                                ->label('Jumlah Jiwa dalam KK')
                                ->numeric()
                                ->placeholder('Masukkan jumlah jiwa dalam satu KK')
                                ->helperText('Isi dengan jumlah total anggota keluarga.'),

                            Forms\Components\Select::make('house_ownership')
                                ->label('Status Kepemilikan Rumah')
                                ->options([
                                    'rumah_sendiri' => 'Rumah Sendiri',
                                    'kontrak' => 'Rumah Kontrak',
                                    'orang_tua' => 'Rumah Orang Tua',
                                ])
                                ->placeholder('Pilih status kepemilikan rumah')
                                ->helperText('Pilih apakah rumah dimiliki sendiri atau sewa.'),

                            Forms\Components\TextInput::make('house_area')
                                ->label('Luas Rumah (m²)')
                                ->numeric()
                                ->placeholder('Masukkan luas rumah dalam meter persegi')
                                ->helperText('Isi luas total rumah dalam meter persegi.'),
                        ]),

                    // Step 2: Rumah Layak
                    Wizard\Step::make('Rumah Layak')
                        ->description('Masukkan informasi rumah layak')
                        ->icon('heroicon-o-home-modern')
                        ->schema([
                            // Lokasi Rumah
                            Forms\Components\Section::make('Lokasi Rumah')
                                ->schema([
                                    Forms\Components\Radio::make('landslide_prone')
                                        ->label('1. Tidak berada di lokasi rawan longsor')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('garbage_site_nearby')
                                        ->label('2. Tidak berada di lokasi bekas tempat pembuangan sampah akhir')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('high_voltage_area')
                                        ->label('3. Lokasi tidak berada pada jalur tegangan tinggi')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Atap Rumah
                            Forms\Components\Section::make('Atap Rumah')
                                ->schema([
                                    Forms\Components\Radio::make('roof_strong_no_leak')
                                        ->label('4. Bangunan kuat, tidak bocor, dan tidak menjadi tempat perindukan tikus')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('roof_drainage')
                                        ->label('5. Memiliki drainase atap yang memadai untuk limpasan air hujan')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Langit-langit Rumah
                            Forms\Components\Section::make('Langit-langit Rumah')
                                ->schema([
                                    Forms\Components\Radio::make('ceiling_strong_safe')
                                        ->label('6. Bangunan kuat dan aman')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('ceiling_clean_no_dust')
                                        ->label('7. Mudah dibersihkan dan tidak menyerap debu')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('ceiling_flat_adequate_air')
                                        ->label('8. Permukaan rata dan mempunyai ketinggian yang memungkinkan adanya pertukaran udara yang cukup')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('ceiling_clean_condition')
                                        ->label('9. Kondisi dalam keadaan bersih')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Dinding Rumah
                            Forms\Components\Section::make('Dinding Rumah')
                                ->schema([
                                    Forms\Components\Radio::make('wall_strong_waterproof')
                                        ->label('10. Dinding bangunan kuat dan kedap air')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('wall_smooth_no_cracks')
                                        ->label('11. Permukaan rata, halus, tidak licin, dan tidak retak')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('wall_no_dust_easy_clean')
                                        ->label('12. Permukaan tidak menyerap debu dan mudah dibersihkan')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('wall_bright_color')
                                        ->label('13. Warna yang terang dan cerah')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('wall_clean_condition')
                                        ->label('14. Dinding dalam keadaan bersih')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Ruangan untuk Tempat Tidur
                            Forms\Components\Section::make('Ruangan untuk Tempat Tidur')
                                ->schema([
                                    Forms\Components\Radio::make('bedroom_clean_condition')
                                        ->label('15. Kondisi dalam keadaan bersih')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('bedroom_lighting')
                                        ->label('16. Pencahayaan yang diperlukan sesuai aktivitas dalam kamar (>60 LUX)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('bedroom_area_minimum')
                                        ->label('17. Luas ruang tidur minimum 9 m²')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('ceiling_height_minimum')
                                        ->label('18. Tinggi langit-langit minimum 2,4 m²')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Ruangan Umum
                            Forms\Components\Section::make('Ruangan Umum')
                                ->schema([
                                    Forms\Components\Radio::make('general_room_no_hazardous_materials')
                                        ->label('19. Tidak terdapat bahan yang mengandung bahan beracun, bahan mudah meledak, dan bahan lain yang berbahaya')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('general_room_safe_easily_cleaned')
                                        ->label('20. Bangunan kuat, aman, mudah dibersihkan, dan mudah pemeliharaannya')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Lantai Rumah
                            Forms\Components\Section::make('Lantai Rumah')
                                ->schema([
                                    Forms\Components\Radio::make('floor_waterproof')
                                        ->label('1. Lantai bangunan kedap air')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('floor_smooth_no_cracks')
                                        ->label('2. Permukaan rata, halus, tidak licin, dan tidak retak')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('floor_dust_resistant')
                                        ->label('3. Lantai tidak menyerap debu dan mudah dibersihkan')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('floor_sloped_for_cleaning')
                                        ->label('4. Lantai yang kontak dengan air dan memiliki kemiringan cukup landai untuk memudahkan pembersihan dan tidak terjadi genangan air')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('floor_clean')
                                        ->label('5. Lantai rumah dalam keadaan bersih')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('floor_light_color')
                                        ->label('6. Warna lantai harus berwarna terang')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Ventilasi Rumah
                            Forms\Components\Section::make('Ventilasi Rumah')
                                ->schema([
                                    Forms\Components\Radio::make('ventilation_present')
                                        ->label('1. Ada ventilasi rumah')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('ventilation_area')
                                        ->label('2. Luas ventilasi permanen > 10% luas lantai')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Pencahayaan Rumah
                            Forms\Components\Section::make('Pencahayaan Rumah')
                                ->schema([
                                    Forms\Components\Radio::make('lighting_present')
                                        ->label('1. Ada pencahayaan rumah')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('lighting_brightness')
                                        ->label('2. Terang, tidak silau sehingga dapat untuk baca dengan normal')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ])

                        ]),

                    Wizard\Step::make('Sarana Sanitasi')
                        ->description('Masukkan informasi sarana sanitasi')
                        ->icon('heroicon-o-shield-exclamation')
                        ->schema([
                            // Ketersediaan Air
                            Forms\Components\Section::make('Ketersediaan Air')
                                ->schema([
                                    Forms\Components\Radio::make('safe_drinking_water_source')
                                        ->label('1. Menggunakan sumber Air Minum yang layak')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('drinking_water_location')
                                        ->label('2. Lokasi sumber Air Minum berada di dalam sarana bangunan/on premises')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('water_supply_hrs')
                                        ->label('3. Tidak mengalami kesulitan pasokan air selama 24 jam')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('water_quality')
                                        ->label('4. Kualitas air memenuhi SBMKL dan Persyaratan Kesehatan air sesuai ketentuan yang berlaku')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Toilet/Sanitasi
                            Forms\Components\Section::make('Toilet/Sanitasi')
                                ->schema([
                                    Forms\Components\Radio::make('toilet_usage')
                                        ->label('5. Buang Air Besar di Jamban')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('own_toilet')
                                        ->label('6. Jamban milik sendiri')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('squat_toilet')
                                        ->label('7. Kloset Leher Angsa')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('septic_tank')
                                        ->label('8. Tangki septik disedot setidaknya sekali dalam 3-5 tahun terakhir atau disalurkan ke Sistem Pengolahan Air Limbah Domestik Terpusat (SPAL-DT)')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Sarana CTPS
                            Forms\Components\Section::make('Sarana CTPS')
                                ->schema([
                                    Forms\Components\Radio::make('ctps_facility')
                                        ->label('10. Memiliki sarana CTPS dengan air mengalir dilengkapi dengan sabun')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('ctps_accessibility')
                                        ->label('11. Lokasi sarana CTPS mudah dijangkau pada saat Waktu-waktu kritis CTPS')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Tempat Pengelolaan Sampah Rumah Tangga
                            Forms\Components\Section::make('Tempat Pengelolaan Sampah Rumah Tangga')
                                ->schema([
                                    Forms\Components\Radio::make('trash_bin_available')
                                        ->label('12. Tersedia tempat sampah di ruangan, kuat dan mudah dibersihkan')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('trash_disposal')
                                        ->label('13. Ada perlakuan yang aman (tidak dibakar, tidak dibuang ke sungai/kebun/ saluran drainase/ tempat terbuka)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('trash_segregation')
                                        ->label('14. Telah melakukan pemilahan sampah')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Tempat Pengelolaan Limbah Cair Rumah Tangga
                            Forms\Components\Section::make('Tempat Pengelolaan Limbah Cair Rumah Tangga')
                                ->schema([
                                    Forms\Components\Radio::make('no_water_puddles')
                                        ->label('15. Tidak terlihat genangan air di sekitar rumah karena limbah cair domestik')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('connection_to_sewerage')
                                        ->label('16. Terhubung dengan sumur resapan dan atau sistem pengolahan limbah (IPAL Komunal/ sewerage system)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('closed_waste_management')
                                        ->label('17. Tersedia tempat pengelolaan limbah cair dengan kondisi tertutup')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Kandang Ternak
                            Forms\Components\Section::make('Kandang Ternak')
                                ->schema([
                                    Forms\Components\Radio::make('separated_cattle_shed')
                                        ->label('18. Bila memiliki kandang ternak, kandang terpisah dengan rumah tinggal')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),
                        ]),

                    // Step 4: Perilaku
                    Wizard\Step::make('Perilaku')
                        ->description('Masukkan informasi perilaku terkait kesehatan lingkungan')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Forms\Components\Radio::make('bedroom_window_open')
                                ->label('1. Jendela kamar tidur selalu dibuka setiap hari')
                                ->options([true => 'Ya', false => 'Tidak']),

                            Forms\Components\Radio::make('living_room_window_open')
                                ->label('2. Jendela kamar keluarga selalu dibuka setiap hari')
                                ->options([true => 'Ya', false => 'Tidak']),

                            Forms\Components\Radio::make('ventilation_open')
                                ->label('3. Ventilasi rumah selalu dibuka setiap hari')
                                ->options([true => 'Ya', false => 'Tidak']),

                            Forms\Components\Radio::make('ctps_practice')
                                ->label('4. Melakukan Cuci Tangan Pakai Sabun (CTPS)')
                                ->options([true => 'Ya', false => 'Tidak']),

                            Forms\Components\Radio::make('psn_practice')
                                ->label('5. Melakukan Pemberantasan Sarang Nyamuk (PSN) seminggu sekali')
                                ->options([true => 'Ya', false => 'Tidak']),
                        ]),

                    // Step 5: Hasil Sanitarian Kit
                    Wizard\Step::make('Hasil Sanitarian Kit')
                        ->description('Masukkan informasi hasil sanitarian kit')
                        ->icon('heroicon-o-shield-check')
                        ->schema([
                            // Parameter Ruang
                            Forms\Components\Section::make('Parameter Ruang')
                                ->schema([
                                    Forms\Components\Radio::make('room_noise_level')
                                        ->label('1. Kebisingan (<85 dBA)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('room_humidity')
                                        ->label('2. Kelembaban (40-60%RH)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('room_brightness')
                                        ->label('3. Pencahayaan (>60 LUX)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('room_air_ventilation')
                                        ->label('4. Laju ventilasi udara (0,15-0,25 m/s)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('room_temperature')
                                        ->label('5. Suhu ruang (18 - 30°C)')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),

                            // Parameter Air
                            Forms\Components\Section::make('Parameter Air')
                                ->schema([
                                    Forms\Components\Radio::make('water_ph')
                                        ->label('1. pH (6,5-8,5)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('water_temperature')
                                        ->label('2. Suhu (Suhu udara ± 3°C)')
                                        ->options([true => 'Ya', false => 'Tidak']),

                                    Forms\Components\Radio::make('water_tds')
                                        ->label('3. TDS (<300 mg/l)')
                                        ->options([true => 'Ya', false => 'Tidak']),
                                ]),
                        ]),


                    //Keterangan
                    Wizard\Step::make('Keterangan')
                        ->description('Tambahkan catatan tambahan')
                        ->icon('heroicon-o-clipboard')
                        ->schema([
                            Forms\Components\Textarea::make('notes')
                                ->label('Catatan')
                                ->rows(5)
                                ->maxLength(500)
                                ->placeholder('Tambahkan catatan tambahan jika ada'),
                        ]),
                ])->columnSpanFull(),
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
                    ->label('Buat Formulir Rumah Sehat')
                    ->modalHeading('Buat Formulir Rumah Sehat')
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
