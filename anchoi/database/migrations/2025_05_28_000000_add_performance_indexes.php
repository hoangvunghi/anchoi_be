<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // diem_vui_choi: status + slug lọc ở mọi query; composite cho "approved + loại/khu vực"
        Schema::table('diem_vui_choi', function (Blueprint $table) {
            $table->index('status', 'dvc_status_idx');
            $table->index('slug', 'dvc_slug_idx');
            $table->index(['entertainment_type_id', 'status'], 'dvc_type_status_idx');
            $table->index(['ward_id', 'status'], 'dvc_ward_status_idx');
        });

        // slug được match liên tục trong URL parser (where/whereHas/whereIn)
        Schema::table('loai_hinh', fn (Blueprint $t) => $t->index('slug', 'loaihinh_slug_idx'));
        Schema::table('tinh', fn (Blueprint $t) => $t->index('slug', 'tinh_slug_idx'));
        Schema::table('xa_phuong', fn (Blueprint $t) => $t->index('slug', 'xaphuong_slug_idx'));
    }

    public function down(): void
    {
        Schema::table('diem_vui_choi', function (Blueprint $table) {
            $table->dropIndex('dvc_status_idx');
            $table->dropIndex('dvc_slug_idx');
            $table->dropIndex('dvc_type_status_idx');
            $table->dropIndex('dvc_ward_status_idx');
        });
        Schema::table('loai_hinh', fn (Blueprint $t) => $t->dropIndex('loaihinh_slug_idx'));
        Schema::table('tinh', fn (Blueprint $t) => $t->dropIndex('tinh_slug_idx'));
        Schema::table('xa_phuong', fn (Blueprint $t) => $t->dropIndex('xaphuong_slug_idx'));
    }
};
