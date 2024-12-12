<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProfile extends Model
{
    use HasFactory;
    protected $table = 'health_profiles_tbl';
    protected $fillable = [
        'resident_id',
        'blood_type',
        'allergies',
        'medical_conditions',
    ];

    public function resident()
    {
        return $this->belongsTo(Residents::class, 'resident_id');
    }

    public function healthServices()
    {
        return $this->hasMany(HealthService::class, 'resident_id', 'resident_id');
    }
}
