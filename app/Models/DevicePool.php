<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevicePool extends Model
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
        'ucm_id',
        'partition_id',
    ];

    /**
     * @return BelongsTo
     */
    public function ucm(): BelongsTo
    {
        return $this->belongsTo(Ucm::class);
    }
}
