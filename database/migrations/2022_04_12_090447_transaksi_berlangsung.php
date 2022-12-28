<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TransaksiBerlangsung extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_berlangsung', function (Blueprint $table){
            $table->increments('idReservasi');
            $table->integer('idResto');
            $table->integer('idCust');
            $table->timestamps();
            $table->date('date_reservasi');
            $table->time('time_reservasi');
            $table->integer('no_table');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_berlangsung');
    }
}
