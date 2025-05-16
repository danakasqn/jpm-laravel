<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Mieszkanie;

class CyclicFinance extends Model
{
    protected $table = 'cyclic_finances';

    protected $fillable = [
        'title',
        'type',
        'due_day',
        'apartment_id',
    ];

    public function apartment()
    {
        return $this->belongsTo(Mieszkanie::class, 'apartment_id');
    }
}
