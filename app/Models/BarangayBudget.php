<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayBudget extends Model
{
    use HasFactory;
    protected $table = 'barangay_budget';
    protected $fillable = ['category', 'allocated_amount', 'spent_amount', 'remaining_amount'];

    // Automatically calculate remaining amount when creating or updating
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->remaining_amount = $model->allocated_amount - $model->spent_amount;
        });
    }
}
