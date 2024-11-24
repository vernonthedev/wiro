<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Borrowers extends Model
{
    use HasFactory, AsSource;


    protected $fillable = [
        // Personal Information
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'whatsapp_number',
        'other_number',
        'email',
        
        // Residential Information
        'present_address',
        'address_type',
        'landmark',
        'district_of_residence',
        'country',
        'years_in_residence',
        
        // Business/Employment Information
        'business_name',
        'role',
        'status',
        'industry_of_business',
        'business_address',
        'business_email',
        'business_contact_person',
        'business_contact',
        'business_district',
        'business_country',
        
        // Next of Kin Information
        'next_of_kin_name',
        'next_of_kin_relationship',
        'next_of_kin_mobile',
        'next_of_kin_email',
        'next_of_kin_address',
        'next_of_kin_country',
        'next_of_kin_district',
        'next_of_kin_city',
    ];
}
