<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_requests', function (Blueprint $table): void {
            $table->string('lead_source')->default('website')->after('need_type')->index();
            $table->string('priority')->default('normal')->after('status')->index();
        });

        Schema::table('quote_requests', function (Blueprint $table): void {
            $table->string('lead_source')->default('website')->after('service_type')->index();
            $table->string('priority')->default('normal')->after('status')->index();
        });

        Schema::table('graduation_project_requests', function (Blueprint $table): void {
            $table->string('lead_source')->default('website')->after('topic')->index();
            $table->string('priority')->default('normal')->after('status')->index();
        });

        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->string('priority')->default('normal')->after('status')->index();
            $table->text('admin_note')->nullable()->after('priority');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropColumn(['priority', 'admin_note']);
        });

        Schema::table('graduation_project_requests', function (Blueprint $table): void {
            $table->dropColumn(['lead_source', 'priority']);
        });

        Schema::table('quote_requests', function (Blueprint $table): void {
            $table->dropColumn(['lead_source', 'priority']);
        });

        Schema::table('order_requests', function (Blueprint $table): void {
            $table->dropColumn(['lead_source', 'priority']);
        });
    }
};
