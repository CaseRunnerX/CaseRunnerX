<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Wildside\Userstamps\Userstamps;

class Projects extends Model implements Auditable
{
    use Userstamps, AutoNumberTrait, SoftDeletes, \OwenIt\Auditing\Auditable;

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
        'author_id',
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
        'deleted_by',
    ];

    public function getAutoNumberOptions()
    {
        return [
            'test_plan' => [
                'format' => $this->account.' - ?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 5, // The number of digits in an autonumber
            ],
            'project_name' => [
                'format' => $this->application.'-'.$this->account.'-'.$this->project_type.'-?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 5, // The number of digits in an autonumber
            ],
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function milestone(): hasMany
    {
        return $this->hasMany(Milestone::class, 'test_plan_id', 'id');
    }

    public function suites(): hasMany
    {
        return $this->hasMany(Suites::class, 'test_plan_id', 'id');
    }

    public function cases(): hasMany
    {
        return $this->hasMany(Cases::class, 'test_plan_id', 'id');
    }

    public function runs(): hasMany
    {
        return $this->hasMany(Run::class, 'project_id', 'id');
    }
}
