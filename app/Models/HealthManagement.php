<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthManagement extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'health_management';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'residentid',
        'blood_type',
        'allergies',
        'medical_conditions',
        'vaccination_history',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'vaccination_history' => 'array', // Automatically handle JSON to array conversion
    ];

    /**
     * Define a relationship to the Resident model.
     */
    public function resident()
    {
        return $this->belongsTo(Residents::class, 'residentid');
    }
}
