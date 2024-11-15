<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HouseConditionValueResource\Pages;
use App\Filament\Resources\HouseConditionValueResource\RelationManagers;
use App\Models\HouseConditionValue;
use App\Models\HouseParameterValue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HouseConditionValueResource extends Resource
{
    protected static ?string $model = HouseParameterValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Salah';

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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListHouseConditionValues::route('/'),
            'create' => Pages\CreateHouseConditionValue::route('/create'),
            'edit' => Pages\EditHouseConditionValue::route('/{record}/edit'),
        ];
    }
}
