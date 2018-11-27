<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsentivePrfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insentivePrfs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger("incentive_id");
            $table->foreign('incentive_id')->references('id')->on('incentives')->onDelete('cascade');
            $table->unsignedInteger("prfs_id");
            $table->foreign('prfs_id')->references('id')->on('prfs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insentivePrfs');
    }
}
