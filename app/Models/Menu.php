<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Define the relationship with MenuCategory (assuming category_id is the foreign key)
    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

}
