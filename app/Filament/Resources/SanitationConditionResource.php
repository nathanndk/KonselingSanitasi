<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SanitationConditionResource\Pages;
use App\Models\SanitationCondition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class SanitationConditionResource extends Resource
{
    protected static ?string $model = SanitationCondition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Laporan';

    public static function getPluralLabel(): string
    {
        return 'Konseling Sanitasi';
    }

    public static function getNavigationLabel(): string
    {
        return 'Konseling Sanitasi';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('counseling_date')
                    ->label('Tanggal Pelaksanaan Konseling')
                    ->required()
                    ->default(now()),

                Select::make('patient_id')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->relationship('patient', 'name')
                    ->required()
                    ->preload(),


                TextInput::make('condition')
                    ->label('Kondisi/Masalah')
                    ->required(),

                TextInput::make('recommendation')
                    ->label('Saran/Rekomendasi')
                    ->required(),

                DatePicker::make('home_visit_date')
                    ->label('Tanggal Kunjungan Rumah')
                    ->nullable(),

                TextInput::make('intervention')
                    ->label('Intervensi')
                    ->nullable(),

                TextInput::make('notes')
                    ->label('Keterangan')
                    ->nullable(),

                TextInput::make('created_by')
                    ->label('Dibuat Oleh')
                    ->default(fn() => Auth::id()) // Use a function to set Auth::id()
                    ->disabled(),

                TextInput::make('updated_by')
                    ->label('Diperbarui Oleh')
                    ->default(fn() => Auth::id()) // Set default to Auth::id() on edit
                    ->disabled()
                    ->hiddenOn(['create']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('counseling_date')
                    ->label('Tanggal Pelaksanaan Konseling')
                    ->date()
                    ->sortable(),

                TextColumn::make('patient.name')
                    ->label('Nama Pasien')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('patient.address.street')
                    ->label('Jalan')
                    ->searchable(),

                TextColumn::make('patient.address.subdistrict')
                    ->label('Kelurahan')
                    ->searchable(),

                TextColumn::make('patient.address.district')
                    ->label('Kecamatan')
                    ->searchable(),

                TextColumn::make('condition')
                    ->label('Kondisi/Masalah'),

                TextColumn::make('recommendation')
                    ->label('Saran/Rekomendasi'),

                TextColumn::make('home_visit_date')
                    ->label('Tanggal Kunjungan Rumah')
                    ->date()
                    ->sortable(),

                TextColumn::make('intervention')
                    ->label('Intervensi'),

                TextColumn::make('notes')
                    ->label('Keterangan'),

                TextColumn::make('created_by')
                    ->label('Dibuat Oleh')
                    ->formatStateUsing(fn($state) => $state ? 'User ID ' . $state : null),

                TextColumn::make('updated_by')
                    ->label('Diperbarui Oleh')
                    ->formatStateUsing(fn($state) => $state ? 'User ID ' . $state : null),

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
            'index' => Pages\ListSanitationConditions::route('/'),
            'create' => Pages\CreateSanitationCondition::route('/create'),
            'edit' => Pages\EditSanitationCondition::route('/{record}/edit'),
        ];
    }
}
