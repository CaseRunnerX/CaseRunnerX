<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Run extends Model
{
    use SoftDeletes, Userstamps;

    protected $fillable = [
        'test_run_date',
        'test_run_name',
        'test_run_name',
        'milestone_id',
        'description',
        'assigned_qa',
        'test_suite_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'test_suite_id' => 'array'
    ];
}
