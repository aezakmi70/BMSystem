<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlotterRecords extends Model
{
    use HasFactory;

    protected $table = 'blotter_tbl'; 

    protected $fillable = [

        'dateRecorded',
        'complainant',
        'cage',
        'caddress',
        'ccontact',
        'personToComplain',
        'page',
        'paddress',
        'pcontact',
        'complaint',
        'actionTaken',
        'sStatus',
        'locationOfIncidence',
        'recordedby',
    ];
}
