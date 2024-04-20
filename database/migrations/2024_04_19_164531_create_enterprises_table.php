<?php


use App\Enums\Enterprise\DocumentTypeEnum;
use App\Enums\Enterprise\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum(
                'document_type',
                DB::table('document_types')->pluck('description')->toArray()
            )->default(DocumentTypeEnum::OTHER);
            $table->enum(
                'status',
                DB::table('status_enterprises')->pluck('description')->toArray()
            )->default(StatusEnum::ACTIVE);
            $table->string('email')->unique();
            $table->string('location')->nullable();
            $table->string('phone_number')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enterprises');
    }
};
