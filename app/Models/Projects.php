<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Wildside\Userstamps\Userstamps;

class Projects extends Model
{
    use Userstamps, AutoNumberTrait;

    protected $fillable = [
        'account',
        'application',
        'project_type',
        'assigned_project_manager',
        'assigned_developer',
        'assigned_qa',
        'assigned_account_manager',
        'test_plan',
        'project_name',
        'author',
        'computing_environment',
        'software_type',
        'testing_purposes',
        'user_demo_graphics',
        'assumptions',
        'testing_phases',
        'testing_scope',
        'critical_success_factor',
        'type_of_testing',
        'tester_profile',
        'test_reference',
        'test_deliverable',
        'development_test_tools',
        'business_operational_concern',
        'risk',
        'other',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function getAutoNumberOptions()
    {
        return [
            'account' => [
                'format' => $this->test_plan.' - ?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 5 // The number of digits in an autonumber
            ]
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'author');
    }
}
