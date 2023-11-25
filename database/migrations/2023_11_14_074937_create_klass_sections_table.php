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
        Schema::create('klass_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klass_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('section_year_id')->nullable()->constrained('section_years')->onDelete('cascade');
            $table->string('time')->nullable();
            $table->string('day')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klass_sections');
    }
};
