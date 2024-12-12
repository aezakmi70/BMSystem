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
        'gender',
        'birthdate',
        'birthplace',
        'age',
        'address',
        'purok',
        'differently_abled_person',
        'marital_status',
        'bloodtype',
        'occupation',
        'monthly_income',
        'religion',
        'nationality',
        'philhealth_no',
        'resident_email',
        'contact_number',
        'resident_photo',
        'comment',
        'health_status',
        'youth_classification',
        'youth_age_group',
        'educational_background',
        'work_status',
        'is_registered_sk_voter',
        'did_vote_last_sk_election',
        'is_registered_national_voter',
        'vote_times',
        'has_attended_sk_assembly',
        'why_no_assembly',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

     public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname;
    }
    public function healthProfile()
    {
        return $this->hasOne(HealthProfile::class, 'resident_id');
    }
    public function healthServices()
{
    return $this->hasMany(HealthService::class, 'resident_id');
}
     
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
