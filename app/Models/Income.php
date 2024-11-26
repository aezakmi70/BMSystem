<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    /**
     
     * @var array<int, string>
     */
    protected $table = 'clearance_tbl';
    protected $fillable = [
        'residentid',
        'residentName',
        'findings',
        'purpose',
        'orNo',
        'samount',
        'dateRecorded',
        'recordedBy',
        'status',
    ];

    public function getResidentNameAttribute()
{
    // Assuming the 'resident' relationship is defined, concatenate the first, middle, and last names.
    return $this->resident ? "{$this->resident->firstname} {$this->resident->middlename} {$this->resident->lastname}" : null;
}
public function resident()
{
    return $this->belongsTo(Residents::class, 'residentid'); 
}
        protected $casts = [
        'dateRecorded' => 'datetime',
    ];
    public function income()
{
    return $this->hasOne(Income::class);
}
    
}
