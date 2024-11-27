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
        Schema::create('route_stop_sequences', function (Blueprint $table) {
            $table->primary(['route_id', 'stop_id']);
            $table->integer('route_id')->references('id')->on('routes');
            $table->integer('stop_id')->references('id')->on('stops');
            $table->integer('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_stop_sequences');
    }
};
