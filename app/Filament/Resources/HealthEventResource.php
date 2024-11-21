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

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Acara Kesehatan';

    public static function getPluralLabel(): string
    {
        return 'Jadwal Acara';
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
                                    ->relationship('healthCenter', 'name')  // Ensure 'healthCenter' is the correct relationship method in your HealthEvent model
                                    ->helperText('Pilih tempat puskesmas anda terdaftar.')
                                    ->placeholder('Pilih puskesmas anda')
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull()
                                    ->hidden(fn() => Auth::user()->role !== 'admin'),

                                TextInput::make('title')
                                    ->label('Judul Acara')
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),

                                Textarea::make('description')
                                    ->label('Deskripsi Acara')
                                    ->rows(3)
                                    ->columnSpanFull()
                                    ->maxLength(500),

                                DatePicker::make('event_date')
                                    ->label('Tanggal Acara')
                                    ->required()
                                    ->minDate(today())
                                    ->rule('date'),

                                DateTimePicker::make('start_time')
                                    ->label('Waktu Mulai')
                                    ->withoutSeconds()
                                    ->required()
                                    ->rule('date')
                                    ->reactive()
                                    ->afterOrEqual(fn($get) => $get('event_date') ? $get('event_date') . ' 00:00:00' : now())
                                    ->beforeOrEqual(fn($get) => $get('event_date') ? $get('event_date') . ' 23:59:59' : now())
                                    ->helperText('Waktu mulai harus pada tanggal acara yang dipilih'),

                                DateTimePicker::make('end_time')
                                    ->label('Waktu Selesai')
                                    ->withoutSeconds()
                                    ->required()
                                    ->rule('date')
                                    ->afterOrEqual('start_time')
                                    ->reactive()
                                    ->helperText('Waktu selesai harus setelah waktu mulai, tidak harus pada hari yang sama'),
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
                    ->date(),

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

                // Jika petugas atau kader, hanya melihat data yang mereka buat dan sesuai dengan health_center_id mereka
                if (in_array($user->role, ['petugas', 'kader'])) {
                    return $query
                        // ->where('created_by', $user->id)  // Menampilkan hanya data yang dibuat oleh pengguna yang login
                        ->whereHas('user.healthCenter', function ($q) use ($user) {
                            $q->where('id', $user->health_center_id); // Memastikan data tersebut terkait dengan health_center_id pengguna
                        });
                }

                // Default, jika role lain
                return $query->where('id', null); // Tidak menampilkan data apa pun
            })


            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = Auth::id();
                        return $data;
                    })
                    ->label('Isi'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }



    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             TextEntry::make('title'),
    //             TextEntry::make('slug'),
    //             TextEntry::make('content'),
    //         ]);
    // }


    public static function getRelations(): array
    {
        return [
                // PatientRelationManager::class,
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
            // 'create' => Pages\CreateHealthEvent::route('/create'),
            'edit' => Pages\EditHealthEvent::route('/{record}/edit'),
        ];
    }
}

