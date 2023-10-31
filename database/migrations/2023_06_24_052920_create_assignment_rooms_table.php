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
        Schema::create('assignment_rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('numberRooms');
            $table->integer('typeRoom');
            $table->integer('typeAccomodation');
            $table->integer('idHotel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_rooms');
    }
};
