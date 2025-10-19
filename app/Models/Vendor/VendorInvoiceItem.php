<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'vendor_id', 'item_id', 'item_name', 'type', 'price', 'quantity'];

    // Relationship with VendorInvoice
    public function request()
    {
        return $this->belongsTo(VendorInvoice::class);
    }
}
