<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_number',
        'station_id',
        'customer_id',
        'number'
    ];

    /**
     * Get the customer that owns the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the station that owns the card.
     */
    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * Get all of the discounts for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }
}
