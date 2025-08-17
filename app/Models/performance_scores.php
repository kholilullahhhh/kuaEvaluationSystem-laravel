<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class performance_scores extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'indicator_id',
        'total_skor',
        'persentase',
        'keterangan',
    ];
    public function indicator()
    {
        return $this->belongsTo(Indicators::class, 'indicator_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
