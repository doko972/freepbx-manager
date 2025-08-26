<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'centrex_ip',
        'type',
        'parent_id',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec le client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relation avec la société parente
     */
    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_id');
    }

    /**
     * Relation avec les filiales
     */
    public function subsidiaries()
    {
        return $this->hasMany(Company::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Relation avec les numéros de téléphone
     */
    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    /**
     * Compte récursif des équipements
     */
    public function getAllEquipmentCount()
    {
        $count = $this->phoneNumbers->sum(function ($phone) {
            return $phone->equipment->count();
        });
        
        foreach ($this->subsidiaries as $subsidiary) {
            $count += $subsidiary->getAllEquipmentCount();
        }
        
        return $count;
    }

    /**
     * Compte récursif des extensions
     */
    public function getAllExtensionsCount()
    {
        $count = $this->phoneNumbers->sum(function ($phone) {
            return $phone->equipment->whereNotNull('extension')->count();
        });
        
        foreach ($this->subsidiaries as $subsidiary) {
            $count += $subsidiary->getAllExtensionsCount();
        }
        
        return $count;
    }

    /**
     * Compte récursif des numéros de téléphone
     */
    public function getAllPhoneNumbersCount()
    {
        $count = $this->phoneNumbers->count();
        
        foreach ($this->subsidiaries as $subsidiary) {
            $count += $subsidiary->getAllPhoneNumbersCount();
        }
        
        return $count;
    }

    /**
     * Génère l'arbre hiérarchique complet
     */
    public function getHierarchyTree()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'centrex_ip' => $this->centrex_ip,
            'phone_numbers' => $this->phoneNumbers->map(function ($phone) {
                return [
                    'id' => $phone->id,
                    'number' => $phone->number,
                    'type' => $phone->type,
                    'description' => $phone->description,
                    'equipment' => $phone->equipment->map(function ($equipment) {
                        return [
                            'id' => $equipment->id,
                            'name' => $equipment->name,
                            'type' => $equipment->type,
                            'extension' => $equipment->extension,
                            'user_name' => $equipment->user_name,
                            'mac_address' => $equipment->mac_address,
                        ];
                    })
                ];
            }),
            'subsidiaries' => $this->subsidiaries->map(function ($subsidiary) {
                return $subsidiary->getHierarchyTree();
            })
        ];
    }
}
