<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pkid',
        'name',
        'description',
        'ucm_id',
    ];

    /**
     * @return BelongsTo
     */
    public function ucm(): BelongsTo
    {
        return $this->belongsTo(Ucm::class);
    }

    /**
     * @return BelongsToMany
     */
    public function callingSearchSpaces(): BelongsToMany
    {
        return $this->belongsToMany(CallingSearchSpace::class)->withPivot(['index']);
    }
}
