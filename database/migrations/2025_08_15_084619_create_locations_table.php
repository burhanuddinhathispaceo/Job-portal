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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('type', ['country', 'state', 'city']);
            $table->foreignId('parent_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->string('code', 10)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['type']);
            $table->index(['parent_id']);
            $table->index(['is_active']);
            $table->index(['code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
