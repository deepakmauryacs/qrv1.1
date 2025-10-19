<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;
    
    protected $table = 'vendors'; // Ensure the correct table name is set
    protected $fillable = ['code', 'name', 'email', 'password','contact_number', 'owner_name', 'address', 'status'];

    // One-to-many relationship with VendorsSubscription
    public function subscriptions()
    {
        return $this->hasMany(VendorsSubscription::class);  // If VendorsSubscription has 'vendor_id' field
    }

   
   

}
