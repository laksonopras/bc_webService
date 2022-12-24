<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->String('kode_booking', 8)->unique()->primary();
            $table->foreignId('id_pelanggan')->references('id_pelanggan')->on('pelanggans')->onDelete('cascade');
            $table->String('judul_film');
            $table->String('studio');
            $table->String('kelas');
            $table->date('tanggal');
            $table->time('jam');
            $table->integer('harga_tiket');
            $table->integer('jumlah_tiket');
            $table->integer('total_harga');
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
        Schema::dropIfExists('transactions');
    }
};
