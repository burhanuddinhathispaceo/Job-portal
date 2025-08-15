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
        Schema::table('companies', function (Blueprint $table) {
            // Add verification fields
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending')->after('linkedin_url');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->text('verification_notes')->nullable()->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['verification_status', 'verified_at', 'verification_notes']);
        });
    }
};