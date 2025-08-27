<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec les sociétés
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Relation avec les sociétés principales uniquement
     */
    public function mainCompanies()
    {
        return $this->hasMany(Company::class)->where('type', 'main')->whereNull('parent_id');
    }

    /**
     * Compte le nombre total d'équipements
     */
    public function getTotalEquipmentCountAttribute()
    {
        return $this->companies->sum(function ($company) {
            return $company->getAllEquipmentCount();
        });
    }

    /**
     * Compte le nombre total d'extensions
     */
    public function getTotalExtensionsCountAttribute()
    {
        return $this->companies->sum(function ($company) {
            return $company->getAllExtensionsCount();
        });
    }

    /**
     * Compte le nombre total de numéros de téléphone
     */
    public function getTotalPhoneNumbersCountAttribute()
    {
        return $this->companies->sum(function ($company) {
            return $company->getAllPhoneNumbersCount();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
