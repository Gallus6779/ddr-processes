<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'district_id'
    ];

    /**
     * Get the district associated with the DiscountPeriod
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function district(): HasOne
    {
        return $this->hasOne(District::class);
    }
}
