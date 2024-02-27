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
        Schema::create('duties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('room_id')->nullable()->constrained('rooms');
            $table->foreignId('house_id')->constrained('houses');
            $table->string('status')->default('active');
            $table->string('frequency')->default('daily');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('last_performed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duties');
    }
};
