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
        Schema::create('cidade', function (Blueprint $table) {
            $table->string('ibge', 10);
            $table->string('cidade');
            $table->string('uf', 2);
            $table->string('cep', 8)->nullable();
            $table->index('uf', 'idx_uf');
            $table->index('cep', 'idx_cep');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cidade', function (Blueprint $table) {
            $table->dropIndex('idx_uf');
            $table->dropIndex('idx_cep');
        });

        Schema::dropIfExists('cidade');
    }
};
