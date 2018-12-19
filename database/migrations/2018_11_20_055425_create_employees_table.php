<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip', 10);
            $table->string('nama', 50);
            $table->string('tmpt_lahir', 30);
            $table->date('tgl_lahir');
            $table->longText('alamat');
            $table->enum('flag', ['isManager','isKeuangan','replace','trial']);
            $table->timestamps();

            $table->unsignedInteger("division_id");
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
