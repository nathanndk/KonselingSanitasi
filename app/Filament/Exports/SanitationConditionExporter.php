<?php

namespace App\Filament\Exports;

use App\Models\SanitationCondition;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SanitationConditionExporter extends Exporter
{
    protected static ?string $model = SanitationCondition::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('counseling_date')->label('Tanggal Pelaksanaan Konseling'),
            ExportColumn::make('patient.name')->label('Nama Pasien'),
            ExportColumn::make('patient.address.street')->label('Jalan'),
            ExportColumn::make('patient.address.subdistrict')->label('Kelurahan'),
            ExportColumn::make('patient.address.district')->label('Kecamatan'),
            ExportColumn::make('condition')->label('Kondisi/Masalah'),
            ExportColumn::make('recommendation')->label('Saran/Rekomendasi'),
            ExportColumn::make('home_visit_date')->label('Tanggal Kunjungan Rumah'),
            ExportColumn::make('intervention')->label('Intervensi'),
            ExportColumn::make('notes')->label('Keterangan'),
            ExportColumn::make('created_by')->label('Dibuat Oleh')->formatStateUsing(fn($state) => 'User ID ' . $state),
            ExportColumn::make('updated_by')->label('Diperbarui Oleh')->formatStateUsing(fn($state) => 'User ID ' . $state),
            ExportColumn::make('created_at')->label('Dibuat Pada'),
            ExportColumn::make('updated_at')->label('Diupdate Pada'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your sanitation condition export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
