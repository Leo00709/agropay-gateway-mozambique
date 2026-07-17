<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->string('reference')->unique();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3);
            $table->string('method');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->string('checkout_url')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('merchant_id');
            $table->index('reference');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
