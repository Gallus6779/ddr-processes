<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'customer_type_id'
    ];

    /**
     * Get the customer_type associated with the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer_type(): HasOne
    {
        return $this->hasOne(CustomerType::class);
    }

    /**
     * Get all of the cards for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
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
