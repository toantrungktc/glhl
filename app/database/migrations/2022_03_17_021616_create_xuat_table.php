<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xuats', function (Blueprint $table) {
            $table->id();
            $table->date('ngay_pha');
            $table->string('ct_id',50);
            $table->decimal('kl_la', 10, 3);
            $table->decimal('kh_soi', 10, 3);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xuats');
    }
}
