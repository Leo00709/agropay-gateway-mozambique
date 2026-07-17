<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name');
            $table->string('business_email');
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('nib')->unique();
            $table->enum('status', ['pending', 'active', 'suspended', 'rejected'])->default('pending');
            $table->decimal('commission_rate', 5, 2)->default(2.5);
            $table->decimal('balance', 15, 2)->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
