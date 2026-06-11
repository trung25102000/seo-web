<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('website_templates', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('template_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('audience_type')->default('shop_owner')->index();
            $table->string('template_type')->default('website')->index();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->string('preview_image_path')->nullable();
            $table->json('gallery')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('status')->default('active')->index();
            $table->timestamps();
        });

        Schema::create('pricing_packages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('audience_type')->index();
            $table->string('package_type')->index();
            $table->unsignedInteger('price')->default(0);
            $table->text('summary')->nullable();
            $table->json('benefits')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('zalo')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('customer_group')->default('shop_owner')->index();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('order_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('website_template_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pricing_package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_group')->default('shop_owner')->index();
            $table->string('need_type')->default('template')->index();
            $table->text('customization_request')->nullable();
            $table->string('status')->default('new')->index();
            $table->text('internal_note')->nullable();
            $table->timestamps();
        });

        Schema::create('quote_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_group')->default('shop_owner')->index();
            $table->string('service_type')->default('website')->index();
            $table->string('budget_range')->nullable();
            $table->string('deadline')->nullable();
            $table->text('requirements');
            $table->string('status')->default('new')->index();
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });

        Schema::create('graduation_project_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('student_name');
            $table->string('student_email')->nullable();
            $table->string('student_phone')->nullable();
            $table->string('school')->nullable();
            $table->string('major')->nullable();
            $table->string('topic');
            $table->text('requirements')->nullable();
            $table->boolean('need_report')->default(true);
            $table->boolean('need_database')->default(true);
            $table->boolean('need_installation_guide')->default(true);
            $table->string('status')->default('new')->index();
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('channel')->default('website');
            $table->text('message');
            $table->string('status')->default('new')->index();
            $table->timestamps();
        });

        Schema::create('blog_posts', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('audience_type')->nullable()->index();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('cover_image_path')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('source_code_products', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('framework')->default('Laravel');
            $table->string('audience_type')->default('student')->index();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->string('demo_url')->nullable();
            $table->string('status')->default('active')->index();
            $table->timestamps();
        });

        Schema::create('demo_projects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('source_code_product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('website_template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('demo_url');
            $table->string('admin_url')->nullable();
            $table->string('username')->nullable();
            $table->string('password_hint')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('product_attachments', function (Blueprint $table): void {
            $table->id();
            $table->morphs('attachable');
            $table->string('type')->index();
            $table->string('name');
            $table->string('path');
            $table->string('disk')->default('local');
            $table->unsignedBigInteger('size')->default(0);
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });

        Schema::create('faq_items', function (Blueprint $table): void {
            $table->id();
            $table->string('audience_type')->nullable()->index();
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_items');
        Schema::dropIfExists('product_attachments');
        Schema::dropIfExists('demo_projects');
        Schema::dropIfExists('source_code_products');
        Schema::dropIfExists('blog_posts');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('graduation_project_requests');
        Schema::dropIfExists('quote_requests');
        Schema::dropIfExists('order_requests');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('pricing_packages');
        Schema::dropIfExists('website_templates');
        Schema::dropIfExists('template_categories');
    }
};
