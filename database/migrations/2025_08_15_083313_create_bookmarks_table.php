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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bookmarkable_type', 50);
            $table->unsignedBigInteger('bookmarkable_id');
            $table->string('folder', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id']);
            $table->index(['user_id', 'bookmarkable_type']);
            $table->index(['bookmarkable_type', 'bookmarkable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
