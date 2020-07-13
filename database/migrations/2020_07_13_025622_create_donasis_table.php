<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donasis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nominal');
            $table->date('tgl_transfer');
            $table->longText('filename')->nullable();
            $table->enum('type', ['cash','transfer']);

            $table->timestamps();
            $table->unsignedInteger("donatur_id");
            $table->foreign('donatur_id')->references('id')->on('donaturs')->onDelete('cascade');

            $table->unsignedInteger("acara_id");
            $table->foreign('acara_id')->references('id')->on('acaras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donasi');
    }
}
