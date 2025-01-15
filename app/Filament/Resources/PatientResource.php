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
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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
                            ->maxLength(16)
                            ->minLength(16)
                            ->numeric()
                            ->placeholder('Masukkan NIK 16 digit')
                            ->helperText('NIK adalah Nomor Induk Kependudukan yang terdapat di KTP.')
                            ->validationMessages([
                                'max' => 'NIK harus terdiri dari 16 digit.',
                                'min' => 'NIK harus terdiri dari 16 digit.',
                                'numeric' => 'NIK hanya boleh berisi angka.',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('Masukkan nama lengkap Anda sesuai KTP')
                            ->helperText('Gunakan nama sesuai identitas resmi.')
                            ->validationMessages([
                                'required' => 'Nama wajib diisi.',
                                'max' => 'Nama tidak boleh lebih dari 50 karakter.',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Tanggal Lahir')
                            ->required()
                            ->rule('before_or_equal:today')
                            ->placeholder('Pilih tanggal lahir')
                            ->helperText('Masukkan tanggal lahir Anda.')
                            ->minDate(now()->subYears(100))
                            ->maxDate(now())
                            ->validationMessages([
                                'required' => 'Tanggal lahir wajib diisi.',
                                'before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
                            ])
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
                            ->validationMessages([
                                'required' => 'Jenis kelamin wajib dipilih.',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Nomor Telepon')
                            ->minLength(10)
                            ->maxLength(15)
                            ->numeric()
                            // ->unique('patients', 'phone_number')
                            ->placeholder('Masukkan nomor telepon aktif')
                            ->helperText('Gunakan nomor telepon yang aktif dan dapat dihubungi.')
                            ->validationMessages([
                                'unique' => 'Nomor telepon sudah terdaftar.',
                                'min' => 'Nomor telepon harus minimal 10 digit.',
                                'max' => 'Nomor telepon tidak boleh lebih dari 15 digit.',
                                'numeric' => 'Nomor telepon hanya boleh berisi angka.',
                            ])
                            ->unique(
                                table: 'patients',
                                column: 'phone_number',
                                ignorable: fn($record) => $record // Mengabaikan record saat ini
                            )
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                // Fieldset untuk Informasi Alamat
                Forms\Components\Fieldset::make('Alamat')
                    ->schema([
                        Forms\Components\Textarea::make('address.street')
                            ->label('Jalan')
                            ->placeholder('Masukkan nama jalan tempat anda tinggal saat ini')
                            ->helperText('Cantumkan nama jalan sesuai alamat resmi.')
                            ->validationMessages([
                                'required' => 'Nama jalan wajib diisi.',
                            ])
                            ->columnSpanFull(),

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
                            ->validationMessages([
                                'required' => 'Kecamatan wajib dipilih.',
                            ])
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
                            ->validationMessages([
                                'required' => 'Kelurahan wajib dipilih.',
                            ])
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('address.rt')
                            ->label('RT')
                            ->maxLength(3)
                            ->minLength(3)
                            ->placeholder('Masukkan RT (3 digit)')
                            ->helperText('Masukkan RT yang sesuai dengan alamat Anda.')
                            ->numeric()
                            ->validationMessages([
                                'max' => 'RT harus terdiri dari 3 digit.',
                                'min' => 'RT harus terdiri dari 3 digit.',
                                'numeric' => 'RT hanya boleh berisi angka.',
                            ])
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('address.rw')
                            ->label('RW')
                            ->maxLength(3)
                            ->minLength(3)
                            ->placeholder('Masukkan RW (3 digit)')
                            ->helperText('Masukkan RW yang sesuai dengan alamat Anda.')
                            ->numeric()
                            ->validationMessages([
                                'max' => 'RW harus terdiri dari 3 digit.',
                                'min' => 'RW harus terdiri dari 3 digit.',
                                'numeric' => 'RW hanya boleh berisi angka.',
                            ])
                            ->columnSpan(1),
                    ])
                    ->columns(2)
                    ->label('Detail Alamat'),
            ]);
    }


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->sortable()
                    ->default('-'),

                TextColumn::make('name')
                    ->label('Nama')
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

                TextColumn::make('address.district.district_name')
                    ->label('Kecamatan')
                    ->searchable()
                    ->default('-'),

                TextColumn::make('address.subdistrict.subdistrict_name')
                    ->label('Kelurahan')
                    ->searchable()
                    ->default('-'),

                TextColumn::make('address.rt')
                    ->label('RT')
                    ->default('-'),

                TextColumn::make('address.rw')
                    ->label('RW')
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
                Tables\Actions\ViewAction::make()
                ->modalHeading('Lihat Data Pasien')
                ,
                Tables\Actions\EditAction::make()
                ->modalHeading('Ubah Data Pasien'),
                Tables\Actions\DeleteAction::make()
                ->modalHeading('Hapus Data Pasien'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->modalHeading('Hapus Data Pasien')
                ,
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
            // 'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
