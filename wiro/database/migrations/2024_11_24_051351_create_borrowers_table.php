<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();

            //personal info
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('whatsapp_number');
            $table->string('other_number')->nullable();
            $table->string('email');


             // Residential Information
             $table->text('present_address');
             $table->enum('address_type', ['rented', 'owned']);
             $table->string('landmark')->nullable();
             $table->string('district_of_residence');
             $table->string('country');
             $table->integer('years_in_residence');
             
             // Business/Employment Information
             $table->string('business_name');
             $table->string('role');
             $table->enum('status', ['employed', 'business_owner', 'student']);
             $table->string('industry_of_business')->nullable();
             $table->text('business_address')->nullable();
             $table->string('business_email')->nullable();
             $table->string('business_contact_person')->nullable();
             $table->string('business_contact')->nullable();
             $table->string('business_district')->nullable();
             $table->string('business_country')->nullable();
             
             // Next of Kin Information
             $table->string('next_of_kin_name');
             $table->string('next_of_kin_relationship');
             $table->string('next_of_kin_mobile');
             $table->string('next_of_kin_email')->nullable();
             $table->text('next_of_kin_address');
             $table->string('next_of_kin_country');
             $table->string('next_of_kin_district');
             $table->string('next_of_kin_city');

             // system fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowers');
    }
};
