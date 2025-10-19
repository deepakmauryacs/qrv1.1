<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRequest extends Model
{
    use HasFactory;

    public function documents()
    {
        return $this->hasMany(MenuRequestDocument::class, 'request_id', 'request_id');
    }

}
