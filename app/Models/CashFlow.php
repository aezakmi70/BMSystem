<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;
    protected $table ='cash_flow';
    protected $fillable = ['date', 'transaction_type', 'amount', 'category', 'source', 'balance_after'];

    // Automatically calculate the balance after each transaction
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Calculate the balance after the transaction (assuming you track total balance somewhere)
            $lastBalance = CashFlow::latest('created_at')->first()->balance_after ?? 0;
            $model->balance_after = $lastBalance + $model->amount;
        });
    }
}

