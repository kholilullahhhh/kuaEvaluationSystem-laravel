<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', // ID pengguna yang membuat agenda
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function report()
    // {
    //     return $this->hasOne(Report::class);
    // }
}
