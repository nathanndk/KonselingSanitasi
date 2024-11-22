<?php

namespace App\Filament\Exports;

use App\Models\HousingSurvey;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class HousingSurveyExporter extends Exporter
{
    protected static ?string $model = HousingSurvey::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('sampling_date')
                ->label('Tanggal Kunjungan'),

            ExportColumn::make('patient.name')
                ->label('Nama Pasien'),

            ExportColumn::make('patient.nik')
                ->label('NIK Pasien'),

            ExportColumn::make('patient.date_of_birth')
                ->label('Tanggal Lahir Pasien'),

            ExportColumn::make('patient.gender')
                ->label('Jenis Kelamin Pasien'),

            ExportColumn::make('patient.phone_number')
                ->label('Nomor Telepon Pasien'),

            ExportColumn::make('diagnosed_disease')
                ->label('Penyakit yang Didiagnosis'),

            ExportColumn::make('head_of_family')
                ->label('Nama Kepala Keluarga'),

            ExportColumn::make('drinking_water_source')
                ->label('Sumber Air Minum'),

            ExportColumn::make('clean_water_source')
                ->label('Sumber Air Bersih'),

            ExportColumn::make('last_education')
                ->label('Pendidikan Terakhir Kepala Keluarga'),

            ExportColumn::make('job')
                ->label('Pekerjaan Kepala Keluarga'),

            ExportColumn::make('family_members')
                ->label('Jumlah Jiwa dalam KK'),

            ExportColumn::make('house_ownership')
                ->label('Status Kepemilikan Rumah'),

            ExportColumn::make('house_area')
                ->label('Luas Rumah (m²)'),

            ExportColumn::make('address.street')
                ->label('Jalan'),

            ExportColumn::make('address.district_code')
                ->label('Kode Kecamatan'),

            ExportColumn::make('address.subdistrict_code')
                ->label('Kode Kelurahan'),

            ExportColumn::make('address.rt')
                ->label('RT'),

            ExportColumn::make('address.rw')
                ->label('RW'),

            ExportColumn::make('landslide_prone')
                ->label('Lokasi Rawan Longsor'),

            ExportColumn::make('garbage_site_nearby')
                ->label('Lokasi Bekas Tempat Sampah'),

            ExportColumn::make('high_voltage_area')
                ->label('Lokasi Tegangan Tinggi'),

            ExportColumn::make('roof_strong_no_leak')
                ->label('Atap Kuat dan Tidak Bocor'),

            ExportColumn::make('roof_drainage')
                ->label('Drainase Atap Memadai'),

            ExportColumn::make('ceiling_strong_safe')
                ->label('Langit-langit Kuat dan Aman'),

            ExportColumn::make('ceiling_clean_no_dust')
                ->label('Langit-langit Bersih dan Tidak Berdebu'),

            ExportColumn::make('ceiling_flat_adequate_air')
                ->label('Langit-langit Rata dan Udara Cukup'),

            ExportColumn::make('ceiling_clean_condition')
                ->label('Kondisi Langit-langit Bersih'),

            ExportColumn::make('wall_strong_waterproof')
                ->label('Dinding Kuat dan Kedap Air'),

            ExportColumn::make('wall_smooth_no_cracks')
                ->label('Dinding Halus dan Tidak Retak'),

            ExportColumn::make('wall_no_dust_easy_clean')
                ->label('Dinding Tidak Berdebu dan Mudah Dibersihkan'),

            ExportColumn::make('wall_bright_color')
                ->label('Dinding dengan Warna Terang'),

            ExportColumn::make('wall_clean_condition')
                ->label('Kondisi Dinding Bersih'),

            ExportColumn::make('bedroom_clean_condition')
                ->label('Kebersihan Kamar Tidur'),

            ExportColumn::make('bedroom_lighting')
                ->label('Pencahayaan Kamar Tidur'),

            ExportColumn::make('bedroom_area_minimum')
                ->label('Luas Minimum Kamar Tidur'),

            ExportColumn::make('ceiling_height_minimum')
                ->label('Tinggi Minimum Langit-langit'),

            ExportColumn::make('general_room_no_hazardous_materials')
                ->label('Ruangan Tanpa Bahan Berbahaya'),

            ExportColumn::make('general_room_safe_easily_cleaned')
                ->label('Ruangan Aman dan Mudah Dibersihkan'),

            ExportColumn::make('floor_waterproof')
                ->label('Lantai Kedap Air'),

            ExportColumn::make('floor_smooth_no_cracks')
                ->label('Lantai Halus dan Tidak Retak'),

            ExportColumn::make('safe_drinking_water_source')
                ->label('Sumber Air Minum Aman'),

            ExportColumn::make('drinking_water_location')
                ->label('Lokasi Sumber Air Minum'),

            ExportColumn::make('toilet_usage')
                ->label('Penggunaan Jamban'),

            ExportColumn::make('own_toilet')
                ->label('Jamban Milik Sendiri'),

            ExportColumn::make('ctps_facility')
                ->label('Sarana CTPS dengan Sabun'),

            ExportColumn::make('ctps_accessibility')
                ->label('Aksesibilitas Sarana CTPS'),

            ExportColumn::make('bedroom_window_open')
                ->label('Jendela Kamar Dibuka Setiap Hari'),

            ExportColumn::make('living_room_window_open')
                ->label('Jendela Ruang Keluarga Dibuka Setiap Hari'),

            ExportColumn::make('noise_level')
                ->label('Kebisingan (<85 dBA)'),

            ExportColumn::make('humidity')
                ->label('Kelembaban (40-60% RH)'),

            ExportColumn::make('notes')
                ->label('Catatan'),

            ExportColumn::make('created_by')
                ->label('Dibuat Oleh'),

            ExportColumn::make('updated_by')
                ->label('Diperbarui Oleh'),

            ExportColumn::make('created_at')
                ->label('Tanggal Dibuat'),

            ExportColumn::make('updated_at')
                ->label('Tanggal Diperbarui'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data survei rumah telah selesai dengan '
            . number_format($export->successful_rows)
            . ' baris berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount)
                . ' baris gagal diekspor.';
        }

        return $body;
    }
}
