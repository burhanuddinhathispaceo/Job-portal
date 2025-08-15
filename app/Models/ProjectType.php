<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
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
     * Get projects of this type
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Scope active project types
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
