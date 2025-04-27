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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Definisikan kolom dan constraint
            $table->foreignId('user_preference_id')->nullable()->constrained('user_preferences')->onDelete('set null');
            $table->string('name');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->json('instructions');
            $table->string('image')->nullable();
            $table->string('country')->nullable();
            $table->text('detail')->nullable();
            $table->json('ingredients');
            $table->enum('spiciness', ['low', 'medium', 'high'])->default('medium');
            $table->enum('premium', ['no', 'yes'])->default('no');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
