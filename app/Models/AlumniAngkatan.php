<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniAngkatan extends Model
{
    protected $table = 'alumni_angkatan';

    protected $fillable = [
        'tahun_lulus',
        'nama_angkatan',
        'nomor_angkatan',
        'persen_ptn',
        'persen_pts',
        'persen_ptln',
        'persen_kedinasan',
        'flyer_image',
        'catatan',
        'is_highlighted',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'persen_ptn' => 'decimal:2',
        'persen_pts' => 'decimal:2',
        'persen_ptln' => 'decimal:2',
        'persen_kedinasan' => 'decimal:2',
        'is_highlighted' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scope: only active angkatan
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered by sort_order then tahun_lulus desc
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('tahun_lulus', 'desc');
    }

    /**
     * Get the flyer image URL
     */
    public function getFliyerUrlAttribute()
    {
        if ($this->flyer_image) {
            return \Illuminate\Support\Facades\Storage::url($this->flyer_image);
        }
        return null;
    }

    /**
     * Get formatted roman numeral for angkatan
     */
    public static function toRoman($number)
    {
        $map = [
            1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD',
            100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL',
            10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I',
        ];
        $result = '';
        foreach ($map as $value => $numeral) {
            while ($number >= $value) {
                $result .= $numeral;
                $number -= $value;
            }
        }
        return $result;
    }
}
