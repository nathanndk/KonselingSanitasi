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
use Filament\Forms\Components\Repeater;
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


    public static function form(Form $form): Form
    {
        // Mengambil semua kategori parameter dan kondisi dari database
        $categories = PDAMParameterCategory::with(['parameters' => function ($query) {
            $query->whereNotNull('name'); // Hanya ambil parameter yang memiliki nama
        }])->get();
        $conditions = PDAMCondition::all();

        return $form
            ->schema([
                Card::make([
                    Grid::make(2) // Mengatur grid untuk tampilan dua kolom
                        ->schema(
                            $conditions->map(function ($condition) use ($categories) {
                                // Hanya tampilkan kondisi jika memiliki kategori dengan parameter
                                $filteredCategories = $categories->filter(function ($category) {
                                    return !$category->parameters->isEmpty(); // Hanya ambil kategori yang memiliki parameter
                                });

                                if ($filteredCategories->isEmpty()) {
                                    return null; // Abaikan kondisi yang tidak memiliki kategori dengan parameter
                                }

                                return Card::make([
                                    Placeholder::make('condition_placeholder')
                                        ->label('Kondisi: ' . $condition->description)
                                        ->columnSpanFull(), // Membuat nama kondisi tampil penuh

                                    Grid::make(1)
                                        ->schema(
                                            $filteredCategories->map(function ($category) use ($condition) {
                                                return Card::make([
                                                    Placeholder::make('category_placeholder')
                                                        ->label('Kategori: ' . $category->name)
                                                        ->columnSpanFull(),

                                                    // Menggunakan grid untuk parameter dalam kategori
                                                    Grid::make(2) // Mengatur dua kolom untuk parameter
                                                        ->schema(
                                                            $category->parameters->map(function ($parameter) {
                                                                return TextInput::make("parameter_values.{$parameter->id}")
                                                                    ->label($parameter->name)
                                                                    ->numeric()
                                                                    ->default(0)
                                                                    ->required();
                                                            })->toArray()
                                                        )
                                                        ->columnSpanFull(),
                                                ])->columnSpanFull(); // Membuat card kategori penuh dalam kondisi
                                            })->toArray()
                                        )
                                        ->columnSpanFull(), // Membuat grid kategori penuh dalam kondisi
                                ])->columnSpan(1); // Setiap card kondisi akan mengambil setengah layar
                            })->filter()->toArray() // Filter untuk mengabaikan kondisi kosong
                        ),
                ])->columnSpanFull() // Membuat card utama penuh di form
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('parameter_name')
                    ->label('Parameter')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('value')
                    ->label('Nilai')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
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
