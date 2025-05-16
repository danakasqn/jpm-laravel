<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mieszkanie extends Model
{
    use HasFactory;

    // ✅ jawna nazwa tabeli
    protected $table = 'mieszkania';

    protected $fillable = [
        'miasto',
        'ulica',
        'metraz',
        'wspolnota',
        'telefon',
        'email',
        'adres',    // ← dodane!
        'notatka',
    ];

    // ✅ Relacja: jedno mieszkanie ma wielu mieszkańców
    public function residents()
    {
        return $this->hasMany(Resident::class, 'apartment_id');
    }

    // ✅ Relacja: jedno mieszkanie ma wiele cyklicznych wpisów
    public function cyclicFinances()
    {
        return $this->hasMany(CyclicFinance::class, 'apartment_id');
    }

    // ✅ Wirtualny atrybut adresu
    public function getAdresAttribute()
    {
        return "{$this->miasto}, {$this->ulica}";
    }
}
