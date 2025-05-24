<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'imie_nazwisko',
        'wynajmujacy',       // ✅ dodane
        'apartment_id',
        'od_kiedy',
        'do_kiedy',
        'komentarz',
        'email',
        'phone',
        'status',            // 💡 jeśli jest używane w aplikacji
    ];

    protected $dates = [
        'od_kiedy',
        'do_kiedy',
    ];

    public function apartment()
    {
        return $this->belongsTo(\App\Models\Mieszkanie::class, 'apartment_id');
    }
}
