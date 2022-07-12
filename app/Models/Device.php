<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Device extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'devices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pkid',
        'name',
        'description',
        'model',
        'class',
        'ipAddress',
        'status',
        'registeredWith',
        'protocol',
        'activeLoad',
        'inactiveLoad',
        'device_pool_id',
        'calling_search_space_id',
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
     * @return BelongsTo
     */
    public function devicePool(): BelongsTo
    {
        return $this->belongsTo(DevicePool::class);
    }

    /**
     * @return BelongsTo
     */
    public function callingSearchSpace(): BelongsTo
    {
        return $this->belongsTo(CallingSearchSpace::class);
    }

    /**
     * @return BelongsToMany
     */
    public function numplans(): BelongsToMany
    {
        return $this->belongsToMany(
            Numplan::class,
            'device_numplan',
            'device_id',
            'numplan_id'
        )->withPivot(['pkid', 'numplanindex']);
    }

    /**
     * @return BelongsToMany
     */
    public function lines(): BelongsToMany
    {
        return $this->belongsToMany(
            Line::class,
            'device_numplan',
            'device_id',
            'numplan_id'
        )->withPivot(['pkid', 'numplanindex']);
    }
}
