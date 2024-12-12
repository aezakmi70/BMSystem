<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

   
    //
            Schema::create('income_tbl', function (Blueprint $table) {
                $table->id();
                $table->date('transaction_date');
                $table->string('payer', 100);
                $table->decimal('amount', 10, 2);
                $table->text('description');
                $table->string('payment_method', 50)->nullable();
                $table->timestamps();
                $table->string('receipt_number', 50)->nullable();
            });

            //
            Schema::create('expense_tbl', function (Blueprint $table) {
                $table->id();
                $table->date('transaction_date');
                $table->string('category', 100);
                $table->decimal('amount', 10, 2);
                $table->text('description');
                $table->string('paid_to', 100);
                $table->timestamps();
                $table->String('payment_method')->nullable();
                $table->string('receipt_number', 50)->nullable();
            });

            //
            Schema::create('barangay_budget', function (Blueprint $table) {
                $table->id();
                $table->string('category', 100);
                $table->decimal('allocated_amount', 10, 2);
                $table->decimal('spent_amount', 10, 2)->default(0);
                $table->decimal('remaining_amount', 10, 2)->default(0);
                $table->timestamps();
            });

            //
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->string('table_name', 100);
                $table->integer('record_id');
                $table->text('changes');
                $table->string('changed_by', 50);
                $table->timestamps();
            });

      
    }

    public function down()
    {

        Schema::dropIfExists('income_tbl');
        Schema::dropIfExists('expense_tbl');
        Schema::dropIfExists('barangay_budget');

        Schema::dropIfExists('audit_logs');

    }
};
