<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Suites extends Model
{
    use SoftDeletes, AutoNumberTrait, Userstamps;

    protected $fillable = [
        'milestone_id',
        'suite_name',
        'suite_number',
        'test_plan_id',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function getAutoNumberOptions()
    {
        return [
            'suite_number' => [
                'format' => '?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 8, // The number of digits in an autonumber
            ],
        ];
    }

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class, 'milestone_id', 'id');
    }

    public function testCases(): HasMany
    {
        return $this->hasMany(Cases::class, 'suite_id', 'id');
    }
}
