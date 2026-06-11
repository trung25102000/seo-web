<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demo_projects', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('name')->unique();
            $table->string('project_type')->nullable()->after('slug')->index();
            $table->text('client_problem')->nullable()->after('project_type');
            $table->text('implemented_solution')->nullable()->after('client_problem');
            $table->json('tech_stack')->nullable()->after('implemented_solution');
            $table->text('role_summary')->nullable()->after('tech_stack');
            $table->text('outcome_summary')->nullable()->after('role_summary');
            $table->string('preview_image_path')->nullable()->after('outcome_summary');
            $table->string('status')->default('published')->after('password_hint')->index();
        });
    }

    public function down(): void
    {
        Schema::table('demo_projects', function (Blueprint $table): void {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug',
                'project_type',
                'client_problem',
                'implemented_solution',
                'tech_stack',
                'role_summary',
                'outcome_summary',
                'preview_image_path',
                'status',
            ]);
        });
    }
};
