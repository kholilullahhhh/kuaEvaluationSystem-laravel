<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class performance_scores extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'periode',
        'kehadiran',
        'ketepatan_waktu',
        'laporan_kegiatan',
        'kelengkapan_laporan',
        'total_skor',
        'persentase',
        'keterangan',
        'total_absensi',
        'total_laporan',
        'total_laporan_lengkap',
    ];

    protected $casts = [
        'periode' => 'date',
    ];

    // Constants for performance ratings
    const SEMPURNA = 'Sempurna';
    const BAIK = 'Baik';
    const CUKUP = 'Cukup';
    const KURANG = 'Kurang';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensiRecords()
    {
        return $this->hasMany(Absensi::class, 'user_id', 'user_id')
            ->whereMonth('created_at', $this->periode->month)
            ->whereYear('created_at', $this->periode->year);
    }

    // Calculate total score based on all indicators
    public function calculateTotalScore()
    {
        return $this->kehadiran + $this->ketepatan_waktu +
            $this->laporan_kegiatan + $this->kelengkapan_laporan;
    }

    // Calculate performance percentage
    public function calculatePercentage()
    {
        $maxPossibleScore = 16; // 4 indicators * max score 4
        return ($this->total_skor / $maxPossibleScore) * 100;
    }

    // Determine performance category
    public function determineKeterangan()
    {
        if ($this->persentase >= 87.5) {
            return self::SEMPURNA;
        } elseif ($this->persentase >= 62.5) {
            return self::BAIK;
        } elseif ($this->persentase >= 37.5) {
            return self::CUKUP;
        } else {
            return self::KURANG;
        }
    }

    // Automatically set calculated fields when saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total_skor = $model->calculateTotalScore();
            $model->persentase = $model->calculatePercentage();
            $model->keterangan = $model->determineKeterangan();
        });
    }
}
