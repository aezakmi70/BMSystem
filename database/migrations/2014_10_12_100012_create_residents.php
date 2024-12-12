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
            $table->id();  // This automatically creates the primary key and sets it to AUTO_INCREMENT.
            $table->string('lastname', 50);
            $table->string('firstname', 50);
            $table->string('middlename', 50)->nullable();
            $table->string('gender', 10);
            $table->date('birthdate');
            $table->text('birthplace');
            $table->integer('age')->unsigned();
            $table->string('address', 120);
            $table->integer('purok');
            $table->string('differently_abled_person', 15)->nullable();
            $table->string('marital_status', 20)->nullable();
            $table->string('bloodtype', 15)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('monthly_income', 20)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('nationality', 50);
            $table->string('national_id', 20)->nullable();  // Remove AUTO_INCREMENT from this column
            $table->string('philhealth_no', 20)->nullable();
            $table->string('resident_email', 100)->nullable()->unique();
            $table->string('contact_number', 20)->nullable();
            $table->string('resident_photo')->nullable();
            $table->string('comment', 255)->nullable();
            $table->enum('health_status', ['Healthy', 'Sick', 'Recovered'])->default('Healthy');
        
            // Youth Information
            $table->string('youth_classification', 50)->nullable();
            $table->string('youth_age_group', 50)->nullable();
            $table->string('educational_background', 255)->nullable();
            $table->string('work_status', 30)->nullable();
            $table->string('is_registered_sk_voter', 10)->nullable();
            $table->string('did_vote_last_sk_election', 10)->nullable();
            $table->string('is_registered_national_voter', 10)->nullable();
            $table->string('vote_times', 20)->nullable();
            $table->string('has_attended_sk_assembly', 10)->nullable();
            $table->text('why_no_assembly')->nullable();
        
            $table->timestamps();
        });
        

        Schema::create('official_tbl', function (Blueprint $table) {
            $table->id(); // This defaults to an unsigned bigint as primary key
            $table->string('position', 50);
            $table->unsignedBigInteger('resident_id');
            $table->date('term_start');
            $table->date('term_end');
            $table->string('status', 20);
            $table->timestamps(); 
      

            $table->foreign('resident_id')
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
        Schema::dropIfExists('resident_tbl');
        Schema::dropIfExists('official_tbl');
    }
};

