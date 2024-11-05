<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseConditionResource\Pages;
use App\Filament\Resources\HouseConditionResource\RelationManagers;
use App\Models\HouseCondition;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HouseConditionResource extends Resource
{
    protected static ?string $model = HouseCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Laporan';

    public static function getPluralLabel(): string
    {
        return 'Rumah Sehat';
    }

    public static function getNavigationLabel(): string
    {
        return 'Rumah Sehat';
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->label('Deskripsi Kondisi')
                    ->required(),

                Repeater::make('parameters')
                    ->relationship('parameters')
                    ->label('Parameter')
                    ->schema([
                        Select::make('parameter_category_id')
                            ->label('Kategori Parameter')
                            ->relationship('category', 'name')
                            ->nullable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Kategori')
                                    ->required(),
                            ]),

                        TextInput::make('name')
                            ->label('Nama Parameter')
                            ->required(),

                        TextInput::make('value')
                            ->label('Nilai Parameter')
                            ->numeric()
                            ->nullable(),
                    ])
                    ->minItems(1)
                    ->createItemButtonLabel('Tambah Parameter'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Deskripsi Kondisi')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parameters.category.name')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHouseConditions::route('/'),
            'create' => Pages\CreateHouseCondition::route('/create'),
            'edit' => Pages\EditHouseCondition::route('/{record}/edit'),
        ];
    }
}
