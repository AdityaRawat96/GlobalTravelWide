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
            $table->foreignId('user_id')->constrained('users');
            $table->date('payment_date');
            $table->date('departure_date');
            $table->float('total');
            $table->float('revenue');
            $table->date('invoice_date');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('invoices');
    }
}