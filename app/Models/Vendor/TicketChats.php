<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketChats extends Model
{
    use HasFactory;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id');
    }
}
