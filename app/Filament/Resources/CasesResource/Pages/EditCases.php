<?php

namespace App\Filament\Resources\CasesResource\Pages;

use App\Filament\Resources\CasesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCases extends EditRecord
{
    protected static string $resource = CasesResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
