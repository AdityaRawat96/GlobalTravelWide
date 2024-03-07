<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('cascade');
            $table->foreignId('refund_id')->nullable()->constrained('refunds')->onDelete('cascade');
            $table->foreignId('expense_id')->nullable()->constrained('expenses')->onDelete('cascade');
            $table->foreignId('notification_id')->nullable()->constrained('notifications')->onDelete('cascade');
            $table->foreignId('directory_id')->nullable()->constrained('directory_contents')->onDelete('cascade');
            $table->string('name');
            $table->string('path');
            $table->string('extension');
            $table->string('mime_type');
            $table->string('size');
            $table->string('url');
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
        Schema::dropIfExists('attachments');
    }
}
