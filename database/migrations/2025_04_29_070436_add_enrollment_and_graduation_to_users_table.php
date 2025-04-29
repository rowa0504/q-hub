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
        Schema::table('users', function (Blueprint $table) {
            $table->date('enrollment_start')->nullable()->after('role_id');
            $table->date('enrollment_end')->nullable()->after('enrollment_start');
            $table->string('graduation_status')->nullable()->after('enrollment_end');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['enrollment_start', 'enrollment_end', 'graduation_status']);
        });
    }
};
