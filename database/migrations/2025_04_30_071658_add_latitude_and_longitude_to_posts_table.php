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
        Schema::table('posts', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('location');   // 緯度
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');  // 経度
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
