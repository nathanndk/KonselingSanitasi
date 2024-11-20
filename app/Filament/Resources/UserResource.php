<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengguna')
                    ->schema([
                        Grid::make(1)->schema([
                            TextInput::make('username')
                                ->required()
                                ->unique(ignorable: fn($record) => $record)
                                ->maxLength(255)
                                ->label('Username')
                                ->placeholder('Masukkan username Anda')
                                ->helperText('Gunakan nama yang mudah diingat dan sesuai dengan identitas Anda.')
                                ->validationMessages([
                                    'required' => 'Username wajib diisi.',
                                    'unique' => 'Username sudah digunakan. Harap pilih username lain.',
                                    'max' => 'Username tidak boleh lebih dari 255 karakter.',
                                ]),

                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->label('Nama')
                                ->placeholder('Masukkan nama lengkap Anda')
                                ->helperText('Masukkan nama sesuai KTP atau identitas resmi lainnya.')
                                ->validationMessages([
                                    'required' => 'Nama wajib diisi.',
                                    'max' => 'Nama tidak boleh lebih dari 255 karakter.',
                                ]),

                            TextInput::make('nik')
                                ->label('NIK')
                                ->minLength(16)
                                ->maxLength(16)
                                ->unique(ignorable: fn($record) => $record)
                                ->placeholder('Masukkan 16 digit NIK')
                                ->helperText('Nomor Induk Kependudukan harus valid, pastikan tidak ada kesalahan.')
                                ->unique(ignorable: fn($record) => $record)
                                ->validationMessages([
                                    'required' => 'NIK wajib diisi.',
                                    'unique' => 'NIK sudah terdaftar. Harap periksa kembali.',
                                    'max' => 'NIK harus terdiri dari 16 karakter.',
                                    'min' => 'NIK harus terdiri dari 16 karakter.',
                                ]),

                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->label('Email')
                                ->placeholder('Masukkan alamat email Anda')
                                ->helperText('Pastikan email ini aktif dan sering Anda gunakan.')
                                ->validationMessages([
                                    'required' => 'Email wajib diisi.',
                                    'email' => 'Format email tidak valid.',
                                    'unique' => 'Email sudah digunakan. Harap gunakan email lain.',
                                ]),

                            DatePicker::make('date_of_birth')
                                ->label('Tanggal Lahir')
                                ->required()
                                ->rule('before_or_equal:today')
                                ->placeholder('Pilih tanggal lahir')
                                ->helperText('Masukkan tanggal lahir Anda untuk keperluan verifikasi.')
                                ->validationMessages([
                                    'required' => 'Tanggal lahir wajib diisi.',
                                    'before_or_equal' => 'Tanggal lahir tidak boleh melebihi tanggal hari ini.',
                                ]),
                        ]),
                    ])->collapsible(),
                    Section::make('Keamanan')
                    ->schema([
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->default(fn ($record) => $record ? $record->original_password : null) // Gunakan field asli jika disimpan dalam plaintext
                            ->mutateDehydratedStateUsing(fn($state) => filled($state) ? Hash::make($state) : null) // Hash hanya jika ada input
                            ->dehydrated(fn($state) => filled($state)) // Simpan hanya jika ada input
                            ->required(fn(Page $livewire) => $livewire instanceof Pages\CreateUser) // Wajib hanya untuk halaman Create
                            ->maxLength(255)
                            ->label('Password')
                            ->placeholder('Masukkan password')
                            ->helperText('Kosongkan jika tidak ingin mengubah password saat mengedit.')
                            ->hint('Password saat ini hanya akan diganti jika Anda memasukkan yang baru.')
                            ->validationMessages([
                                'required' => 'Password wajib diisi pada halaman pembuatan pengguna.',
                                'max' => 'Password tidak boleh lebih dari 255 karakter.',
                            ]),
                    ])->collapsible(),


                Section::make('Informasi Tambahan')
                    ->schema([
                        Grid::make(1)->schema([
                            Select::make('health_center_id')
                                ->label('Puskesmas')
                                ->relationship('healthCenter', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih Puskesmas terkait')
                                ->helperText('Pilih Puskesmas tempat Pengguna bertugas.')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Puskesmas wajib dipilih.',
                                ]),

                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ])
                                ->required()
                                ->placeholder('Pilih jenis kelamin Anda')
                                ->helperText('Masukkan informasi jenis kelamin sesuai data Anda.')
                                ->validationMessages([
                                    'required' => 'Jenis kelamin wajib dipilih.',
                                ]),

                            Select::make('role')
                                ->label('Role')
                                ->options([
                                    'admin' => 'Admin',
                                    'kader' => 'Kader',
                                    'petugas' => 'Petugas',
                                    'puskesmas' => 'Puskesmas',
                                    'dinas_kesehatan' => 'Dinas Kesehatan',
                                ])
                                ->required()
                                ->placeholder('Pilih role pengguna')
                                ->helperText('Pilih peran sesuai tugas dan tanggung jawab Anda di sistem.')
                                ->validationMessages([
                                    'required' => 'Role wajib dipilih.',
                                ]),
                        ]),
                    ])->collapsible(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')
                    ->searchable()
                    ->label('Username'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),

                Tables\Columns\TextColumn::make('nik')
                    ->searchable()
                    ->label('NIK')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->label('Tanggal Lahir')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('healthCenter.name')
                    ->label('Puskesmas')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat Pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Diupdate Pada')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
