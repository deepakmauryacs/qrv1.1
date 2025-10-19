<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'customer_name',
        'customer_email',
        'customer_contact',
        'subtotal',
        'discount_amount',
        'total_amount',
    ];

    public function items()
    {
        return $this->hasMany(PosOrderItem::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
