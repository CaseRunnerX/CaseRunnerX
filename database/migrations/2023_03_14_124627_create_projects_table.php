<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('account');
            $table->string('application');
            $table->string('project_type');
            $table->string('assigned_project_manager');
            $table->string('assigned_developer');
            $table->string('assigned_qa');
            $table->string('assigned_account_manager');
            $table->string('test_plan');
            $table->string('project_name');
            $table->unsignedBigInteger('author');
            $table->longText('computing_environment');
            $table->longText('software_type');
            $table->longText('testing_purposes');
            $table->longText('user_demo_graphics');
            $table->longText('assumptions');
            $table->longText('testing_phases');
            $table->longText('testing_scope');
            $table->longText('critical_success_factor');
            $table->longText('type_of_testing');
            $table->longText('tester_profile');
            $table->longText('test_reference');
            $table->longText('test_deliverable');
            $table->longText('development_test_tools');
            $table->longText('business_operational_concern');
            $table->longText('risk');
            $table->longText('other');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
