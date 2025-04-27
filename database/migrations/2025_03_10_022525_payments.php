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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users
            $table->string('payment_proof', 1000)->nullable(); // Path or URL for payment proof
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Payment status
            $table->decimal('total_amount', 10, 2); // Total payment amount
            $table->timestamp('paid_at')->nullable(); // Time when payment was successful
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};