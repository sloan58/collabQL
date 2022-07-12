<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ClassScope implements Scope
{
    /**
     * @var string
     */
    private string $class;

    /**
     * TypeClassScope constructor.
     * @param $class
     */
    public function __construct($class)
    {
        $this->class = $class;
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
        $builder->where('class', $this->class);
    }

}
