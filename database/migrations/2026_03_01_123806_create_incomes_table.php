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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')
                    ->constrained('games')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            $table->date('date');
            $table->float('stat');
            $table->string('source', length: 128);
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['game_id','date','source']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
