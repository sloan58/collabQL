<?php

namespace App\Models;

use App\Models\Scopes\ClassScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Phone extends Device
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
            new ClassScope('Phone')
        );
    }
}
