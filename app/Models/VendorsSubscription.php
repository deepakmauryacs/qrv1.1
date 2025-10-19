<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorsSubscription extends Model
{
    use HasFactory;

    // Add the fillable properties
    protected $fillable = [
        'vendor_id',
        'subscription_id',
        'month',
        'start_date',
        'end_date',
        'is_expired',
    ];

    // You can also define relationships here if needed
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
