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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('deliverables')->nullable();
            $table->foreignId('project_type_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('budget_min', 10, 2)->nullable();
            $table->decimal('budget_max', 10, 2)->nullable();
            $table->string('budget_currency', 3)->default('USD');
            $table->integer('duration_value')->nullable();
            $table->enum('duration_unit', ['days', 'weeks', 'months'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['draft', 'active', 'inactive', 'expired', 'completed'])->default('draft');
            $table->enum('visibility', ['normal', 'highlighted', 'featured'])->default('normal');
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index(['company_id']);
            $table->index(['project_type_id']);
            $table->index(['status']);
            $table->index(['visibility']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
