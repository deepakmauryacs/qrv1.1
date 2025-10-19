<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public function chats()
    {
        return $this->hasMany(TicketChat::class, 'ticket_id');
    }
}
