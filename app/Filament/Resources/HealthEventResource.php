<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthEventResource\Pages;
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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HealthEventResource extends Resource
{
    protected static ?string $model = HealthEvent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Jadwal Acara Kesehatan';

    public static function getPluralLabel(): string
    {
        return 'Acara Kesehatan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Acara Kesehatan';
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
                                ->maxLength(255),

                            Textarea::make('description')
                                ->label('Deskripsi Acara')
                                ->rows(3)
                                ->columnSpanFull()
                                ->maxLength(500),

                            DatePicker::make('event_date')
                                ->label('Tanggal Acara')
                                ->required()
                                ->minDate(now())
                                ->rule('date')
                                ->columnSpanFull(),

                            DateTimePicker::make('start_time')
                                ->label('Waktu Mulai')
                                ->withoutSeconds()
                                ->required()
                                ->rule('date')
                                ->reactive()
                                ->afterOrEqual(fn ($get) => $get('event_date') ? $get('event_date') . ' 00:00:00' : now())
                                ->beforeOrEqual(fn ($get) => $get('event_date') ? $get('event_date') . ' 23:59:59' : now())
                                ->helperText('Waktu mulai harus pada tanggal acara yang dipilih'),

                            DateTimePicker::make('end_time')
                                ->label('Waktu Selesai')
                                ->withoutSeconds()
                                ->required()
                                ->rule('date')
                                ->afterOrEqual('start_time') // Validasi: Waktu selesai harus setelah waktu mulai
                                ->reactive()
                                ->helperText('Waktu selesai harus setelah waktu mulai, tidak harus pada hari yang sama'),
                        ])
                        ->columns(2),
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
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListHealthEvents::route('/'),
            'create' => Pages\CreateHealthEvent::route('/create'),
            'edit' => Pages\EditHealthEvent::route('/{record}/edit'),
        ];
    }
}

