<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlotterRecords extends Model
{
    use HasFactory;

    protected $table = 'blotters'; 

    protected $fillable = [
        'dateRecorded',
        'complainant',
        'sStatus'
    ];
}
