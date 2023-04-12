<?php

namespace App\Filament\Resources\ContractorResource\Pages;

use App\Filament\Resources\ContractorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContractors extends ManageRecords
{
    protected static string $resource = ContractorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
