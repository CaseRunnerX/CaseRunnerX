<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RunCase extends Model
{

    protected $fillable = [
      'run_id',
      'case_id',
      'status',
      'actual_result',
      'defect',
      'failure',
      'effect',
      'root_cause',
      'issue_id'
    ];


    public function testCase(): HasMany
    {
        return $this->hasMany(Cases::class, 'id', 'case_id');
    }

    public function testRun(): BelongsTo
    {
        return $this->belongsTo(Run::class, 'run_id', 'id');
    }
}
