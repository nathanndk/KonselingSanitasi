<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthEventResource\Pages;
use App\Filament\Resources\HealthEventResource\RelationManagers\CounselingReportsRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\HousingSurveyRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PdamRelationManager;
use App\Models\HealthEvent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class HealthEventResource extends Resource
{
    protected static ?string $model = HealthEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Acara Kesehatan';

    public static function getPluralLabel(): string
    {
        return 'Jadwal Acara Kesehatan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Jadwal Acara';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\Fieldset::make('Detail Acara Kesehatan')
                            ->schema([
                                Select::make('health_center_id')
                                    ->label('Puskesmas')
                                    ->relationship('healthCenter', 'name')
                                    ->helperText('Pilih puskesmas tempat acara akan berlangsung.')
                                    ->placeholder('Pilih puskesmas')
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull()
                                    ->required()
                                    ->hidden(fn() => !in_array(Auth::user()->role, ['admin', 'dinas_kesehatan'])),

                                    TextInput::make('title')
                                    ->label('Judul Acara')
                                    ->required()
                                    ->unique(
                                        table: 'health_events', // Nama tabel
                                        column: 'title',        // Kolom yang ingin divalidasi
                                        ignorable: fn ($record) => $record // Mengabaikan record saat ini
                                    )
                                    ->placeholder('Masukkan judul acara kesehatan')
                                    ->helperText('Judul acara harus unik dan maksimal 255 karakter.')
                                    ->columnSpanFull()
                                    ->maxLength(255)
                                    ->minLength(3)
                                    ->validationMessages([
                                        'required' => 'Judul acara wajib diisi.',
                                        'unique' => 'Judul acara sudah digunakan, masukkan judul yang berbeda.',
                                        'max' => 'Judul acara tidak boleh lebih dari 255 karakter.',
                                        'min' => 'Judul acara harus terdiri dari minimal 3 karakter.',
                                    ]),

                                Textarea::make('description')
                                    ->label('Deskripsi Acara')
                                    ->rows(3)
                                    ->placeholder('Masukkan deskripsi acara kesehatan')
                                    ->helperText('Berikan deskripsi singkat tentang acara kesehatan (maksimal 500 karakter).')
                                    ->columnSpanFull()
                                    ->maxLength(500)
                                    ->minLength(10)
                                    ->validationMessages([
                                        'required' => 'Deskripsi acara wajib diisi.',
                                        'max' => 'Deskripsi acara tidak boleh lebih dari 500 karakter.',
                                        'min' => 'Deskripsi acara harus terdiri dari minimal 10 karakter.',
                                    ]),

                                DatePicker::make('event_date')
                                    ->label('Tanggal Acara')
                                    ->required()
                                    ->minDate(today())
                                    ->placeholder('Pilih tanggal acara')
                                    ->helperText('Tanggal acara tidak boleh sebelum hari ini.')
                                    ->rule('date')
                                    ->validationMessages([
                                        'required' => 'Tanggal acara wajib diisi.',
                                        'date' => 'Tanggal acara tidak valid.',
                                        'after_or_equal' => 'Tanggal acara tidak bisa sebelum hari ini.',
                                    ])
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $set('start_time', $state . ' 00:00:00');
                                        }
                                    }),

                                DateTimePicker::make('start_time')
                                    ->label('Waktu Mulai')
                                    ->withoutSeconds()
                                    ->required()
                                    ->minDate(today())
                                    ->placeholder('Pilih waktu mulai acara')
                                    ->helperText('Waktu mulai harus berada dalam tanggal acara yang dipilih.')
                                    ->rule('date')
                                    ->reactive()
                                    ->afterOrEqual(fn($get) => $get('event_date') ? $get('event_date') . ' 00:00:00' : now())
                                    ->beforeOrEqual(fn($get) => $get('event_date') ? $get('event_date') . ' 23:59:59' : now())
                                    ->validationMessages([
                                        'required' => 'Waktu mulai wajib diisi.',
                                        'date' => 'Waktu mulai tidak valid.',
                                        'after_or_equal' => 'Waktu mulai tidak bisa sebelum tanggal acara.',
                                        'before_or_equal' => 'Waktu mulai tidak bisa lebih dari waktu acara.',
                                    ]),

                                DateTimePicker::make('end_time')
                                    ->label('Waktu Selesai')
                                    ->withoutSeconds()
                                    ->required()
                                    ->minDate(today())
                                    ->placeholder('Pilih waktu selesai acara')
                                    ->helperText('Waktu selesai harus setelah waktu mulai.')
                                    ->rule('date')
                                    ->afterOrEqual('start_time')
                                    ->reactive()
                                    ->validationMessages([
                                        'required' => 'Waktu selesai wajib diisi.',
                                        'date' => 'Waktu selesai tidak valid.',
                                        'after_or_equal' => 'Waktu selesai harus setelah waktu mulai.',
                                    ]),
                            ])
                            ->columns(3),
                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Acara')
                    ->searchable(),

                TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->date('d F Y')
                    ->sortable(),

                TextColumn::make('start_time')
                    ->label('Waktu Mulai')
                    ->time(),

                TextColumn::make('end_time')
                    ->label('Waktu Selesai')
                    ->time(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate Pada')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                // Jika admin atau dinas kesehatan, tidak ada pembatasan data
                if (in_array($user->role, ['admin', 'dinas_kesehatan'])) {
                    return $query;
                }

                // Jika puskesmas, petugas, atau kader, hanya melihat data terkait dengan health_center_id mereka
                if (in_array($user->role, ['puskesmas', 'petugas', 'kader'])) {
                    return $query->where(function ($q) use ($user) {
                        $q->where('health_center_id', $user->health_center_id); // Filter berdasarkan health_center_id
                    });
                }

                // Jika role lainnya, tidak boleh melihat data apa pun
                return $query->where('id', null);
            })



            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = Auth::id();
                        return $data;
                    })
                    ->label('Isi'),
                Tables\Actions\DeleteAction::make()
                ->modalHeading('Hapus Data Acara Kesehatan'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CounselingReportsRelationManager::class,
            HousingSurveyRelationManager::class,
            PdamRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHealthEvents::route('/'),
            'view' => Pages\ViewHealthEvent::route('/{record}'),
            'edit' => Pages\EditHealthEvent::route('/{record}/edit'),
        ];
    }
    protected function getTitle(): string
    {
        return 'Ubah Acara Kesehatan';
    }
}

