<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'email')) {
                $table->string('email')->nullable()->after('name');
            }
            if (!Schema::hasColumn('comments', 'body')) {
                $table->text('body')->nullable()->after('email');
            }
            // 'content' không được dùng ở đâu; app dùng 'body'
            if (Schema::hasColumn('comments', 'content')) {
                $table->dropColumn('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (!Schema::hasColumn('comments', 'content')) {
                $table->text('content')->nullable();
            }
            $table->dropColumn(['email', 'body']);
        });
    }
};
