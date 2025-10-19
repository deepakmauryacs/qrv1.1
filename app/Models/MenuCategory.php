<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;

    // Relationship with Menu
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Define the relationship correctly
    public function vendorMenus()
    {
        return $this->hasMany(VendorMenu::class, 'menu_category_id', 'id');
    }
    
    
}
