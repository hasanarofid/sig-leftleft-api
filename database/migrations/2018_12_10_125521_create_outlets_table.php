<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('address')->nullable();
            $table->string('gambar')->nullable();
            $table->string('harga')->nullable();
            $table->string('harga_range')->nullable();
            $table->string('categori')->nullable();
            $table->string('rules')->nullable();
            $table->string('fasilitas')->nullable();
            $table->string('room')->nullable();
            $table->string('bed')->nullable();
            $table->string('bathroom')->nullable();
            $table->string('roompic')->nullable();
            $table->string('deskripsi')->nullable();
            $table->integer('provinsi_id')->nullable(); 
            $table->integer('kabupaten_id')->nullable(); 
            $table->integer('kecamatan_id')->nullable(); 
            $table->integer('kelurahan_id')->nullable(); 
            $table->string('latitude', 15)->nullable();
            $table->string('longitude', 15)->nullable();
            $table->unsignedInteger('creator_id');
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outlets');
    }
}
