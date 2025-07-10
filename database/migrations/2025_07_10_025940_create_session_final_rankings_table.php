<?php

use App\Models\Breed;
use App\Models\EvaluationSession;
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
        Schema::create('session_final_rankings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(EvaluationSession::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Breed::class)->constrained()->cascadeOnDelete();
            $table->decimal('final_score', 10, 5);
            $table->integer('rank')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_final_rankings');
    }
};
