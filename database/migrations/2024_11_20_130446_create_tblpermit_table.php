<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tblpermit', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->unsignedBigInteger('residentid');
            $table->text('businessName');
            $table->text('businessAddress');
            $table->string('typeOfBusiness', 50);
            $table->integer('orNo');
            $table->integer('samount');
            $table->date('dateRecorded');
            $table->string('recordedBy', 50);
            $table->string('status', 20);
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblpermit');
    }
};
