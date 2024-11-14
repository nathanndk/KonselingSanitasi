<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use App\Models\PdamCondition;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PdamConditionsRelationManager extends RelationManager
{
    protected static string $relationship = 'pdamConditions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data PDAM')
                    ->schema([
                        Grid::make(2)
                            ->schema(
                                PdamCondition::all()->map(function ($condition) {
                                    $cards = [];

                                    $cards[] = Card::make([
                                        Placeholder::make('condition_placeholder')
                                            ->label('Kondisi: ' . $condition->description)
                                            ->columnSpanFull(),

                                        Grid::make(1)
                                            ->schema(
                                                $condition->categories->map(function ($category) {
                                                    return Card::make([
                                                        Placeholder::make('category_placeholder')
                                                            ->label('Kategori: ' . $category->name)
                                                            ->columnSpanFull(),

                                                        Grid::make(2)
                                                            ->schema(
                                                                $category->parameters->map(function ($parameter) {
                                                                    return TextInput::make("value_{$parameter->id}")
                                                                        ->label($parameter->name)
                                                                        ->rules(['nullable', 'string'])
                                                                        ->default($parameter->value);
                                                                })->toArray()
                                                            )
                                                            ->columnSpanFull(),
                                                    ])->columnSpan(2);
                                                })->toArray()
                                            )
                                            ->columnSpanFull(),

                                        Grid::make(1)
                                            ->schema(
                                                $condition->parameters->filter(function ($parameter) {
                                                    return is_null($parameter->parameter_category_id);
                                                })->map(function ($parameter) {
                                                    return TextInput::make("value_{$parameter->id}")
                                                        ->label($parameter->name)
                                                        ->rules(['nullable', 'string'])
                                                        ->default($parameter->value);
                                                })->toArray()
                                            )
                                            ->columnSpanFull(),
                                    ])->columnSpan(2);

                                    return $cards;
                                })->flatten()->filter()->toArray()
                            ),
                    ])->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('description')
                    ->label('Deskripsi Kondisi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parameters.categories.name')
                    ->label('Kategori Parameter')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->sortable(),

                TextColumn::make('parameters.name')
                    ->label('Parameter')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->sortable(),

                TextColumn::make('parameters.value')
                    ->label('Nilai')
                    ->sortable(),

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
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
