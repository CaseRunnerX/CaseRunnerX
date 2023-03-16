<?php

namespace App\Filament\Resources\RunResource\Pages;

use App\Filament\Resources\RunResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRun extends ViewRecord
{
    protected static string $resource = RunResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make()
                ->visible(fn(): bool => isset($this->record->deleted_at) ?? false),
            Actions\RestoreAction::make()
                ->visible(fn(): bool => isset($this->record->deleted_at) ?? false),
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
