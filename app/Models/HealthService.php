<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthService extends Model
{
    use HasFactory;
    protected $table = 'health_services_tbl';
    protected $fillable = [

        'resident_id',
        'service_date',
        'service_type',
        'description',
        'provided_by',
        'status',
    ];

    public function resident()
    {
        return $this->belongsTo(Residents::class, 'resident_id');
    }
    public function healthProfile()
    {
        return $this->belongsTo(HealthProfile::class, 'resident_id', 'resident_id');
    }
}
