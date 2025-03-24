<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'card_id',
        'wallet_id',
        'quantity',
        'date_consumption'
    ]

    /**
     * Get the customer that owns the Consumption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the card that owns the Consumption
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    /**
     * Get the wallet associated with the Consumption
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

}
