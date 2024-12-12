<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
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
    public function down(): void
    {
        Schema::dropIfExists('clearance_tbl');
    }
};
