<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the parent industry
     */
    public function parent()
    {
        return $this->belongsTo(Industry::class, 'parent_id');
    }

    /**
     * Get the child industries
     */
    public function children()
    {
        return $this->hasMany(Industry::class, 'parent_id');
    }

    /**
     * Get companies in this industry
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Scope active industries
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
