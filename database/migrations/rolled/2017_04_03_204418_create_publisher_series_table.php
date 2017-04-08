<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublisherSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisher_series', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id')->unsigned();
            $table->foreign('series_id')
                ->references("id")->on('series')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('publisher_id')->unsigned();
            $table->foreign('publisher_id')
                ->references("id")->on('publishers')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publisher_series');
    }
}
