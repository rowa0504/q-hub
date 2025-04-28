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
    Schema::table('users', function (Blueprint $table) {
        $table->rememberToken()->after('password'); // もしくは適切な位置に追加
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('remember_token');
    });
}

};
