<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PatternUsageScope implements Scope
{
    /**
     * @var string
     */
    private string $patternUsage;

    /**
     * TypePatternUsageScope constructor.
     * @param $patternUsage
     */
    public function __construct($patternUsage)
    {
        $this->patternUsage = $patternUsage;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('patternUsage', $this->patternUsage);
    }

}
