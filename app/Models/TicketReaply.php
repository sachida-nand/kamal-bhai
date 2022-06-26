<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class TicketReaply extends Model
{
    use HasFactory;

    static function AddTicketMessage($request,$Ticket_id){

        $UserType = Auth::user()->user_type == 1 ? 'admin' : 'user';
        //store their message
        $TicketMessage = new TicketReaply();
        $TicketMessage->ticket_id = $Ticket_id;
        $TicketMessage->user_type = $UserType;
        $TicketMessage->message = $request->post('message');

        if ($request->hasFile('ticket_file')) {
            $document = $request->file('ticket_file');
            $fileExtension = $document->getClientOriginalExtension();
            $newName = Str::uuid() . '.' . $fileExtension;
            $document->storeAs('/public/ticketfile', $newName);
            $TicketMessage->document = $newName;
        }
        $TicketMessage->save();

        return $TicketMessage->id;
    }
}
