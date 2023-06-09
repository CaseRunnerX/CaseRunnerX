<?php

namespace App\Filament\Widgets;

use App\Models\Projects;
use Illuminate\Database\Eloquent\Model;
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

    protected function getOptions(): array
    {
        //showing a loading indicator immediately after the page load
        if (!$this->readyToLoad) {
            return [];
        }

        // Fetch test case run
        $projectData = Projects::find($this->record->id)->has('runs.runCases')->get();



        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Number of Test Case',
                    'data' => [7, 4, 6, 10, 14, 7, 5, 9, 10, 15, 13, 18],
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
        ];
    }
}
