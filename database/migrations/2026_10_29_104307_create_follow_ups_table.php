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
        Schema::create('follow_ups', function (Blueprint $table) {
                 $table->id();

        $table->foreignId('report_id')
            ->constrained('reports')
            ->cascadeOnDelete();

        $table->foreignId('coordinator_id')
            ->constrained('users')
            ->restrictOnDelete();

        $table->string('pihak_tujuan');
        $table->text('catatan')->nullable();
        $table->dateTime('tanggal_diteruskan')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
