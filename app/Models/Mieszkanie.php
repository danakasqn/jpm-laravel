<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mieszkanie extends Model
{
    use HasFactory;

    // ✅ Jawna nazwa tabeli
    protected $table = 'mieszkania';

    // ✅ Pola do masowego wypełniania
    protected $fillable = [
        'miasto',
        'ulica',
        'metraz',
        'wspolnota',
        'telefon',
        'email',
        'adres',
        'wlasciciel', // ✅ Imię i nazwisko właściciela
        'notatka',
    ];

    // ✅ Relacja: jedno mieszkanie ma wielu najemców
    public function residents()
    {
        return $this->hasMany(\App\Models\Resident::class, 'apartment_id');
    }

    // ✅ Relacja: jedno mieszkanie ma wiele cyklicznych wpisów
    public function cyclicFinances()
    {
        return $this->hasMany(\App\Models\CyclicFinance::class, 'apartment_id');
    }

    // ✅ Wirtualny atrybut pełnego adresu
    public function getAdresAttribute()
    {
        return "{$this->miasto}, {$this->ulica}";
    }
}
