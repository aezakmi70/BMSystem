<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Official extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'official_tbl';
    protected $fillable = [
        'position',
        'completeName',
        'email',
        'contactNumber', 
        'address',
        'termStart',
        'termEnd',
        'status',
        'password', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}