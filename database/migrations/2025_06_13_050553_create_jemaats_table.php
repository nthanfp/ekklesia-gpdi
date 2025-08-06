<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJemaatsTable extends Migration
{
    public function up()
    {
        Schema::create('jemaats', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kartu_keluarga_id')->nullable()->constrained()->nullOnDelete();

            $table->string('no_anggota')->unique();
            $table->string('nik', 16)->nullable()->unique();
            $table->string('nama');
            $table->string('telepon')->nullable();

            $table->enum('gender', ['L', 'P']);
            $table->date('tanggal_lahir');

            $table->enum('status_kawin', ['LAJANG', 'MENIKAH', 'CERAI_HIDUP', 'CERAI_MATI'])->default('LAJANG');
            $table->string('pendidikan')->nullable();
            $table->string('gelar')->nullable();

            $table->boolean('status_baptis')->default(false);
            $table->date('tanggal_baptis')->nullable();

            $table->string('pekerjaan')->nullable();
            $table->date('tanggal_gabung')->nullable();

            $table->enum('status_pelayanan', ['MAJELIS', 'AKTIVIS', 'JEMAAT'])->default('JEMAAT');

            $table->enum('status_keaktifan', ['AKTIF', 'MENINGGAL', 'PINDAH'])->default('AKTIF');
            $table->date('tanggal_nonaktif')->nullable();

            $table->enum('status_kk', [
                'KEPALA_KELUARGA',
                'SUAMI',
                'ISTRI',
                'ANAK',
                'CUCU',
                'ORANG_TUA',
                'MENANTU',
                'MERTUA',
                'KELUARGA_LAIN',
                'LAINNYA'
            ])->nullable();

            $table->string('foto')->nullable();

            $table->timestamps();
        });

        Schema::table('jemaats', function (Blueprint $table) {
            $table->date('tanggal_pernikahan')->nullable()->after('status_kawin');
            $table->boolean('is_menikah')->default(false)->after('tanggal_pernikahan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jemaats');
    }
}
