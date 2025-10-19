<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiningOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vendor_id',
        'order_id',
        'customer_name',
        'order_type',
        'contact_no',
        'email',
        'table_number',
        'order_date',
        'order_time',
        'total_amount',
        'status',
        'payment_status',
        'payment_method',
        'special_request',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order_date' => 'date',
        'order_time' => 'datetime:H:i:s',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the items associated with the dining order.
     */
    public function items()
    {
        return $this->hasMany(DiningOrderItem::class);
    }
}
