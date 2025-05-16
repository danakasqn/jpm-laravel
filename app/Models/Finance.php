<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mieszkanie;

class Finance extends Model
{
    // Jeśli tabela nie nazywa się "finances", dodaj:
    // protected $table = 'finances';

    protected $fillable = [
        'user_id',
        'data',
        'apartment_id', // poprawnie zgodnie z kolumną w migracji
        'typ',
        'kwota',
        'kategoria',
        'notatka',
    ];

    /**
     * Relacja z tabelą mieszkań.
     */
    public function apartment()
    {
        return $this->belongsTo(Mieszkanie::class, 'apartment_id');
    }
}
