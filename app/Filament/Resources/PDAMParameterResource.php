<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PdamConditionExporter;
use App\Filament\Resources\PDAMParameterResource\Pages;
use App\Models\PDAMCondition;
use App\Models\PDAMParameter;
use App\Models\PDAMParameterCategory;
use App\Models\PDAMParameterValue;
use Filament\Tables\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ExportBulkAction;
use Illuminate\Support\Facades\Auth;

class PDAMParameterResource extends Resource
{
    protected static ?string $model = PDAMCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getPluralLabel(): string
    {
        return 'PDAM Form';
    }

    public static function getNavigationLabel(): string
    {
        return 'PDAM Form';
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
                                Grid::make(2)
                                    ->schema([
                                        Select::make('parameter_category_id')
                                            ->label('Kategori Parameter')
                                            ->relationship('categories', 'name')
                                            ->nullable()
                                            ->preload()
                                            ->createOptionForm([
                                                TextInput::make('name')
                                                    ->label('Nama Kategori')
                                                    ->required(),
                                            ])
                                            ->placeholder('Pilih kategori parameter...'),

                                        TextInput::make('name')
                                            ->label('Nama Parameter')
                                            ->required()
                                            ->placeholder('Masukkan nama parameter...'),

                                        TextInput::make('value')
                                            ->label('Nilai Parameter')
                                            ->placeholder('Masukkan nilai parameter...'),
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
            ->headerActions([
                ExportAction::make()
                ->exporter(PdamConditionExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make()->exporter(PdamConditionExporter::class),
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
            'edit' => Pages\EditPDAMParameter::route('/{record}/edit'),
        ];
    }
}
