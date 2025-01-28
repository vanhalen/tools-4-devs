<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cep', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Campos básicos
            $table->string('cep', 8)->unique(); // Índice único no CEP
            $table->string('logradouro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('unidade')->nullable();
            $table->string('bairro')->nullable();
            $table->string('localidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('estado')->nullable();
            $table->string('regiao')->nullable();
            $table->string('ibge', 10)->nullable();
            $table->string('gia')->nullable();
            $table->string('ddd', 4)->nullable();
            $table->string('siafi')->nullable();
            $table->string('localizacao_tipo')->nullable();
            $table->string('localizacao_longitude')->nullable();
            $table->string('localizacao_latitude')->nullable();

            // Campos de controle para APIs
            $table->boolean('consultado_viacep')->default(false)->comment('Indica se o CEP foi consultado na API ViaCEP');
            $table->boolean('consultado_brasilapi')->default(false)->comment('Indica se o CEP foi consultado na API BrasilAPI');

            $table->timestamps();

            // Índices adicionais
            $table->index(['uf', 'localidade', 'logradouro'], 'idx_uf_localidade_logradouro'); // Índice composto para busca por rua, cidade e estado
            $table->index('uf', 'idx_uf'); // Índice para consultas por bairro
            $table->index('bairro', 'idx_bairro'); // Índice para consultas por bairro

            // Índices para controle de APIs (opcional)
            $table->index(['consultado_viacep'], 'idx_consultado_viacep');
            $table->index(['consultado_brasilapi'], 'idx_consultado_brasilapi');
        });
    }

    public function down()
    {
        Schema::table('cep', function (Blueprint $table) {
            // Removendo os índices adicionados
            $table->dropIndex('idx_uf_localidade_logradouro');
            $table->dropIndex('idx_uf');
            $table->dropIndex('idx_bairro');
            $table->dropIndex('idx_consultado_viacep');
            $table->dropIndex('idx_consultado_brasilapi');
            $table->dropUnique(['cep']);
        });

        Schema::dropIfExists('cep');
    }
};
