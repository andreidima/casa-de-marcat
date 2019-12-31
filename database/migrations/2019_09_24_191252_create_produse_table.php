<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subcategorie_produs_id')->nullable();
            $table->string('nume')->nullable();
            $table->decimal('pret_de_achizitie')->nullable();
            $table->decimal('pret')->nullable();
            $table->integer('cantitate')->nullable();
            $table->bigInteger('cod_de_bare')->nullable();
            $table->string('localizare')->nullable();
            $table->string('descriere')->nullable();

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
        Schema::dropIfExists('produse');
    }
}
