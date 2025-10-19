<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorMenu extends Model
{
    use HasFactory;

    // Define the relationship with MenuCategory (assuming category_id is the foreign key)
    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    // Define the inverse relationship
    public function category()
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id');
    }
}
