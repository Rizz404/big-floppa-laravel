<?php

use App\Models\Criterion;
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
        Schema::create('session_criteria_weights', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(EvaluationSession::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Criterion::class)->constrained()->cascadeOnDelete();
            $table->decimal('weight', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_criteria_weights');
    }
};
