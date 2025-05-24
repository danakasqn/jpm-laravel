<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CyclicFinance extends Model
{
    protected $table = 'cyclic_finances';

    protected $fillable = [
        'expense_type_id',
        'type',
        'due_day',
        'apartment_id',
        'amount',
    ];

    public function apartment()
    {
        return $this->belongsTo(Mieszkanie::class, 'apartment_id');
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    public function getKategoriaAttribute()
    {
        return $this->expenseType?->category;
    }

    public function getTypAttribute()
    {
        return $this->type;
    }
}
