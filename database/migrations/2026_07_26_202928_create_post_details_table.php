<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedInteger('reading_minutes')->default(1);
            $table->string('source')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_details');
    }
};