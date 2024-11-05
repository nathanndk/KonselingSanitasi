<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HealthCenterResource\Pages;
use App\Models\HealthCenter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Card;

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
                Card::make()->schema([
                    // Fieldset pertama untuk detail Puskesmas
                    Fieldset::make('Detail Puskesmas')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Puskesmas')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('phone_number')
                                ->label('Nomor Telepon')
                                ->maxLength(16),
                        ])
                        ->columns(2),

                    // Fieldset kedua untuk detail alamat
                    Fieldset::make('Alamat')
                        ->schema([
                            TextInput::make('address.street')
                                ->label('Jalan'),

                            TextInput::make('address.subdistrict')
                                ->label('Kelurahan'),

                            TextInput::make('address.district')
                                ->label('Kecamatan'),

                            TextInput::make('address.city')
                                ->label('Kota'),

                            TextInput::make('address.province')
                                ->label('Provinsi'),
                        ])
                        ->columns(2),
                ]),
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

                TextColumn::make('phone_number')
                    ->label('Nomor Telepon')
                    ->searchable(),

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
