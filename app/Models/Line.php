<?php

namespace App\Models;

use App\Models\Scopes\PatternUsageScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Line extends Numplan
{
    use HasFactory;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope(
            new PatternUsageScope('Device')
        );
    }
}
