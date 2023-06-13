<?php

namespace App\Filament\Resources\ProjectsResource\Widgets;

use App\Models\Projects;
use App\Models\Run;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ProjectMilestone extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'projectMilestone';

    /**
     * Widget Title
     *
     * @var string|null
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
        if (!$this->readyToLoad) {
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
                    'name' => 'Total Number of Test Cases',
                    'data' => $this->milestoneCounter['milestone_count'],
                ],
                [
                    'name' => 'Net Profit',
                    'data' => [44, 55]
                ],
                [
                    'name' => 'Revenue',
                    'data' => [76, 85]
                ],
            ],
            'xaxis' => [
                'categories' => $this->milestoneCounter['milestone_name'],
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
                'colors' => ['transparent']
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
                'opacity' => 1
            ],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => false,
                    'columnWidth' => '55%',
                    'borderRadius' => 4,
                    'endingShape'=>  'rounded'
                ]
            ],
            'dataLabels'=> [
                'enabled' => false
            ],
            'legend' => [
                'show' => true,
                'position' => 'top',
                'labels' => [
                    'colors' => '#9ca3af'
                ]
            ]
        ];


       /* return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Total Number of Test Cases',
                    'data' => $this->milestoneCounter['milestone_count'],
                ],
            ],
            'xaxis' => [
                'categories' => $this->milestoneCounter['milestone_name'],
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'colors' => '#9ca3af',
                        'fontWeight' => 600,
                    ],
                ],
            ],
            'colors' => ['#6366f1'],
        ];*/
    }

    public function fetchData()
    {
        // Fetch test case run
        $projectData = Projects::whereId($this->record->id)->with('milestone')->get();
        foreach ($projectData as $project)
        {
            foreach ($project->milestone as $milestone)
            {
                $runcase = Run::whereJsonContains('milestone_id', "{$milestone->id}")->get();
                $this->milestoneCounter['milestone_name'][] = $milestone->milestone_name;
                $this->milestoneCounter['milestone_count'][] = $runcase->count();
            }
        }
    }
}
