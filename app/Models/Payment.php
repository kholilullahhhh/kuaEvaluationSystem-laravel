<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'siswa_id',
        'spp_id',
        'paid_at',
        'order_id',
        'paid_month',
        'paid_year',
        'amount',
        'status',
        'snap_token'


    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id', 'id');
    }

    public function spp()
    {
        return $this->belongsTo(SppPlan::class, 'spp_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->order_id)) {
                $model->order_id = 'PYMT-' . time() . '-' . rand(1000, 9999);
            }
        });
    }


}
