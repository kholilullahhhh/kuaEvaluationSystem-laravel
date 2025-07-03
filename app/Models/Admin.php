<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'spp_id',
        'class_id',
        'name',
        'nisn',
        'nis',
        'address',
        'no_hp',
        'username',
        'password',
        'role'
    ];
}
