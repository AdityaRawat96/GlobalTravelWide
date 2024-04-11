<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->string('refund_id')->unique();
            $table->string('ref_number')->nullable();
            $table->integer('company_id');
            $table->integer('customer_id');
            $table->integer('affiliate_id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->date('refund_date');
            $table->date('due_date');
            $table->float('total');
            $table->float('revenue');
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
        Schema::dropIfExists('refunds');
    }
}
