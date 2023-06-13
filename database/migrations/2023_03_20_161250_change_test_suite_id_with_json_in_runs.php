<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('runs', function (Blueprint $table) {
            $table->json('test_suite_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('runs', function (Blueprint $table) {
            //
        });
    }
};
