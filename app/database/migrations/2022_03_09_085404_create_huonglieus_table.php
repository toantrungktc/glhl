<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHuonglieusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('huonglieus', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('ct_id')->index();
            $table->integer('vattu_id')->index();
            $table->decimal('tyle', 5, 3);
            $table->timestamps();
            $table->timestamp('delete_at')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huonglieus');
    }
}
