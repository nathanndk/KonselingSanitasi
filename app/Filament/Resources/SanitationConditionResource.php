<?php

namespace App\Filament\Resources;

use App\Filament\Exports\SanitationConditionExporter;
use App\Filament\Resources\SanitationConditionResource\Pages;
use App\Models\District;
use App\Models\SanitationCondition;
use App\Models\Subdistrict;
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
use Illuminate\Contracts\Database\Eloquent\Builder;

class SanitationConditionResource extends Resource
{
    protected static ?string $model = SanitationCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Laporan';

    public static function getPluralLabel(): string
    {
        return 'Formulir Konseling Sanitasi';
    }

    public static function getNavigationLabel(): string
    {
        return 'Konseling Sanitasi';
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informasi Konseling')
                    ->schema([
                        DatePicker::make('sampling_date')
                            ->label('Tanggal Pelaksanaan Konseling')
                            ->required()
                            ->default(now())
                            ->placeholder('Pilih tanggal konseling')
                            ->helperText('Pilih tanggal konseling dilaksanakan.')
                            ->columnSpanFull(),

                        Select::make('patient_id')
                            ->label('Nama Pasien')
                            ->searchable()
                            ->relationship('patient', 'name')
                            ->required()
                            ->preload()
                            ->placeholder('Pilih nama pasien')
                            ->helperText('Cari nama pasien dari daftar yang tersedia.')
                            ->createOptionForm([
                                Forms\Components\Fieldset::make('Informasi Personal')
                                    ->schema([
                                        TextInput::make('nik')
                                            ->label('NIK')
                                            ->required()
                                            ->maxLength(16)
                                            ->minLength(16)
                                            ->unique()
                                            ->placeholder('Masukkan NIK 16 digit')
                                            ->helperText('NIK adalah Nomor Induk Kependudukan yang terdapat di KTP.')
                                            ->columnSpanFull(),

                                        TextInput::make('name')
                                            ->label('Nama')
                                            ->required()
                                            ->unique()
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
                                            ->unique()
                                            ->placeholder('Masukkan nomor telepon aktif')
                                            ->helperText('Gunakan nomor telepon yang aktif dan dapat dihubungi.')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),

                                Forms\Components\Fieldset::make('Alamat')
                                    ->schema([
                                        Select::make('health_center_id')
                                            ->label('Puskesmas')
                                            ->relationship('healthCenter', 'name')
                                            ->helperText('Pilih tempat puskesmas anda terdaftar.')
                                            ->placeholder('Pilih puskesmas anda')
                                            ->searchable()
                                            ->preload()
                                            ->columnSpanFull(),

                                        Textarea::make('address.street')
                                            ->label('Jalan')
                                            ->placeholder('Masukkan nama jalan tempat anda tinggal saat ini')
                                            ->helperText('Cantumkan nama jalan sesuai alamat resmi.')
                                            ->columnSpanFull(),

                                        Select::make('address.district_code')
                                            ->label('Kecamatan')
                                            ->options(District::pluck('district_name', 'district_code'))
                                            ->searchable()
                                            ->reactive()
                                            ->helperText('Isi dengan kecamatan anda tinggal saat ini.')
                                            ->placeholder('Pilih kecamatan anda')
                                            ->afterStateUpdated(function ($set) {
                                                $set('address.subdistrict_code', null);
                                            })
                                            ->columnSpan(1),

                                        Select::make('address.subdistrict_code')
                                            ->label('Kelurahan')
                                            ->helperText('Isi dengan kelurahan anda tinggal saat ini.')
                                            ->placeholder('Pilih kelurahan anda')
                                            ->options(function (callable $get) {
                                                $districtCode = $get('address.district_code');
                                                return $districtCode
                                                    ? Subdistrict::where('district_code', $districtCode)->pluck('subdistrict_name', 'subdistrict_code')
                                                    : [];
                                            })
                                            ->searchable()
                                            ->columnSpan(1),
                                    ])
                                    ->columns(2)
                                    ->label('Detail Alamat'),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Fieldset::make('Detail Konseling')
                    ->schema([
                        Textarea::make('condition')
                            ->label('Kondisi/Masalah')
                            ->rows(5)
                            ->maxLength(255)
                            ->required()
                            ->placeholder('Jelaskan kondisi atau masalah pasien')
                            ->helperText('Deskripsikan kondisi pasien atau masalah yang dihadapi dengan jelas dan singkat.')
                            ->columnSpanFull(),

                        Textarea::make('recommendation')
                            ->label('Saran/Rekomendasi')
                            ->rows(5)
                            ->maxLength(500)
                            ->required()
                            ->placeholder('Masukkan saran atau rekomendasi yang diberikan')
                            ->helperText('Berikan saran atau rekomendasi untuk membantu menyelesaikan masalah pasien.')
                            ->columnSpanFull(),

                        Textarea::make('intervention')
                            ->label('Intervensi')
                            ->rows(5)
                            ->maxLength(500)
                            ->placeholder('Masukkan tindakan intervensi jika ada')
                            ->helperText('Tuliskan tindakan yang telah dilakukan untuk membantu pasien, jika ada.')
                            ->columnSpanFull()
                            ->required(),

                        Textarea::make('notes')
                            ->label('Keterangan')
                            ->rows(5)
                            ->nullable()
                            ->maxLength(500)
                            ->placeholder('Tambahkan keterangan tambahan jika diperlukan')
                            ->helperText('Opsional: Isi keterangan tambahan yang dianggap relevan dengan konseling.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                TextInput::make('created_by')
                    ->default(fn() => Auth::id())
                    ->hidden(),

                TextInput::make('updated_by')
                    ->default(fn() => Auth::id())
                    ->hidden(),
            ]);
    }





    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('sampling_date')
                    ->label('Tanggal Pelaksanaan')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('patient.name')
                    ->label('Nama Pasien')
                    ->searchable(),

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
                    ->label('Kondisi/Masalah')
                    ->limit(10)
                    ->tooltip(fn($record) => $record->condition),

                TextColumn::make('recommendation')
                    ->label('Saran/Rekomendasi')
                    ->limit(10)
                    ->tooltip(fn($record) => $record->recommendation),

                TextColumn::make('home_visit_date')
                    ->label('Tanggal Kunjungan Rumah')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('intervention')
                    ->label('Intervensi')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->limit(10)
                    ->tooltip(fn($record) => $record->intervention),

                TextColumn::make('notes')
                    ->label('Keterangan')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->limit(10)
                    ->tooltip(fn($record) => $record->notes),

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
                    return $query->where('created_by', $user->id);
                }

                // Default, jika role lain
                return $query->where('id', null); // Tidak menampilkan data apa pun
            })

            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Lihat Data Konseling Sanitasi'),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah Data Konseling Sanitasi'),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Hapus Data Konseling Sanitasi'),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(SanitationConditionExporter::class)
                    ->label('Cetak Formulir Konseling Sanitasi')
                    ->modalHeading('Ekspor Formulir Konseling Sanitasi')
                    ->modalButton('Ekspor')
                    ->columnMapping(false),
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
