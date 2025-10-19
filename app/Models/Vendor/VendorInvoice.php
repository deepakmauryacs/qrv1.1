<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorInvoice extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(VendorInvoiceItem::class, 'invoice_id', 'invoice_id');
    }
}
