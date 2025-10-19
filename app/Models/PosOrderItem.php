<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pos_order_id',
        'vendor_menu_id',
        'item_name',
        'unit_price',
        'quantity',
        'line_total',
    ];

    public function order()
    {
        return $this->belongsTo(PosOrder::class, 'pos_order_id');
    }

    public function vendorMenu()
    {
        return $this->belongsTo(VendorMenu::class);
    }
}
