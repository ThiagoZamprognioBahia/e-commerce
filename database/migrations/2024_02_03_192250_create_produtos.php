<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('referencia')->unique();
            $table->string('descricao');
            $table->decimal('valor', 10, 2);
            $table->decimal('valor_riscado', 10, 2)->nullable();
            $table->integer('estoque');
            $table->boolean('status')->default(1);
            $table->integer('ncm')->nullable();
            $table->integer('altura')->nullable();
            $table->integer('largura')->nullable();
            $table->integer('comprimento')->nullable();
            $table->integer('peso')->nullable();
            $table->integer('acessos')->default(0);;
            $table->integer('vendidos')->nullable();
            $table->foreignId('departamento_id');
            $table->foreign('departamento_id')
                ->on('departamentos')
                ->references('id');
            $table->foreignId('categoria_id');
            $table->foreign('categoria_id')
                ->on('categorias')
                ->references('id');
            $table->foreignId('sub_categoria_id');
            $table->foreign('sub_categoria_id')
                ->on('sub_categorias')
                ->references('id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
