<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthCenterResource\Pages;
use App\Models\HealthCenter;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Illuminate\Support\Facades\Auth;

class HealthCenterResource extends Resource
{
    protected static ?string $model = HealthCenter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    public static function getPluralLabel(): string
    {
        return 'Puskesmas';
    }

    public static function getNavigationLabel(): string
    {
        return 'Puskesmas';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Puskesmas')
                            ->required()
                            ->maxLength(255),

                        // Nested Form for Address
                        Fieldset::make('Alamat')
                            ->schema([
                                TextInput::make('address.street')
                                    ->label('Jalan')
                                    ->required(),

                                TextInput::make('address.subdistrict')
                                    ->label('Kelurahan')
                                    ->required(),

                                TextInput::make('address.district')
                                    ->label('Kecamatan')
                                    ->required(),

                                TextInput::make('address.city')
                                    ->label('Kota')
                                    ->required(),

                                TextInput::make('address.province')
                                    ->label('Provinsi')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->label('Detail Alamat'),
                    ])
                    ->columns(2)
                    ->label('Detail Puskesmas'),
                            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Puskesmas')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('address.street')
                    ->label('Alamat')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Tanggal Diupdate')
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
            'index' => Pages\ListHealthCenters::route('/'),
            'create' => Pages\CreateHealthCenter::route('/create'),
            'edit' => Pages\EditHealthCenter::route('/{record}/edit'),
        ];
    }
}
