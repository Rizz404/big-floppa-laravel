<?php

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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->ulid("id")->primary();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('label')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('country', 255);
            $table->string('subdistrict'); // * Kelurahan / Desa
            $table->string('district'); // * Kecamatan
            $table->string('city'); // * Kota / Kabupaten
            $table->string('province');
            $table->string('postal_code', 10);
            $table->text('address_line_1');
            $table->text('address_line_2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
