<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGialieusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gialieus', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('ct_id')->index();
            $table->integer('vattu_id')->index();
            $table->decimal('tyle', 5, 3);
            $table->timestamps();
            $table->timestamp('delete_at')->nullable(); 
            //$table->foreign('ct_id')->references('id')->on('congthucs')->onDelete('cascade');
            //$table->foreign('vattu_id')->references('id')->on('glhls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gialieus');
    }
}
