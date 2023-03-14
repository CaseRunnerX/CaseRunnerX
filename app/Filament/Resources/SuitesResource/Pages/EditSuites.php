<?php

namespace App\Filament\Resources\SuitesResource\Pages;

use App\Filament\Resources\SuitesResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuites extends EditRecord
{
    protected static string $resource = SuitesResource::class;

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
