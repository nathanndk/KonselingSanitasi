<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PDAMValueResource\Pages;
use App\Models\PdamParameter;
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
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class PDAMValueResource extends Resource
{
    protected static ?string $model = PdamParameter::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    // protected static ?string $navigationGroup = 'Laporan';

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
        return $form
            ->schema([
                Section::make('Data PDAM')
                    ->schema([
                        Grid::make(3)
                            ->schema(
                                PDAMCondition::all()->map(function ($condition) {
                                    return Card::make([
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

                                                        Grid::make(3)
                                                            ->schema(
                                                                $category->parameters->map(function ($parameter) {
                                                                    return TextInput::make("parameters.{$parameter->id}")
                                                                        ->label($parameter->name)
                                                                        ->rules(['nullable', 'string']);
                                                                })->toArray()
                                                            )
                                                            ->columnSpanFull(),
                                                    ])->columnSpan(3);
                                                })->toArray()
                                            )
                                            ->columnSpanFull(),

                                        Grid::make(1)
                                            ->schema(
                                                $condition->parameters->filter(function ($parameter) {
                                                    return is_null($parameter->parameter_category_id);
                                                })->map(function ($parameter) {
                                                    return TextInput::make("parameters.{$parameter->id}")
                                                        ->label($parameter->name)
                                                        ->rules(['nullable', 'string']);
                                                })->toArray()
                                            )
                                            ->columnSpanFull(),
                                    ])->columnSpan(3);
                                })->flatten()->filter()->toArray()
                            ),
                    ])->collapsible(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Menampilkan kolom deskripsi kondisi
                TextColumn::make('conditions.description')
                    ->label('Deskripsi Kondisi')
                    ->searchable()
                    ->sortable(),

                // Menampilkan kolom kategori parameter
                TextColumn::make('categories.name')
                    ->label('Kategori Parameter')
                    ->sortable(),

                // Menampilkan kolom nama parameter
                TextColumn::make('name')
                    ->label('Nama Parameter')
                    ->sortable(),

                // Menampilkan kolom nilai parameter
                TextColumn::make('value')
                    ->label('Nilai Parameter')
                    ->sortable(),

                // Menampilkan kolom tanggal pembuatan
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Menampilkan kolom tanggal update
                TextColumn::make('updated_at')
                    ->label('Diupdate Pada')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                // Aksi untuk melihat, mengedit, dan menghapus data
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Aksi bulk untuk menghapus data
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
            // Menyediakan rute untuk halaman index dan edit
            'index' => Pages\ListPDAMValues::route('/'),
            'edit' => Pages\EditPDAMValue::route('/{record}/edit'),
        ];
    }
}
