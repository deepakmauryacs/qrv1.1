<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorMenuSetup extends Model
{
    use HasFactory;

    protected $table = 'vendor_menu_setup';

    protected $fillable = [
        'vendor_id',
        'discount',
    ];
}
