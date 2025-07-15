<?php

use App\Models\Breed;
use App\Models\User;
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
        Schema::create('listings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            // ! kalo mau dinamain jangan pake foreignIdFor
            $table->foreignUlid('seller_id')->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(Breed::class)->constrained()->restrictOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('location', 255);
            $table->boolean('is_vaccinated')->default(false);
            $table->boolean('is_dewormed')->default(false);
            $table->enum('status', ['available', 'sold', 'archived'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
