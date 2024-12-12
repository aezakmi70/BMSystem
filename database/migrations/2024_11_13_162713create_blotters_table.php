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
        Schema::create('blotter_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_to_complain_id')->nullable();
            $table->string('person_to_complain_name')->nullable();
            $table->string('person_to_complain_address')->nullable();
            $table->integer('person_to_complain_age')->nullable();
            $table->boolean('person_to_complain_is_non_resident')->default(false); // Checkbox field
            $table->unsignedBigInteger('complainant_id')->nullable();
            $table->string('complainant_name')->nullable();
            $table->string('complainant_address')->nullable();
            $table->integer('complainant_age')->nullable();
            $table->boolean('complainant_is_non_resident')->default(false); // Checkbox field
            $table->unsignedBigInteger('respondent_id')->nullable();
            $table->string('respondent_name')->nullable();
            $table->date('incident_date');
            $table->string('incident_location');
            $table->text('incident_details');
            $table->string('recorded_by')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });

        Schema::create('clearance_tbl', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('resident_name');
            $table->unsignedBigInteger('residentid');
            $table->integer('resident_age')->unsigned();  // Ensure this is an integer
            $table->date('resident_birthdate');
            $table->text('certificate_to_issue');
            $table->text('purpose');
            $table->integer('or_no');
            $table->integer('samount');
            $table->date('date_recorded');
            $table->string('recorded_by', 50);
            $table->string('status', 20);
            $table->text('business_name')->nullable();
            $table->text('business_address')->nullable();
            $table->string('type_of_business', 50)->nullable();
            $table->string('present_official');
            $table->string('official_position');
            $table->timestamps(); 

            // Foreign key relationships
            $table->foreign('residentid')
                ->references('id') 
                ->on('resident_tbl')  
                ->onDelete('cascade'); 


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blotter_tbl');
        Schema::dropIfExists('clearance_tbl');
    }
};
