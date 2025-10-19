<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRScan extends Model
{
    use HasFactory;

      protected $fillable = ['vendor_id', 'qr_code', 'user_ip', 'scanned_at'];

}
