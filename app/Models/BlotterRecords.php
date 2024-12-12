<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlotterRecords extends Model
{
    use HasFactory;

    protected $table = 'blotter_records'; // Specify the table name if it's not the pluralized version of the model name.

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'person_to_complain_id',
        'person_to_complain_name',
        'person_to_complain_address',
        'person_to_complain_age',
        'person_to_complain_is_non_resident',
        'complainant_id',
        'complainant_name',
        'complainant_address',
        'complainant_age',
        'complainant_is_non_resident',
        'respondent_id',
        'respondent_name',
        'incident_date',
        'incident_location',
        'incident_details',
        'recorded_by',
        'blotter_status',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'incident_date' => 'date',
        'status' => 'string',
    ];
    





    
    /**
     * 
     * Define relationships if needed.
     */
    public function complainant()
    {
        return $this->belongsTo(Residents::class, 'complainant_id');
    }

    public function personToComplain()
    {
        return $this->belongsTo(Residents::class, 'person_to_complain_id');
    }

    public function respondent()
    {
        return $this->belongsTo(Residents::class, 'respondent_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(Official::class, 'recorded_by_id');
    }
}
