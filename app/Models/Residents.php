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
    protected $table = 'resident_tbl';
    protected $fillable = [
        'lastname',              
        'firstname',             
        'middlename',            
        'birthdate',           
        'birthplace',              
        'age',   
        'contactNumber',            
        'barangay',              
        'purok',                   
        'differentlyabledperson', 
        'maritalstatus',           
        'bloodtype',               
        'occupation',              
        'monthlyincome',           
        'religion',                
        'nationality',             
        'gender',                 
        'philhealthNo',           

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
