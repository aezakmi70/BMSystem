<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resident_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('lastname', 20);           // Last name of the resident
            $table->string('firstname', 20);          // First name of the resident
            $table->string('middlename', 20);         // Middle name of the resident
            $table->string('birthdate', 20);          // Birthdate (consider changing to DATE type if needed)
            $table->text('birthplace');               // Birthplace of the resident
            $table->integer('age');                   // Age of the resident
            $table->string('barangay', 120);          // Barangay where the resident lives
            $table->integer('purok');               // Purok (smaller subdivision in a barangay)
            $table->string('differentlyabledperson', 100)->nullable();  // Differently-abled status
            $table->string('maritalstatus', 50);      // Marital status
            $table->string('bloodtype', 10);          // Blood type
            $table->string('occupation', 100);        // Occupation of the resident
            $table->string('monthlyincome'); // Monthly income
            $table->string('religion', 50)->nullable();  // Religion of the resident
            $table->string('nationality', 50);        // Nationality of the resident
            $table->string('gender', 6);              // Gender of the resident
            $table->integer('igpitID')->nullable();   // IGPT ID (if applicable)
            $table->string('philhealthNo')->length(12)->nullable();   // PhilHealth number
            $table->string('contactNumber')->length(11);   // contact number
            $table->timestamps();                     // Created at / Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resident_tbl');
    }
};
