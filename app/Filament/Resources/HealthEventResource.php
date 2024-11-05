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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Layout\FiltersLayout;
use Filament\Tables\Filters\Concerns\HasIndicators;
use Filament\Tables\Filters\Concerns\WithFilters;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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
                        TextInput::make('description')->label('Deskripsi Acara'),
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
                        DatePicker::make('created_from')->label('Dibuat Dari'),
                        DatePicker::make('created_until')->label('Dibuat Hingga'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if (!empty($data['created_from'])) {
                            $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }

                        if (!empty($data['created_until'])) {
                            $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),

                Filter::make('updated_at')
                    ->label('Diupdate Pada')
                    ->form([
                        DatePicker::make('updated_from')->label('Diupdate Dari'),
                        DatePicker::make('updated_until')->label('Diupdate Hingga'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['updated_from'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('updated_at', '>=', $date)
                            )
                            ->when(
                                $data['updated_until'] ?? null,
                                fn (Builder $query, $date) => $query->whereDate('updated_at', '<=', $date)
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if (!empty($data['updated_from'])) {
                            $indicators['updated_from'] = 'Updated from ' . Carbon::parse($data['updated_from'])->toFormattedDateString();
                        }

                        if (!empty($data['updated_until'])) {
                            $indicators['updated_until'] = 'Updated until ' . Carbon::parse($data['updated_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListHealthEvents::route('/'),
            'create' => Pages\CreateHealthEvent::route('/create'),
            'edit' => Pages\EditHealthEvent::route('/{record}/edit'),
        ];
    }
}

