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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'company', 'candidate'])->after('email');
            $table->string('mobile', 20)->unique()->nullable()->after('role');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('mobile');
            $table->string('preferred_locale', 5)->default('en')->after('status');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
            
            $table->index(['role']);
            $table->index(['status']);
            $table->index(['mobile']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
            $table->dropIndex(['mobile']);
            
            $table->dropColumn(['role', 'mobile', 'status', 'preferred_locale', 'last_login_at']);
        });
    }
};
