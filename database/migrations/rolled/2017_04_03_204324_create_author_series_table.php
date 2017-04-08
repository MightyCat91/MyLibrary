<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_series', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('series_id')->unsigned();
            $table->foreign('series_id')
                ->references("id")->on('series')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')
                ->references("id")->on('authors')
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
        Schema::dropIfExists('author_series');
    }
}
