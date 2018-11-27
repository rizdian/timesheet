<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prfs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_prf', 10);
            $table->enum('type', ['new','extention','replace','trial']);
            $table->string('nm_client', 50);
            $table->longText('keterangan');
            $table->longText('reason');
            $table->integer('flag');
            $table->date('start_project');
            $table->date('end_project');

            $table->timestamps();
            $table->unsignedInteger("employee_id");
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prfs');
    }
}
