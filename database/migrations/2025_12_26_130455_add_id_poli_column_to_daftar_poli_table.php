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
        Schema::table('daftar_poli', function (Blueprint $table) {
            $table->unsignedBigInteger('id_poli')->nullable();
            $table->foreign('id_poli')->references('id')->on('poli');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_poli', function (Blueprint $table) {
            if (Schema::hasColumn('daftar_poli', 'id_poli')) {
                $table->dropForeign(['id_poli']);
                $table->dropColumn('id_poli');
            }
        });
    }
};
