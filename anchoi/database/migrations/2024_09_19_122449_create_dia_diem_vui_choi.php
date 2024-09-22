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
        Schema::create('diem_vui_choi', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('entertainment_type_id')->constrained('loai_hinh');
            $table->foreignId('ward_id')->constrained('xa');
            $table->string('full_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('description');
            $table->string('banner_image')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->string('name_of_owner')->nullable();
            $table->string('slug')->nullable();
            $table->string('prefix')->nullable();
            $table->string('status')->default('pending');
            $table->text('opening_hours')->nullable();  
            $table->text('additional_info')->nullable();
            $table->decimal('average_rating', 4, 2)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->double('distance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dia_diem_vui_choi');
    }
};
