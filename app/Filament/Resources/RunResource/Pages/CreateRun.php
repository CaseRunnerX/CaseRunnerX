<?php

namespace App\Filament\Resources\RunResource\Pages;

use App\Filament\Resources\RunResource;
use App\Models\RunCase;
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
           foreach (Suites::find($value)->testCases()->get() as $case)
           {
               $runcase = new RunCase();
               $runcase->run_id = $this->record->id;
               $runcase->case_id = $case->id;
               $runcase->save();
           }

        }
    }
}
