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
            $table->foreignId('entertainment_type_id')->constrained('loai_hinh')->onDelete('cascade');
            $table->foreignId('ward_id')->constrained('xa_phuong')->onDelete('cascade');
            $table->string('full_address');
            $table->string('phone_number');
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('name_of_owner')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('prefix')->nullable();
            $table->boolean('have_menu')->default(false);
            $table->string('slug')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('opening_hours')->nullable();
            $table->decimal('average_rating', 3, 1)->default(0);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('distance', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diem_vui_choi');
    }
};
