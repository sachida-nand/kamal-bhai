<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\TicketReaply;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupportTicketController extends Controller
{
    public function index(){
        $UserId = Auth::user()->id;
        $Tickets = UserTicket::where('user_id',$UserId)->orderBy('id','DESC')->get();
        return view('frontEnd.supportTicket',compact('Tickets'));
    }

    public function CreateTicket(Request $request){
        $TicketNumber = rand(0000000000, 9999999999);
        
        $request->validate([
            'subject' => 'required|min:3',
            'message' => 'required',
            'ticket_file' => 'mimes:png,jpg,pdf,jpeg',
        ]);
        // create ticket number 
        $CreateTicket = new UserTicket();
        $CreateTicket->user_id = Auth::user()->id;
        $CreateTicket->ticket_number = $TicketNumber;
        $CreateTicket->subject = $request->post('subject');
        $CreateTicket->status = 'Pending';
        $CreateTicket->save();
        
        $TicketId = $CreateTicket->id;
        $TicketMessage = TicketReaply::AddTicketMessage($request,$TicketId);
       
        if ($TicketMessage) {
            $Status = 'Success';
            $msg = 'You successfully created your ticket!';
        } else {
            $Status = 'Error';
            $msg = 'There\'s a problem on created your ticket!';
        }
        return redirect('support-ticket')->with(['msg' => $msg, 'status' => $Status]);
    }

    public function ShowReplySupportTicket($TicketNumber)
    {
        $UserId = Auth::user()->id;
        $Tickets = UserTicket::where('user_id', $UserId)->orderBy('id','DESC')->get();

        $Ticket = UserTicket::where('ticket_number', $TicketNumber)->first();
        if(!$Ticket){
            $msg = 'ticket not fount';
            return view('frontEnd.supportTicket',compact('Tickets','msg'));
        }else{
            return view('frontEnd.replySupportTicket',compact('Ticket'));
        }
    }

    public function DownloadFile($image_Name){
        $file = public_path() . '/storage/ticketfile/' .$image_Name;
        return response()->download($file);
    }

    public function ReaplyTicketMessage(Request $request){

        $TicketNumber = $request->post('ticket_number');  
        $Ticket = UserTicket::Where('ticket_number',$TicketNumber)->first();
        
        $TicketMessage = TicketReaply::AddTicketMessage($request,$Ticket->id);

        if($TicketMessage){
            $Status = 'Success';
        }else{
            $Status = 'Error';
        }
        
        return json_encode(['Status'=>$Status]);
    }
}
