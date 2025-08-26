<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number_id',
        'name',
        'type',
        'extension',
        'user_name',
        'mac_address',
        'configuration',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'configuration' => 'array',
    ];

    /**
     * Relation avec le numéro de téléphone
     */
    public function phoneNumber()
    {
        return $this->belongsTo(PhoneNumber::class);
    }

    /**
     * Types d'équipements disponibles
     */
    public static function getEquipmentTypes()
    {
        return [
            'Téléphone fixe' => '☎️',
            'Téléphone sans fil' => '📞',
            'Application mobile' => '📱',
            'Application desktop' => '💻',
            'Softphone' => '🎧',
            'Téléphone IP' => '🖥️',
            'Poste analogique' => '📠',
            'Casque Bluetooth' => '🎤',
        ];
    }

    /**
     * Accesseur pour l'icône
     */
    public function getIconAttribute()
    {
        $types = self::getEquipmentTypes();
        return $types[$this->type] ?? '🔧';
    }

    /**
     * Accesseur pour le nom complet avec extension
     */
    public function getFullNameAttribute()
    {
        $name = $this->type;
        if ($this->extension) {
            $name .= " ({$this->extension})";
        }
        if ($this->user_name) {
            $name .= " - {$this->user_name}";
        }
        return $name;
    }

    /**
     * Scope pour les équipements avec extension
     */
    public function scopeWithExtension($query)
    {
        return $query->whereNotNull('extension');
    }

    /**
     * Scope pour les équipements actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}