<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    use HasFactory;

    protected $table = 'expense_types';

    protected $fillable = [
        'name',     // "Przychód" lub "Wydatek"
        'category', // np. "Czynsz najmu", "Media"
        'taxable',  // czy wliczać do podatku
    ];

    public $timestamps = false;

    /**
     * Relacja: ten typ ma wiele wpisów finansowych.
     */
    public function finances()
    {
        return $this->hasMany(Finance::class, 'expense_type_id');
    }

    /**
     * Relacja: ten typ ma wiele cyklicznych wpisów.
     */
    public function cyclicFinances()
    {
        return $this->hasMany(CyclicFinance::class, 'expense_type_id');
    }
}
