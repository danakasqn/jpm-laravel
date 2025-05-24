<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
    'data',
    'apartment_id',
    'wynajmujacy', // ← dodaj to
    'typ',
    'kwota',
    'expense_type_id',
    'notatka',
    'user_id',
    'status',
];


    public function apartment()
    {
        return $this->belongsTo(Mieszkanie::class);
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    public function getKategoriaAttribute()
    {
        return $this->expenseType?->category;
    }
}
