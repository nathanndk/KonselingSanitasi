<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthEventResource\Pages;
use App\Filament\Resources\HealthEventResource\RelationManagers\CounselingReportsRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\HouseConditionsRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\HousingSurveyRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PatientRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PatientsRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PdamConditionsRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PdamParametersRelationManager;
use App\Filament\Resources\HealthEventResource\RelationManagers\PdamRelationManager;
use App\Models\HealthEvent;
use App\Models\Patient;
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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Filament\Tables\Filters\Filter;

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
            ->filters([
                Filter::make('id')
                    ->label('ID')
                    ->form([
                        TextInput::make('id')->label('ID'),
                    ]),

                Filter::make('title')
                    ->label('Judul Acara')
                    ->form([
                        TextInput::make('title')->label('Judul Acara'),
                    ]),

                Filter::make('description')
                    ->label('Deskripsi Acara')
                    ->form([
                        Textarea::make('description')->label('Deskripsi Acara'),
                    ]),

                Filter::make('event_date')
                    ->label('Tanggal Acara')
                    ->form([
                        DatePicker::make('event_date')->label('Tanggal Acara'),
                    ]),

                Filter::make('start_time')
                    ->label('Waktu Mulai')
                    ->form([
                        DateTimePicker::make('start_time')->label('Waktu Mulai'),
                    ]),

                Filter::make('end_time')
                    ->label('Waktu Selesai')
                    ->form([
                        DateTimePicker::make('end_time')->label('Waktu Selesai'),
                    ]),

                Filter::make('created_by')
                    ->label('Dibuat Oleh')
                    ->form([
                        TextInput::make('created_by')->label('Dibuat Oleh'),
                    ]),

                Filter::make('created_at')
                    ->label('Dibuat Pada')
                    ->form([
                        DateTimePicker::make('created_at')->label('Dibuat Pada'),
                    ]),

                Filter::make('updated_at')
                    ->label('Diupdate Pada')
                    ->form([
                        DateTimePicker::make('updated_at')->label('Diupdate Pada'),
                    ]),

                Filter::make('updated_by')
                    ->label('Diupdate Oleh')
                    ->form([
                        TextInput::make('updated_by')->label('Diupdate Oleh'),
                    ]),
            ])
            ->actions([
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
            // 'create' => Pages\CreateHealthEvent::route('/create'),
            'edit' => Pages\EditHealthEvent::route('/{record}/edit'),
        ];
    }
}

