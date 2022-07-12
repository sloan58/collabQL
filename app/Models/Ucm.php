<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ucm extends Model
{
    use HasFactory;

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot([
            'pkid', 'userId', 'serviceProfile', 'homeCluster'
        ]);
    }

    /**
     * @return HasMany
     */
    public function partitions(): HasMany
    {
        return $this->hasMany(Partition::class);
    }

    /**
     * @return HasMany
     */
    public function callingSearchSpaces(): HasMany
    {
        return $this->hasMany(CallingSearchSpace::class);
    }

    /**
     * @return HasMany
     */
    public function devicePools(): HasMany
    {
        return $this->hasMany(DevicePool::class);
    }

    /**
     * @return HasMany
     */
    public function numplans(): HasMany
    {
        return $this->hasMany(Numplan::class);
    }

    /**
     * @return HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(Line::class);
    }

    /**
     * @return HasMany
     */
    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }
}
