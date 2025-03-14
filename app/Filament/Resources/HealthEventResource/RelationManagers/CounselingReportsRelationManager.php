<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use App\Models\District;
use App\Models\Patient;
use App\Models\Subdistrict;
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
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CounselingReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'counselingReports';

    protected static ?string $title = 'Sanitasi Konseling';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informasi Konseling')
                    ->schema([
                        // DatePicker::make('counseling_date')
                        //     ->label('Tanggal Pelaksanaan Konseling')
                        //     ->required()
                        //     ->default(now())
                        //     ->placeholder('Pilih tanggal konseling')
                        //     ->helperText('Pilih tanggal konseling dilaksanakan.')
                        //     ->columnSpanFull(),

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
                            ->preload()
                            ->createOptionUsing(
                                fn($value): ?Patient =>
                                Patient::find($value) // Buat opsi berdasarkan ID Pasien
                            )
                            ->placeholder('Pilih nama pasien')
                            ->helperText('Cari pasien menggunakan NIK atau nama.')
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
                                            ->unique()
                                            ->numeric()
                                            ->placeholder('Masukkan nomor telepon aktif')
                                            ->helperText('Gunakan nomor telepon yang aktif dan dapat dihubungi.')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                // Logika penyimpanan data baru
                                $record = Patient::create($data);

                                // Mengembalikan primary key dari record yang baru dibuat
                                return $record->getKey();
                            })

                    ])
                    ->columnSpanFull(),

                Fieldset::make('Detail Konseling')
                    ->schema([
                        // DatePicker::make('home_visit_date')
                        //     ->label('Tanggal Kunjungan Rumah')
                        //     ->nullable()
                        //     ->placeholder('Pilih tanggal kunjungan rumah')
                        //     ->helperText('Isi tanggal kunjungan rumah jika pasien dikunjungi di tempat tinggalnya.')
                        //     ->columnSpanFull()
                        //     ->required(),

                        Textarea::make('condition')
                            ->label('Kondisi/Masalah')
                            ->rows(5)
                            ->maxLength(1000)
                            ->required()
                            ->placeholder('Jelaskan kondisi atau masalah pasien')
                            ->helperText('Deskripsikan kondisi pasien atau masalah yang dihadapi dengan jelas dan singkat.')
                            ->columnSpanFull(),

                        Textarea::make('recommendation')
                            ->label('Saran/Rekomendasi')
                            ->rows(5)
                            ->maxLength(1000)
                            ->required()
                            ->placeholder('Masukkan saran atau rekomendasi yang diberikan')
                            ->helperText('Berikan saran atau rekomendasi untuk membantu menyelesaikan masalah pasien.')
                            ->columnSpanFull(),

                        Textarea::make('intervention')
                            ->label('Intervensi')
                            ->rows(5)
                            ->maxLength(1000)
                            ->placeholder('Masukkan tindakan intervensi jika ada')
                            ->helperText('Tuliskan tindakan yang telah dilakukan untuk membantu pasien, jika ada.')
                            ->columnSpanFull()
                            ->required(),

                        Textarea::make('notes')
                            ->label('Keterangan')
                            ->rows(5)
                            ->nullable()
                            ->maxLength(1000)
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


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Formulir Konseling Sanitasi')
                    ->modalHeading('Buat Formulir Konseling Sanitasi')
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
            ->actions([
                Tables\Actions\ViewAction::make()
                ->modalHeading('Lihat Data Konseling Sanitasi'),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = Auth::id();
                        return $data;
                    })
                    ->modalHeading('Ubah Data Konseling Sanitasi'),
                Tables\Actions\DeleteAction::make()
                ->modalHeading('Hapus Data Konseling Sanitasi'),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ])
        ;
    }
}
