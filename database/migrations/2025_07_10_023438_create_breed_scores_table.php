<?php

use App\Models\Breed;
use App\Models\Criterion;
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
        Schema::create('breed_scores', function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->foreignIdFor(Breed::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Criterion::class)->constrained()->cascadeOnDelete();
            $table->integer('score')->unsigned();
            $table->timestamps();

            $table->unique(['breed_id', 'criterion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breed_scores');
    }
};
