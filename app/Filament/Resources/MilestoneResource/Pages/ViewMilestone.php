<?php

namespace App\Filament\Resources\MilestoneResource\Pages;

use App\Filament\Resources\MilestoneResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMilestone extends ViewRecord
{
    protected static string $resource = MilestoneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['created_by'] = $this->record->creator->name ?? null;
        $data['updated_by'] = $this->record->editor->name ?? null;
        $data['deleted_by'] = $this->record->destroyer->name ?? null;
        $data['assigned_qa'] =  User::find($data['assigned_qa'])->name;

        return $data;
    }
}
