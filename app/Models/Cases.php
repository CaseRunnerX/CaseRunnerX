<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Cases extends Model
{
    use SoftDeletes, Userstamps, AutoNumberTrait;

    protected $fillable = [
        'case_number',
        'case_name',
        'suite_id',
        'prerequisite',
        'priority',
        'case_type',
        'reference',
        'steps',
        'expected_result',
        'status',
        'defect',
        'failure',
        'effect',
        'root_cause',
        'issue_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $casts = [
        'steps' => 'array'
    ];

    public function getAutoNumberOptions()
    {
        return [
            'case_number' => [
                'format' => '?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 8 // The number of digits in an autonumber
            ]
        ];
    }

    public function suite(): BelongsTo
    {
        return $this->belongsTo(Suites::class, 'suite_id', 'id');
    }
}
