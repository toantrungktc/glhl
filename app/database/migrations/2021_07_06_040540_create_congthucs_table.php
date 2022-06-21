<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongthucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('congthucs', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('blend_id')->index();
            $table->string('sothongbao');
            $table->date('ngay_thongbao');
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
        Schema::dropIfExists('congthucs');
    }
}
