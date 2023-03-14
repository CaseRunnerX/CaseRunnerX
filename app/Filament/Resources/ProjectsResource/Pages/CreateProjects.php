<?php

namespace App\Filament\Resources\ProjectsResource\Pages;

use App\Filament\Resources\ProjectsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProjects extends CreateRecord
{
    protected static string $resource = ProjectsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author'] = auth()->id();
        return $data;
    }
}
