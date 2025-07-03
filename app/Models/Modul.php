<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;
    protected $fillable = [
        'tema_id',
        'judul',
        'deskripsi',
        'sampul',
    ];

    public function tema()
    {
        return $this->belongsTo(Tema::class,'tema_id','id');
    }

}
