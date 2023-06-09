<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Wildside\Userstamps\Userstamps;

class Run extends Model implements Auditable
{
    use SoftDeletes, Userstamps, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'test_run_date',
        'test_run_name',
        'test_run_name',
        'milestone_id',
        'description',
        'assigned_qa',
        'test_suite_id',
        'project_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'test_suite_id' => 'array',
        'milestone_id' => 'array',
    ];

    public function runCases(): HasMany
    {
        return $this->hasMany(RunCase::class, 'run_id', 'id');
    }

    public function milestone(): belongsTo
    {
        return $this->belongsTo(Milestone::class, 'milestone_id', 'id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($run) {
            $run->runCases()->delete();
        });
    }
}
