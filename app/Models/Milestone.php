<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Milestone extends Model
{
    use SoftDeletes,Userstamps;

    protected $fillable = [
        'test_plan_id',
        'milestone_name',
        'assigned_qa',
        'description',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
        'deleted_by'
    ];


    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'test_plan_id', 'id');
    }

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'test_plan_id', 'id');
    }

    public function run(): HasMany
    {
        return  $this->hasMany(Run::class, 'milestone_id');
    }

    public function qa()
    {
        return $this->belongsTo(User::class, 'assigned_qa', 'id');
    }
}
