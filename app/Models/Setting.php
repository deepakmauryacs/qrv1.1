<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id', 'store_name', 'country', 'state', 'city', 'store_address',
        'store_lat', 'store_long', 'dine_in', 'store_email', 'country_code',
        'store_contact', 'opening_time', 'closing_time', 'store_logo'
    ];

}
