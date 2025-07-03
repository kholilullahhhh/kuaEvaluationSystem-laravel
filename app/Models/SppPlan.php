<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'semester',
        'nominal',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
