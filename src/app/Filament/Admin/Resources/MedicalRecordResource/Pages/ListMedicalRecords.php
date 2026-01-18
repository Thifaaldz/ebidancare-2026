<?php

namespace App\Filament\Admin\Resources\MedicalRecordResource\Pages;

use App\Filament\Admin\Resources\MedicalRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicalRecords extends ListRecords
{
    protected static string $resource = MedicalRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
