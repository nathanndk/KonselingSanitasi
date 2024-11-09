<?php

namespace App\Filament\Resources\HealthEventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
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

class HouseConditionsRelationManager extends RelationManager
{
    protected static string $relationship = 'houseConditions';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()
                ->schema([
                    TextInput::make('description')
                        ->label('Deskripsi Kondisi')
                        ->placeholder('Masukkan deskripsi kondisi...')
                        ->required(),
                ])
                ->columnSpan('full')
                ->columns(1),

            Section::make('Detail Parameter')
                ->schema([
                    Repeater::make('parameters')
                        ->relationship('parameters')
                        ->label('Parameter')
                        ->schema([
                            Grid::make(1)
                                ->schema([
                                    Select::make('parameter_category_id')
                                        ->label('Kategori Parameter')
                                        ->relationship('categories', 'name')
                                        ->nullable()
                                        ->preload()
                                        ->searchable()
                                        ->live()
                                        ->createOptionForm([
                                            TextInput::make('name')
                                                ->label('Nama Kategori')
                                                ->required(),
                                        ])
                                        ->placeholder('Pilih kategori parameter...'),

                                    // Membuat Nama Parameter dan Nilai Parameter bersebelahan
                                    Grid::make(3)
                                        ->schema([
                                            TextInput::make('name')
                                                ->label('Nama Parameter')
                                                ->required()
                                                ->placeholder('Masukkan nama parameter...')
                                                ->columnSpan(2), // Lebih lebar untuk teks

                                            Radio::make('value')
                                                ->label('Nilai Parameter')
                                                ->options([
                                                    1 => 'Ya',
                                                    0 => 'Tidak',
                                                ])
                                                ->required()
                                                ->inline()
                                                ->columnSpan(1) // Lebih sempit untuk pilihan ganda
                                        ])
                                ]),
                        ])
                        ->minItems(1)
                        ->createItemButtonLabel('Tambah Parameter')
                        ->columns(1),
                ])
                ->columnSpan('full'),
        ])
        ->columns(1);
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
                    ->formatStateUsing(fn($state) => $state ? 'Ya' : 'Tidak')
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
