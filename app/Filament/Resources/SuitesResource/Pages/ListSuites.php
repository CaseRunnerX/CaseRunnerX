<?php

namespace App\Filament\Resources\SuitesResource\Pages;

use App\Filament\Resources\SuitesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuites extends ListRecords
{
    protected static string $resource = SuitesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
