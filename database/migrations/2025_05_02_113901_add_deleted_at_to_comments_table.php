<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->softDeletes(); // deleted_at カラムを追加
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropSoftDeletes(); // rollback 用
        });
    }
};
