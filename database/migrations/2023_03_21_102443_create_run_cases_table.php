<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('run_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('run_id');
            $table->foreignId('case_id');
            $table->string('status')->nullable()->default('Untested');
            $table->longText('actual_result')->nullable();
            $table->longText('defect')->nullable();
            $table->longText('failure')->nullable();
            $table->longText('effect')->nullable();
            $table->longText('root_cause')->nullable();
            $table->string('issue_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('run_cases');
    }
};
