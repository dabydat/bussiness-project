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
        Schema::create('history_conversion_rates', function (Blueprint $table) {
            $table->id();
            $table->string('base_currency');
            $table->json('conversion_rates');
            $table->string('time_last_update_unix');
            $table->string('time_next_update_unix');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_conversion_rates');
    }
};
