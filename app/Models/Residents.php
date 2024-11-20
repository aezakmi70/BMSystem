<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residents extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lastname',                // Last name of the resident
        'firstname',               // First name of the resident
        'middlename',              // Middle name of the resident
        'birthdate',               // Birthdate of the resident
        'birthplace',              // Birthplace of the resident
        'age',                     // Age of the resident
        'barangay',                // Barangay where the resident lives
        'purok',                   // Purok (area subdivision within a barangay)
        'differentlyabledperson',  // Differently-abled status (optional)
        'maritalstatus',           // Marital status of the resident
        'bloodtype',               // Blood type of the resident
        'occupation',              // Occupation of the resident
        'monthlyincome',           // Monthly income of the resident
        'religion',                // Religion of the resident
        'nationality',             // Nationality of the resident
        'gender',                  // Gender of the resident
        'philhealthNo',            // PhilHealth number

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // No sensitive data to hide, this can be customized if necessary
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // No need to cast fields for now
    ];
}
