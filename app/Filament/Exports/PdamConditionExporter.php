<?php

namespace App\Filament\Exports;

use App\Models\PDAMCondition;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PdamConditionExporter extends Exporter
{
    protected static ?string $model = PDAMCondition::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('sampling_date')
                ->label('Tanggal Sampling'),
            ExportColumn::make('number')
                ->label('No'),
            ExportColumn::make('customer_name')
                ->label('Nama Pelanggan'),
            ExportColumn::make('address')
                ->label('Alamat'),
            ExportColumn::make('subdistrict')
                ->label('Kelurahan'),
            ExportColumn::make('district')
                ->label('Kecamatan'),
            ExportColumn::make('risk_level')
                ->label('Tingkat Resiko (R/S/T/ST)'),
            ExportColumn::make('chlor_residual')
                ->label('Sisa Chlor'),
            ExportColumn::make('ph_level')
                ->label('pH'),
            ExportColumn::make('tds')
                ->label('TDS'),
            ExportColumn::make('residual_chlorine')
                ->label('Sisa Khlor'),
            ExportColumn::make('chrom_val6')
                ->label('Crom val 6'),
            ExportColumn::make('fluoride')
                ->label('Florida'),
            ExportColumn::make('iron')
                ->label('Besi'),
            ExportColumn::make('lead')
                ->label('Timbal'),
            ExportColumn::make('manganese')
                ->label('Mangan'),
            ExportColumn::make('nitrite')
                ->label('Nitrit'),
            ExportColumn::make('nitrate')
                ->label('Nitrat'),
            ExportColumn::make('ph')
                ->label('pH'),
            ExportColumn::make('remarks')
                ->label('Keterangan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor kondisi PDAM telah selesai, dengan ' . number_format($export->successful_rows) . ' baris berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diekspor.';
        }

        return $body;
    }
}
