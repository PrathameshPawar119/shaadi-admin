<?php

namespace App\ContractorPanel\Resources\Job\JobResource\Pages;

use App\ContractorPanel\Resources\Job\JobResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageJobs extends ManageRecords
{
    protected static string $resource = JobResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
