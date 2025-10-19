<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'invoice_logo',
        'currency',
        'timezone',
        'default_customer_name',
        'default_contact_number',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
