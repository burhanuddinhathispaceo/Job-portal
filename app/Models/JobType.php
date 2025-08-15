<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get jobs of this type
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Scope active job types
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
