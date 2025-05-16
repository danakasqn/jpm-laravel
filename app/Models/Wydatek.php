<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wydatek extends Model
{
    use HasFactory;

    protected $fillable = ['opis', 'kwota', 'user_id'];

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
    // 👇 dodaj to:
    protected $table = 'wydatki';
    
}
