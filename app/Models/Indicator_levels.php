<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator_levels extends Model
{
    use HasFactory;
    protected $fillable = [
        'indicator_id',
        'score', // 1 sampai 4
        'behavior_description',
    ];
    public function indicator()
    {
        return $this->belongsTo(Indicators::class, 'indicator_id', 'id');
    }
}
