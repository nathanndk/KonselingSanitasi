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

                        // Field untuk RT dan RW
                        Forms\Components\TextInput::make('address.rt')
                            ->label('RT')
                            ->maxLength(3)  // Membatasi RT menjadi 3 digit
                            ->minLength(3)
                            ->placeholder('Masukkan RT (3 digit)')
                            ->helperText('Masukkan RT yang sesuai dengan alamat Anda.')
                            ->numeric()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('address.rw')
                            ->label('RW')
                            ->maxLength(3)  // Membatasi RW menjadi 3 digit
                            ->minLength(3)
                            ->placeholder('Masukkan RW (3 digit)')
                            ->helperText('Masukkan RW yang sesuai dengan alamat Anda.')
                            ->numeric()
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

                TextColumn::make('address.district_code')
                    ->label('Kecamatan')
                    ->searchable()
                    ->default('-'),

                TextColumn::make('address.subdistrict_code')
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
