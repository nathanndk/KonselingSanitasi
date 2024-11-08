<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PDAMValueResource\Pages;
use App\Models\PdamParameterValue;
use App\Models\PDAMParameterCategory;
use App\Models\PDAMCondition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;

class PDAMValueResource extends Resource
{
    protected static ?string $model = PdamParameterValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Laporan';

    public static function getPluralLabel(): string
    {
        return 'PDAM';
    }

    public static function getNavigationLabel(): string
    {
        return 'PDAM';
    }

    public static function form(Form $form): Form
    {
        $categories = PDAMParameterCategory::with([
            'parameters' => function ($query) {
                $query->whereNotNull('name');
            }
        ])->get();
        $conditions = PDAMCondition::all();

        return $form
            ->schema([
                Card::make([
                    Grid::make(2)
                        ->schema(
                            $conditions->map(function ($condition) use ($categories) {
                                $filteredCategories = $categories->filter(function ($category) {
                                    return !$category->parameters->isEmpty();
                                });

                                if ($filteredCategories->isEmpty()) {
                                    return null;
                                }

                                return Card::make([
                                    Placeholder::make('condition_placeholder')
                                        ->label('Kondisi: ' . $condition->description)
                                        ->columnSpanFull(),

                                    Grid::make(1)
                                        ->schema(
                                            $filteredCategories->map(function ($category) use ($condition) {
                                                return Card::make([
                                                    Placeholder::make('category_placeholder')
                                                        ->label('Kategori: ' . $category->name)
                                                        ->columnSpanFull(),

                                                    Grid::make(2)
                                                        ->schema(
                                                            $category->parameters->map(function ($parameter) use ($condition) {
                                                                return TextInput::make("value.{$condition->id}.{$parameter->id}")
                                                                    ->label($parameter->name)
                                                                    ->numeric()
                                                                    ->default(0)
                                                                    ->required();
                                                            })->toArray()
                                                        )
                                                        ->columnSpanFull(),
                                                ])->columnSpanFull();
                                            })->toArray()
                                        )
                                        ->columnSpanFull(),
                                ])->columnSpan(1);
                            })->filter()->toArray()
                        ),
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('conditions.description')
                    ->label('Deskripsi Kondisi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parameters.categories.name')
                    ->label('Kategori Parameter')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : (string) $state)
                    ->sortable(),

                TextColumn::make('parameters.name')
                    ->label('Parameter')
                    ->formatStateUsing(fn($state) => is_array($state) ? implode(', ', $state) : (string) $state)
                    ->sortable(),

                TextColumn::make('value')
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
                // Tambahkan filter jika diperlukan
            ])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPDAMValues::route('/'),
            'create' => Pages\CreatePDAMValue::route('/create'),
            'edit' => Pages\EditPDAMValue::route('/{record}/edit'),
        ];
    }
}
