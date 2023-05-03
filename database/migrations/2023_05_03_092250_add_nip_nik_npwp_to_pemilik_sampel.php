<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNipNikNpwpToPemilikSampel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemilik_sampel', function (Blueprint $table) {
            $table->string('nip_petugas')->nullable();
            $table->string('nik_petugas')->nullable();
            $table->string('npwp_petugas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemilik_sampel', function (Blueprint $table) {
            $table->dropColumn('nip_petugas');
            $table->dropColumn('nik_petugas');
            $table->dropColumn('npwp_petugas');
        });
    }
}
