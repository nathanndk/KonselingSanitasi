<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseConditionResource\Pages;
use App\Models\HouseCondition;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HouseConditionResource extends Resource
{
    protected static ?string $model = HouseCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getPluralLabel(): string
    {
        return 'Rumah Sehat Form';
    }

    public static function getNavigationLabel(): string
    {
        return 'Rumah Sehat Form';
    }

    public static function form(Form $form): Form
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



    public static function table(Table $table): Table
    {
        return $table
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
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListHouseConditions::route('/'),
            // 'create' => Pages\CreateHouseCondition::route('/create'),
            // 'edit' => Pages\EditHouseCondition::route('/{record}/edit'),
        ];
    }
}
