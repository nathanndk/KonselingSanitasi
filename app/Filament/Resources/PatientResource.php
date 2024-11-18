<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use App\Models\District;
use App\Models\Subdistrict;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getPluralLabel(): string
    {
        return 'Pasien';
    }

    public static function getNavigationLabel(): string
    {
        return 'Pasien';
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Fieldset untuk Informasi Personal
                Forms\Components\Fieldset::make('Informasi Personal')
                    ->schema([
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK')
                            ->required()
                            ->maxLength(16)
                            ->minLength(16)
                            ->placeholder('Masukkan NIK 16 digit')
                            ->helperText('NIK adalah Nomor Induk Kependudukan yang terdapat di KTP.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Masukkan nama lengkap Anda sesuai KTP')
                            ->helperText('Gunakan nama sesuai identitas resmi.')
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->rule('before_or_equal:today')
                            ->placeholder('Pilih tanggal lahir')
                            ->helperText('Masukkan tanggal lahir Anda.')
                            ->maxDate(now())
                            ->columnSpanFull(),

                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required()
                            ->placeholder('Pilih jenis kelamin')
                            ->helperText('Pilih salah satu sesuai jenis kelamin Anda.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor Telepon')
                            ->minLength(10)
                            ->maxLength(15)
                            ->placeholder('Masukkan nomor telepon aktif')
                            ->helperText('Gunakan nomor telepon yang aktif dan dapat dihubungi.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                // Fieldset untuk Informasi Alamat
                Forms\Components\Fieldset::make('Alamat')
                    ->schema([
                        Forms\Components\Select::make('health_center_id')
                            ->label('Puskesmas')
                            ->relationship('healthCenter', 'name')
                            ->helperText('Pilih tempat puskesmas anda terdaftar.')
                            ->placeholder('Pilih puskesmas anda')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('address.street')
                            ->label('Jalan')
                            ->placeholder('Masukkan nama jalan tempat anda tinggal saat ini')
                            ->helperText('Cantumkan nama jalan sesuai alamat resmi.')
                            ->columnSpanFull(),

                        // Bagian Kecamatan dan Kelurahan dalam 2 kolom
                        Forms\Components\Select::make('address.district_code')
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

                        Forms\Components\Select::make('address.subdistrict_code')
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

                // Fieldset untuk Informasi Kesehatan
                Forms\Components\Fieldset::make('Informasi Kesehatan (opsional)')
                    ->schema([
                        Forms\Components\TextInput::make('fasting_blood_sugar')
                            ->label('Gula Darah Puasa (mg/dL)')
                            ->numeric()
                            ->maxLength(5)
                            ->placeholder('Masukkan nilai dalam mg/dL')
                            ->helperText('Isi dengan hasil tes gula darah setelah puasa minimal 8 jam.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('postprandial_blood_sugar')
                            ->label('Gula Darah 2 jam PP (mg/dL)')
                            ->numeric()
                            ->maxLength(5)
                            ->placeholder('Masukkan nilai dalam mg/dL')
                            ->helperText('Isi dengan hasil tes gula darah 2 jam setelah makan.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('hba1c')
                            ->label('HbA1c (%)')
                            ->numeric()
                            ->maxLength(4)
                            ->placeholder('Masukkan nilai dalam persen')
                            ->helperText('Isi dengan nilai rata-rata gula darah dalam 2-3 bulan terakhir.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('blood_sugar')
                            ->label('Gula Darah')
                            ->numeric()
                            ->maxLength(5)
                            ->placeholder('Masukkan nilai dalam mg/dL')
                            ->helperText('Isi dengan hasil tes gula darah sewaktu tanpa persyaratan khusus.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('cholesterol')
                            ->label('Kolesterol (mg/dL)')
                            ->numeric()
                            ->maxLength(5)
                            ->placeholder('Masukkan nilai dalam mg/dL')
                            ->helperText('Isi dengan hasil tes kadar kolesterol total dalam darah.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('hdl')
                            ->label('Lemak Darah HDL (mg/dL)')
                            ->numeric()
                            ->maxLength(5)
                            ->placeholder('Masukkan nilai dalam mg/dL')
                            ->helperText('Isi dengan hasil tes kadar lemak darah jenis HDL (lemak baik).')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('ldl')
                            ->label('Lemak Darah LDL (mg/dL)')
                            ->numeric()
                            ->maxLength(5)
                            ->placeholder('Masukkan nilai dalam mg/dL')
                            ->helperText('Isi dengan hasil tes kadar lemak darah jenis LDL (lemak jahat).')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('triglycerides')
                            ->label('Trigliserida (mg/dL)')
                            ->numeric()
                            ->maxLength(5)
                            ->placeholder('Masukkan nilai dalam mg/dL')
                            ->helperText('Isi dengan hasil tes kadar trigliserida dalam darah.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }



    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')->label('NIK')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                TextColumn::make('name')->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                TextColumn::make('date_of_birth')
                    ->label('Tanggal Lahir')
                    ->date('d F Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),
                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(function ($state) {
                        return $state === 'L' ? 'Laki-laki' : ($state === 'P' ? 'Perempuan' : '-');
                    })
                    ->default('-'),
                TextColumn::make('phone_number')
                    ->label('Nomor Telepon')
                    ->searchable()
                    ->default('-'),
                TextColumn::make('address.street')
                    ->label('Alamat')
                    ->searchable()
                    ->default('-'),

                // Kolom tambahan untuk atribut kesehatan
                TextColumn::make('fasting_blood_sugar')
                    ->label('Gula Darah Puasa (mg/dL)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('postprandial_blood_sugar')
                    ->label('Gula Darah 2 jam PP (mg/dL)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('hba1c')
                    ->label('HbA1c (%)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('blood_sugar')
                    ->label('Gula Darah')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('cholesterol')
                    ->label('Kolesterol (mg/dL)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('hdl')
                    ->label('Lemak Darah HDL (mg/dL)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('ldl')
                    ->label('Lemak Darah LDL (mg/dL)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('triglycerides')
                    ->label('Trigliserida (mg/dL)')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),

                TextColumn::make('updated_at')
                    ->label('Tanggal Diupdate')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default('-'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            // 'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
