<?php

namespace App\Filament\Resources\ProjectsResource\Pages;

use App\Filament\Resources\ProjectsResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjects extends ViewRecord
{
    protected static string $resource = ProjectsResource::class;

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
        $data['created_by'] = User::find($data['created_by'])->creator;
        $data['updated_by'] = User::find($data['updated_by'])->editor;
        $data['deleted_by'] = User::find($data['deleted_by'])->destroyer;

        return $data;
    }

}
