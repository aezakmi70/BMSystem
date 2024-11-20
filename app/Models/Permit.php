<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tblpermit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'residentid',
        'businessName',
        'businessAddress',
        'typeOfBusiness',
        'orNo',
        'samount',
        'dateRecorded',
        'recordedBy',
        'status',
    ];
}
