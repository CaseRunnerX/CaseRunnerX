<?php

namespace App\Filament\Resources\ProjectsResource\Widgets;

use App\Models\Projects;
use App\Models\Run;
use App\Models\RunCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ProjectMilestone extends ApexChartWidget
{
    /**
     * Chart Id
     */
    protected static string $chartId = 'projectMilestone';

    /**
     * Widget Title
     */
    protected static ?string $heading = 'Project Milestone Analytics';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected static bool $deferLoading = true;

    public ?Model $record = null;

    protected static ?string $pollingInterval = null;

    public ?array $milestoneCounter = [];

    protected function getOptions(): array
    {

        //showing a loading indicator immediately after the page load
        if (! $this->readyToLoad) {
            return [];
        }

        // Fetch test case run
        $this->fetchData();

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total # of Test Cases',
                    'data' => $this->milestoneCounter['milestone_count'] ?? [],
                ],
                [
                    'name' => 'Total # of Test Cases Executed',
                    'data' => $this->milestoneCounter['executed'] ?? [],
                ],
                [
                    'name' => 'Total # of Test Cases Untested',
                    'data' => $this->milestoneCounter['untested'] ?? [],
                ],
            ],
            'xaxis' => [
                'categories' => $this->milestoneCounter['milestone_name'] ?? [],
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'stroke' => [
                'show' => true,
                'width' => 2,
                'colors' => ['transparent'],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'fill' => [
                'opacity' => 1,
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'columnWidth' => '45%',
                    'borderRadius' => 4,
                    'endingShape' => 'rounded',
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'legend' => [
                'show' => true,
                'position' => 'top',
                'labels' => [
                    'colors' => '#9ca3af',
                ],
            ],
            'colors' => [
                '#EA580C', '#16A34A', '#FDE047',

            ],
        ];
    }

    public function fetchData()
    {
        // Fetch test case run
        $projectData = Projects::whereId($this->record->id)->with('milestone')->get();
        foreach ($projectData as $project) {
            foreach ($project->milestone as $milestone) {
                $runcase = Run::whereJsonContains('milestone_id', "{$milestone->id}")->get();
                $this->milestoneCounter['milestone_name'][] = Str::title($milestone->milestone_name);
                $this->milestoneCounter['milestone_count'][] = $runcase->count() ?? 0;
                $testRunCasesUntested = 0;
                $testRunCasesExecuted = 0;
                foreach ($runcase as $runCaseData) {
                    // Test Run Cases
                    $testRunCasesUntested += RunCase::whereRunId($runCaseData->id)->whereIn('status', [
                        'Untested',  'To Be Determined',
                    ])->get()->count();
                    $testRunCasesExecuted += RunCase::whereRunId($runCaseData->id)->whereIn('status', [
                        'Passed',  'Failed', 'Retest', 'Blocked', 'Skipped',
                    ])->get()->count();

                }
                $this->milestoneCounter['executed'][] = $testRunCasesExecuted;
                $this->milestoneCounter['untested'][] = $testRunCasesUntested;

                //                ddd($this->milestoneCounter);
            }
        }
    }
}
