<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Mieszkanie;

class Finance extends Model
{
    use HasFactory;

    // Jeśli tabela nazywa się inaczej niż domyślna (czyli "finances"), odkomentuj poniższe:
    // protected $table = 'finances';

    protected $fillable = [
        'user_id',
        'data',
        'apartment_id', // poprawne pole powiązania
        'typ',
        'kwota',
        'kategoria',
        'notatka',
    ];

    /**
     * Relacja: jedno finansowanie należy do jednego mieszkania.
     */
    public function apartment()
    {
        return $this->belongsTo(Mieszkanie::class, 'apartment_id');
    }
}
