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
        Schema::create('section_per_users', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users','id_number')->onDelete('cascade');
            $table->foreignId('section_year_id')->constrained('section_years','id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_per_users');
    }
};
