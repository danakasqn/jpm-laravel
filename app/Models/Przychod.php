<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Przychod extends Model
{
    use HasFactory;

    protected $fillable = ['opis', 'kwota', 'user_id'];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
    protected $table = 'przychody';
}
