<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali');
            $table->unsignedBigInteger('anggota_id');
            $table->tinyInteger('status')->default('0');
            $table->string('cc_anggota')->default('-');

            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('cascade');
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
        Schema::dropIfExists('peminjaman');
    }
}
