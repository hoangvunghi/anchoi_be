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
        Schema::create('xa', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('district_id')->constrained('quan_huyen')->onDelete('cascade');
            $table->string('slug')->nullable();
            $table->string('prefix')->default('xa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xa');
    }
};
