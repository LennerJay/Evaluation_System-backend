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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluator_id')->constrained('users','id_number') ->onDelete('cascade');
            $table->foreignId('question_id')->constrained() ->onDelete('cascade')->onDelete('cascade');
            $table->foreignId('evaluatee_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
