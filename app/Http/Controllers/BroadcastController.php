<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class BroadcastController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('broadcast');
    }

    public function send(Request $request)
    {
        $emails = NULL;

        if ($request['radio-input'] == "In Progress Projects")
        {
            $emails = DB::table('email')
                ->join('collaborator','email.id','=','collaborator.email_id')
                ->join('project','project.id','=','collaborator.project_id')
                ->join('proposal','proposal.project_id','=','project.id')
                ->join('review','review.proposal_id','=','proposal.id')
                ->where('review.response','=','accepted')
                ->whereRaw( 'review.created_at + INTERVAL (proposal.duration) MONTH > CURRENT_DATE')
                ->select('email.address')
                ->distinct()
                ->get();
        }
        else if ($request['radio-input'] == "Expired Projects")
        {
            $emails = DB::table('email')
                ->join('collaborator','email.id','=','collaborator.email_id')
                ->join('project','project.id','=','collaborator.project_id')
                ->join('proposal','proposal.project_id','=','project.id')
                ->join('review','review.proposal_id','=','proposal.id')
                ->where('review.response','=','accepted')
                ->whereRaw( 'review.created_at + INTERVAL (proposal.duration) MONTH < CURRENT_DATE')
                ->select('email.address')
                ->distinct()
                ->get();
        }
        else if ($request['radio-input'] == "All")
        {
            $emails = DB::table('email')
                ->select('email.address')
                ->distinct()
                ->get();
        }

        $details=[
            'from'=> 'email@test.com', // TODO: -- Email: Change from email
            'subject'=> $request['subject'],
            'body'=> $request['content']
        ];

        $message = new Message($details);

        $users_collection = collect(new User);
        foreach($emails as $email) {
        $users_collection->add((new User)->forceFill(['email'=>$email->address]));
        }

        if ($emails->isNotEmpty()) {
            Notification::send($users_collection,$message);
//            foreach($emails as $email) {
//                (new User)->forceFill(['email'=>$user->address])->notify($message); // Anonymous function to create users on the fly
//                Notification::route('mail', $user->address)->notify(new Message($details)); // On demand notification: takes only 1 email
//            }
            return back()->with('status','success');
        }
        else
        {
            return back()->with('status','error');
        }
    }
}
