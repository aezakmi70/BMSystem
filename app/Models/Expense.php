<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expense_tbl';

    protected $fillable = [
        'transaction_date',
        'category',
        'amount',
        'description',
        'paid_to',
        'payment_method',
        'receipt_number',
    ];
}
