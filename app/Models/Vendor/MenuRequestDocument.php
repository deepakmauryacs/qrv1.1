<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRequestDocument extends Model
{
    use HasFactory;

    protected $fillable = ['request_id', 'vendor_id', 'document'];

    // Relationship with MenuRequest
    public function request()
    {
        return $this->belongsTo(MenuRequest::class);
    }
}
