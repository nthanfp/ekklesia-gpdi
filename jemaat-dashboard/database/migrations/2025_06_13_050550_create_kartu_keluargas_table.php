<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kartu_keluargas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rayon_id')->constrained()->onDelete('restrict');
            $table->string('no_kk')->unique();
            $table->string('kepala_keluarga');

            // Foreign nullable untuk wilayah
            $table->char('provinsi_id', 2)->nullable();
            $table->foreign('provinsi_id')->references('id')->on('provinces')->nullOnDelete();

            $table->char('kota_id', 4)->nullable();
            $table->foreign('kota_id')->references('id')->on('regencies')->nullOnDelete();

            $table->char('kecamatan_id', 7)->nullable();
            $table->foreign('kecamatan_id')->references('id')->on('districts')->nullOnDelete();

            $table->char('kelurahan_id', 10)->nullable();
            $table->foreign('kelurahan_id')->references('id')->on('villages')->nullOnDelete();


            // Bisa juga kodepos sebagai FK jika punya tabel
            $table->unsignedBigInteger('kodepos_id')->nullable();

            // Alamat detail
            $table->unsignedSmallInteger('alamat_rt')->nullable();
            $table->unsignedSmallInteger('alamat_rw')->nullable();
            $table->text('alamat_lengkap')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kartu_keluargas');
    }
};
