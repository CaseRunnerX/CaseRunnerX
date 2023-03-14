<?php

namespace App\Filament\Resources\CasesResource\Pages;

use App\Filament\Resources\CasesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCases extends ListRecords
{
    protected static string $resource = CasesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
