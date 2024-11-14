<?php

namespace App\Filament\Exports;

use App\Models\Pdam;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use App\Enums\TingkatResiko; // Import enum jika diperlukan

class PdamExporter extends Exporter
{
    protected static ?string $model = Pdam::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('sampling_date')
                ->label('Tanggal Sampling')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('patient.name')
                ->label('Nama Pasien')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('patient.nik')
                ->label('NIK')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('patient.date_of_birth')
                ->label('Tanggal Lahir')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('patient.gender')
                ->label('Jenis Kelamin')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('patient.phone_number')
                ->label('Nomor Telepon')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('risk_level')
                ->label('Tingkat Resiko')
                ->formatStateUsing(fn($state) => $state instanceof TingkatResiko ? $state->value : (string) $state),

            ExportColumn::make('remaining_chlorine')
                ->label('Sisa Chlor')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('ph')
                ->label('pH')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('tds_measurement')
                ->label('TDS Pengukuran')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('temperature_measurement')
                ->label('Suhu Pengukuran')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('total_coliform')
                ->label('Total Coliform')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('e_coli')
                ->label('E. Coli')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('tds_lab')
                ->label('TDS Lab')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('turbidity')
                ->label('Kekeruhan')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('color')
                ->label('Warna')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('odor')
                ->label('Bau')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('temperature_lab')
                ->label('Suhu Lab')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('aluminium')
                ->label('Aluminium')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('arsenic')
                ->label('Arsen')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('cadmium')
                ->label('Kadmium')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('remaining_chlorine_lab')
                ->label('Sisa Khlor')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('chromium_val_6')
                ->label('Crom Val 6')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('fluoride')
                ->label('Florida')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('iron')
                ->label('Besi')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('lead')
                ->label('Timbal')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('manganese')
                ->label('Mangan')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('nitrite')
                ->label('Nitrit')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('nitrate')
                ->label('Nitrat')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('ph_lab')
                ->label('pH Lab')
                ->formatStateUsing(fn($state) => (string) $state),

            ExportColumn::make('notes')
                ->label('Keterangan')
                ->formatStateUsing(fn($state) => (string) $state),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your PDAM export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
