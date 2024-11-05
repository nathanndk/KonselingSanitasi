<?php

namespace App\Filament\Resources\PatientResource\Pages;

use App\Filament\Resources\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika Anda ingin memperbarui updated_by sebelum menyimpan
        $data['updated_by'] = Auth::id();
        return $data;
    }

    protected function afterSave(): void
    {
        // Tambahkan logika yang ingin dijalankan setelah menyimpan data, jika diperlukan
    }

    protected function getRedirectUrl(): string
    {
        // Redirect kembali ke halaman utama pasien setelah edit selesai
        return $this->getResource()::getUrl('index');
    }
}
