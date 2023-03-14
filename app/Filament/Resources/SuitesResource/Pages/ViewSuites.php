<?php

namespace App\Filament\Resources\SuitesResource\Pages;

use App\Filament\Resources\SuitesResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSuites extends ViewRecord
{
    protected static string $resource = SuitesResource::class;

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
        return $data;
    }
}
