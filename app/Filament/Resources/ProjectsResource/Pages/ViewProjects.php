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
        $data['created_by'] = $this->record->creator->name ?? null;
        $data['updated_by'] = $this->record->editor->name ?? null;
        $data['deleted_by'] = $this->record->destroyer->name ?? null;
        $data['author'] =  User::find($data['author_id'])->name;

        return $data;
    }

}
