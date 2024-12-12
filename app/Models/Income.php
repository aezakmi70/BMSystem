<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $table = 'income_tbl';


    protected $fillable = [
        'transaction_date',
        'amount',
        'description',
        'payer',
        'recorded_by',
        'payment_method',
        'receipt_number',
    ];

    public function official()
    {
        return $this->belongsTo(Official::class, 'resident_id');
    }
}
