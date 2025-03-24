<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Station extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district_id',
        'created_by',
        'validated_by'
    ];

    /**
     * Get the user that owns the District
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Get the user that owns the District
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validatedBy(): HasOne
    {
        return $this->HasOne(User::class,  'id', 'validated_by');
    }

    /**
     * Get the district that owns the Station
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
