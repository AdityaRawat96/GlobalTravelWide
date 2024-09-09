<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('ref_id');
            $table->foreignId('catalogue_id');
            $table->integer('quantity');
            $table->double('cost', 20, 2);
            $table->double('price', 20, 2);
            $table->double('revenue', 20, 2);
            $table->string('currency')->default('gbp');
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
        Schema::dropIfExists('products');
    }
}