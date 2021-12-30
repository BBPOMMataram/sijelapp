<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image', 255)->default('noimage.png');
            $table->string('username', 100);
            $table->string('fullname')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('jabatan')->nullable();
            $table->tinyInteger('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('username');
            $table->dropColumn('level');
            $table->dropColumn('fullname');
            $table->dropColumn('pangkat');
            $table->dropColumn('jabatan');
        });
    }
}
