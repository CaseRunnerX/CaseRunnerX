<?php

namespace App\Filament\Resources\RunResource\Pages;

use App\Filament\Resources\RunResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRun extends CreateRecord
{
    protected static string $resource = RunResource::class;

    protected function afterCreate(): void
    {
        $this->associateTestCaseRecord();
    }

    public function associateTestCaseRecord()
    {
        ddd($this->record);
    }
}
