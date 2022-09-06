<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

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
        //$users = User::all();
        ///*
        $users = NULL;

        if ($request['radio-input'] == "In Progress Projects")
        {
            $users = DB::table('email')
                ->join('collaborator','email.id','=','collaborator.email_id')
                ->join('project','project.id','=','collaborator.project_id')
                ->join('proposal','proposal.project_id','=','project.id')
                ->whereRaw('proposal.created_at + INTERVAL (proposal.duration) DAY > CURRENT_DATE')
                ->select('email.address')
                ->distinct()
                ->get();
        }
        else if ($request['radio-input'] == "Expired Projects")
        {
            $users = DB::table('email')
                ->join('collaborator','email.id','=','collaborator.email_id')
                ->join('project','project.id','=','collaborator.project_id')
                ->join('proposal','proposal.project_id','=','project.id')
                ->whereRaw('proposal.created_at + INTERVAL (proposal.duration) DAY < CURRENT_DATE')
                ->select('email.address')
                ->distinct()
                ->get();
        }
        else if ($request['radio-input'] == "All")
        {
            $users = DB::table('email')
                ->join('collaborator','email.id','=','collaborator.email_id')
                ->join('project','project.id','=','collaborator.project_id')
                ->join('proposal','proposal.project_id','=','project.id')
                ->select('email.address')
                ->distinct()
                ->get();
        }
        //*/
        $details=[
            'from'=> 'email@test.com',
            'subject'=> $request['subject'],
            'body'=> $request['content']
        ];

        //dd(User::all());
        ///*
        $users1 = collect(new User);
        foreach($users as $user) {
        $users1->add((new User)->forceFill(['email'=>$user->address]));
        }

        //dd($users1);
        $message = new Message($details);
        //dd($users);

        if ($users->isNotEmpty()) {
            Notification::send($users1,$message);
            //$users1->not
//            foreach($users as $user) {
//                (new User)->forceFill(['email'=>$user->address])->notify($message);
//                //Notification::route('mail', $user->address)->notify(new Message($details));
//            }
            return back()->with('status','success');
        }
        else
        {
            return back()->with('status','error');
        }

        //*/

        /*
        Notification::send($users,new Message($details));
        return back()->with('status','success');
        */
    }
}
