<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->id();
            $table->date('test_run_date')->nullable();
            $table->string('test_run_name');
            $table->longText('references');
            $table->foreignId('milestone_id');
            $table->longText('description');
            $table->foreignId('assigned_qa')->nullable();
            $table->foreignId('test_suite_id');
            $table->string('status');
            $table->longText('actual_result');
            $table->longText('defect')->nullable();
            $table->longText('failure')->nullable();
            $table->longText('effect')->nullable();
            $table->longText('root_cause')->nullable();
            $table->string('issue_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('runs');
    }
};
