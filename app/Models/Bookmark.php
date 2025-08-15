<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bookmarkable_type',
        'bookmarkable_id',
        'folder',
        'notes',
    ];

    /**
     * Get the user that owns the bookmark
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bookmarkable item (job, project, candidate)
     */
    public function bookmarkable()
    {
        return $this->morphTo();
    }

    /**
     * Scope bookmarks by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('bookmarkable_type', $type);
    }

    /**
     * Scope bookmarks by folder
     */
    public function scopeInFolder($query, $folder)
    {
        return $query->where('folder', $folder);
    }
}
