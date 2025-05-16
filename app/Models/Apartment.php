<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $table = 'mieszkania';

    protected $fillable = [
        'miasto',
        'ulica',
        'metraz',
        'wspolnota',
        'telefon',
        'email',
    ];
}
