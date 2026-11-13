<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog', function (Blueprint $table) {
            if (!Schema::hasColumn('blog', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable()->after('slug');
                $table->index('category_id', 'blog_category_id_idx');
            }
            if (!Schema::hasColumn('blog', 'body')) {
                $table->text('body')->nullable()->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('blog', function (Blueprint $table) {
            if (Schema::hasColumn('blog', 'category_id')) {
                $table->dropIndex('blog_category_id_idx');
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('blog', 'body')) {
                $table->dropColumn('body');
            }
        });
    }
};
