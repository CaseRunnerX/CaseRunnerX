<?php

namespace App\Filament\Resources\ProjectsResource\Pages;

use Alfa6661\AutoNumber\AutoNumber;
use App\Filament\Resources\ProjectsResource;
use App\Models\Projects;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProjects extends CreateRecord
{
    protected static string $resource = ProjectsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author'] = auth()->id();
        $model = new Projects();
//        $data['project_name'] = $this->generateProjectName($data, $model);
        return $data;
    }
    public function generateProjectName(array $data, Model $model): string
    {
        return $data['application'].'-'.$data['account'].'-'.$data['project_type'].'-'.(new AutoNumber())->generate($model);

    }
}
