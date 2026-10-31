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
        Schema::table('reports', function (Blueprint $table) {
        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->foreignId('school_id')
            ->constrained('schools')
            ->restrictOnDelete();

        $table->foreignId('distribution_id')
            ->nullable()
            ->constrained('distributions')
            ->nullOnDelete();

        $table->string('judul');
        $table->text('deskripsi');
        $table->string('kategori');
        $table->string('status')->default('diajukan');
        $table->string('evidence_path')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('reports', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropForeign(['school_id']);
        $table->dropForeign(['distribution_id']);

        $table->dropColumn([
            'user_id',
            'school_id',
            'distribution_id',
            'judul',
            'deskripsi',
            'kategori',
            'status',
            'evidence_path',
        ]);
    });
    }
};
