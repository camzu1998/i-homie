<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot(['status', 'last_viewed_entry_id']);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function duties(): HasMany
    {
        return $this->hasMany(Duty::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }
}
