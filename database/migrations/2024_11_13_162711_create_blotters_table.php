<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlottersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blotters', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('yearRecorded', 4);
            $table->date('dateRecorded');
            $table->string('complainant', 255);
            $table->integer('cage');
            $table->string('caddress', 255);
            $table->string('ccontact', 15);
            $table->string('personToComplain', 255);
            $table->integer('page');
            $table->string('paddress', 255);
            $table->string('pcontact', 15);
            $table->text('complaint');
            $table->string('actionTaken', 50);
            $table->string('sStatus', 50);
            $table->string('locationOfIncidence', 255);
            $table->string('recordedby', 50);
            $table->timestamps(); // Optional: Adds `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blotters');
    }
}
