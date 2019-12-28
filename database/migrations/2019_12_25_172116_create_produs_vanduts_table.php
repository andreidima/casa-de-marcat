<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdusVandutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produse_vandute', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produs_id');
            $table->integer('cantitate')->nullable();
            $table->decimal('pret')->nullable();
            
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
        Schema::dropIfExists('produse_vandute');
    }
}
