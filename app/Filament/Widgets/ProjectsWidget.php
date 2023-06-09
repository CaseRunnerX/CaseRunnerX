<?php

namespace App\Filament\Widgets;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ProjectsWidget extends ApexChartWidget
{

    private ?int $Untested = 0, $Passed = 0, $Failed = 0, $Retest = 0, $Blocked = 0,$Skipped = 0, $tbd = 0, $ntc = 0;
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'projectsWidget';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Test Cases Analytics';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */

    protected static bool $deferLoading = true;

    public ?Model $record = null;

    protected function getOptions(): array
    {
        //showing a loading indicator immediately after the page load
        if (!$this->readyToLoad) {
            return [];
        }

        // Fetch test case run
        $projectData = Projects::find($this->record->id)->with('runs.runCases')->get();
        foreach ($projectData as $project)
        {
            foreach ($project->runs as $run)
            {
                foreach ($run->runCases as $runCase)
                {
                    switch ($runCase->status)
                    {
                        case "Untested":
                            $this->Untested++;
                            break;
                        case "Passed":
                            $this->Passed++;
                            break;
                        case "Failed":
                            $this->Failed++;
                            break;
                        case "Retest":
                            $this->Retest++;
                            break;
                        case "Blocked":
                            $this->Blocked++;
                            break;
                        case "Skipped":
                            $this->Skipped++;
                            break;
                        case "To Be Determined":
                            $this->tbd++;
                            break;
                        default:
                            $this->ntc++;
                            break;
                    }
                }
            }
        }

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [$this->Untested, $this->Passed, $this->Failed, $this->Retest, $this->Blocked, $this->Skipped, $this->tbd, $this->ntc],
            'labels' => ['Untested', 'Passed', 'Failed', 'Retest', 'Blocked', 'Skipped', 'To Be Determined', 'No Test Case'],
            'colors' => ['#FDE047', '#16A34A', '#DC2626', '#F472B6', '#52525B', '#CA8A04', '#7C3AED', '#64748B',],
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
        ];
    }
}
