<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'thumbnail',
        'judul',
        'tempat_kegiatan',
        'tgl_kegiatan',
        'tgl_selesai',
        'jam_mulai',
        'jam_selesai',
        'tgl_publish',
        'deskripsi_kegiatan',
        'status', //aktif tidaknya kegitan itu
    ];
}
