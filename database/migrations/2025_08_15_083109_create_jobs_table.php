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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('responsibilities')->nullable();
            $table->foreignId('job_type_id')->nullable()->constrained()->onDelete('set null');
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('salary_currency', 3)->default('USD');
            $table->integer('experience_min')->default(0);
            $table->integer('experience_max')->nullable();
            $table->string('education_level', 100)->nullable();
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['draft', 'active', 'inactive', 'expired', 'filled'])->default('draft');
            $table->enum('visibility', ['normal', 'highlighted', 'featured'])->default('normal');
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index(['company_id']);
            $table->index(['job_type_id']);
            $table->index(['status']);
            $table->index(['visibility']);
            $table->index(['status', 'visibility']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
