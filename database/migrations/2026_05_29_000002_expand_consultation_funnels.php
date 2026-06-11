<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_requests', function (Blueprint $table): void {
            $table->string('preferred_contact_channel')->nullable()->after('customer_phone');
            $table->string('technology_stack')->nullable()->after('deadline');
        });

        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->string('service_type')->nullable()->after('channel');
            $table->string('preferred_contact_channel')->nullable()->after('service_type');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table): void {
            $table->dropColumn(['service_type', 'preferred_contact_channel']);
        });

        Schema::table('quote_requests', function (Blueprint $table): void {
            $table->dropColumn(['preferred_contact_channel', 'technology_stack']);
        });
    }
};
