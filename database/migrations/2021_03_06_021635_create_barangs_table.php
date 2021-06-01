<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('merk', 80);
            $table->longText('keterangan');
            $table->string('satuan', 30);
            $table->string('foto', 200);
            $table->tinyInteger('jumlah');
            $table->tinyInteger('status_barang')->default('0');
            $table->unsignedBigInteger('kategori_id');
            $table->longText('spesifikasi');
            $table->string('lokasi', 80);
            $table->string('SN', 80);

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
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
        Schema::dropIfExists('barangs');
    }
}
