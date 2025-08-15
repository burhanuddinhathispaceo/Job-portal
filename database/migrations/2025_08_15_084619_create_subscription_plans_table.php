<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('duration_days');
            $table->integer('job_post_limit')->default(0);
            $table->integer('project_post_limit')->default(0);
            $table->integer('featured_posts')->default(0);
            $table->integer('highlighted_posts')->default(0);
            $table->boolean('candidate_search')->default(false);
            $table->integer('candidate_view_limit')->default(0);
            $table->boolean('analytics_access')->default(false);
            $table->boolean('priority_support')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['is_active']);
            $table->index(['price']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
