<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('quotation_id')->unique();
            $table->string('ref_number')->nullable();
            $table->integer('company_id');
            $table->integer('customer_id');
            $table->float('cost_price');
            $table->float('selling_price');
            $table->float('revenue');
            $table->date('quotation_date');
            $table->longText('notes')->nullable();
            $table->longText('attachments')->nullable();
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
        Schema::dropIfExists('quotations');
    }
}
