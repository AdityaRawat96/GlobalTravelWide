<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->string('ref_number')->nullable();
            $table->integer('company_id');
            $table->integer('customer_id');
            $table->integer('affiliate_id')->nullable();
            $table->integer('carrier_id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->date('due_date');
            $table->date('departure_date')->nullable();
            $table->double('commission', 20, 2)->nullable();
            $table->double('total', 20, 2);
            $table->double('revenue', 20, 2);
            $table->date('invoice_date');
            $table->string('currency')->default('gbp');
            $table->string('status')->default('pending');
            $table->longText('notes')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}