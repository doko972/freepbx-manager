<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'number',
        'type',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec la société
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation avec les équipements
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * Accesseur pour formater le numéro
     */
    public function getFormattedNumberAttribute()
    {
        // Exemple : 0123456789 -> 01 23 45 67 89
        if (strlen($this->number) === 10 && substr($this->number, 0, 1) === '0') {
            return substr($this->number, 0, 2) . ' ' . 
                   substr($this->number, 2, 2) . ' ' . 
                   substr($this->number, 4, 2) . ' ' . 
                   substr($this->number, 6, 2) . ' ' . 
                   substr($this->number, 8, 2);
        }
        return $this->number;
    }
}