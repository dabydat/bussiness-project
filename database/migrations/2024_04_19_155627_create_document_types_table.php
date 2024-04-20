<?php

use Database\Seeders\DocumentTypesTableSeeder;
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
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });
        // Realizamos la poblacion de la tabla antes de ejecutar la siguiente migracion de la tabla "enterprises"
        Artisan::call('db:seed', ['--class' => 'DocumentTypesTableSeeder']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
