<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->nullable();
            $table->string('case_name');
            $table->foreignId('suite_id');
            $table->longText('prerequisite')->nullable();
            $table->string('priority')->default('Low');
            $table->string('case_type');
            $table->string('reference')->nullable();
            $table->json('steps')->nullable();
            $table->longText('expected_result');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
