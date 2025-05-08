<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Station extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'district_id',
        'created_by',
        'validated_by'
    ];

    /**
     * Configure les options pour la journalisation d'activité
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'district_id', 'validated_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('station');
    }

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
