<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nisn');
            $table->string('nama', 35);
            $table->string('tempat_lahir', 15);
            $table->date('tanggal_lahir');
            $table->boolean('jen_kel');
            $table->string('agama', 10);
            $table->mediumText('alamat');
            $table->unsignedInteger('id_sekolah');
            $table->timestamps();

            $table->foreign('id_sekolah')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
