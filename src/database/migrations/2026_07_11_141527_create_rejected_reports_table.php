<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rejected_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->datetime('tanggal');
            $table->string('jenis_barang');
            $table->string('nomor_produksi');
            $table->string('nomor_batch');
            $table->integer('jumlah_barang');
            $table->json('jenis_cacat');
            $table->json('keputusan_handling');
            $table->text('catatan')->nullable();
            $table->string('created_by_user_id');
            $table->boolean('checked_by_qc')->default(false);
            $table->boolean('checked_by_prod')->default(false);
            $table->boolean('checked_by_ppic')->default(false);
            $table->boolean('checked_by_merch')->default(false);
            $table->boolean('checked_by_stor')->default(false);
            $table->boolean('checked_by_acc')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejected_reports');
    }
};
