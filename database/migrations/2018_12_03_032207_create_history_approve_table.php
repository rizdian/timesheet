<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryApproveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_approves', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->unsignedInteger("prf_id");
            $table->foreign('prf_id')->references('id')->on('prfs')->onDelete('cascade');
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
        Schema::dropIfExists('historyApproves');
    }
}
