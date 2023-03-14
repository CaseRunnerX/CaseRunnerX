<?php

namespace App\Filament\Resources\MilestoneResource\Pages;

use App\Filament\Resources\MilestoneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMilestone extends CreateRecord
{
    protected static string $resource = MilestoneResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['assigned_qa'] = auth()->id();
        return $data;
    }
}
