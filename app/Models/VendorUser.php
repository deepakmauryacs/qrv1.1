<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class VendorUser extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'vendors_users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'vendor_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
    ];

    /**
     * Attributes hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Accessor for the user's display name.
     */
    public function getNameAttribute(): string
    {
        $parts = array_filter([$this->first_name, $this->last_name]);

        return $parts ? implode(' ', $parts) : $this->first_name;
    }

    /**
     * Vendor relationship.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
