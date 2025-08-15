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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('cascade');
            $table->enum('status', ['active', 'expired', 'cancelled', 'suspended'])->default('active');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('auto_renew')->default(true);
            $table->string('payment_method', 50)->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount_paid', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->timestamps();
            
            $table->index(['company_id']);
            $table->index(['plan_id']);
            $table->index(['status']);
            $table->index(['end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
