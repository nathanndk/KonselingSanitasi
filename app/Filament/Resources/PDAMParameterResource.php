<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PDAMParameterResource\Pages;
use App\Models\PDAMCondition;
use App\Models\PDAMParameter;
use App\Models\PDAMParameterCategory;
use App\Models\PDAMParameterValue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class PDAMParameterResource extends Resource
{
    protected static ?string $model = PDAMCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

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
                TextInput::make('description')
                    ->label('Deskripsi Kondisi')
                    ->required(),

                Repeater::make('parameters')
                    ->relationship('parameters') // This should match the relationship in PDAMCondition
                    ->label('Parameter')
                    ->schema([
                        Select::make('parameter_category_id')
                            ->label('Kategori Parameter')
                            ->relationship('category', 'name') // Matches the relationship in PDAMParameter model
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
                    ->createItemButtonLabel('Tambah Parameter')
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
            // Definisikan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPDAMParameters::route('/'),
            'create' => Pages\CreatePDAMParameter::route('/create'),
            'edit' => Pages\EditPDAMParameter::route('/{record}/edit'),
        ];
    }
}
