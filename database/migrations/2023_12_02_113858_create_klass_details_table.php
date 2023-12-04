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
        Schema::create('klass_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('s_y_d_id')->nullable()->constrained('section_year_departments','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('evaluatee_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('time');
            $table->string('day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klass_details');
    }
};
