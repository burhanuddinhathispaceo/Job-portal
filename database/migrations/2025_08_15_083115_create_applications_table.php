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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->string('resume_path', 500)->nullable();
            $table->enum('status', ['applied', 'viewed', 'shortlisted', 'interview', 'rejected', 'selected'])->default('applied');
            $table->text('company_notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            $table->index(['candidate_id']);
            $table->index(['job_id']);
            $table->index(['project_id']);
            $table->index(['status']);
            $table->index(['candidate_id', 'job_id']);
            $table->index(['candidate_id', 'project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
