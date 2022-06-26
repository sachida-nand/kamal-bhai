<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTicket extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'ticket_number',
            'status',
            'subject'
    ];

    public function TicketReaply(){
        return $this->hasMany(TicketReaply::class, 'ticket_id','id');
    }
}
