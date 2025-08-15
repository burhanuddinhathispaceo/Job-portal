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
        Schema::table('candidates', function (Blueprint $table) {
            // Add profile completion tracking
            $table->integer('profile_completion')->default(0)->after('portfolio_url');
            $table->integer('profile_views')->default(0)->after('profile_completion');
            $table->integer('resume_downloads')->default(0)->after('profile_views');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn(['profile_completion', 'profile_views', 'resume_downloads']);
        });
    }
};