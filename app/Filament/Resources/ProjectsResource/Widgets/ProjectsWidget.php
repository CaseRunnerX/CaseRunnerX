<?php

namespace App\Filament\Resources\ProjectsResource\Widgets;

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

    protected static ?string $pollingInterval = null;

    protected function getOptions(): array
    {
        //showing a loading indicator immediately after the page load
        if (!$this->readyToLoad) {
            return [];
        }

        // Fetch test case run
//        ddd($this->record->id);
        $projectData = Projects::whereId($this->record->id)->with('runs.runCases')->get();
//        ddd($projectData);
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
            'series' => [$this->Untested, $this->Passed, $this->Failed, $this->Retest, $this->Blocked, $this->Skipped, $this->tbd],
            'labels' => ['Untested', 'Passed', 'Failed', 'Retest', 'Blocked', 'Skipped', 'To Be Determined'],
            'colors' => ['#FDE047', '#16A34A', '#DC2626', '#F472B6', '#52525B', '#CA8A04', '#7C3AED'],
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
        ];
    }
}
