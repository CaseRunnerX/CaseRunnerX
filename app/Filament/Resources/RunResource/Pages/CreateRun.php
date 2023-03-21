<?php

namespace App\Filament\Resources\RunResource\Pages;

use App\Filament\Resources\RunResource;
use App\Models\Suites;
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
        $test_suites = $this->record->test_suite_id;

        foreach ($test_suites as $key => $value)
        {
            // get all the test case record
            $case = Suites::find($value)->testCases()->get();
            ddd($case);
        }
    }
}
