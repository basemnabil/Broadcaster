<?php

namespace App\Http\Controllers;

use App\Mail\broadcastMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function log()
    {
        $log = DB::table('broadcast')
            ->select('id','subject','body','created_at','updated_at')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('broadcastLog')->with('log',$log);
    }

    public function log_details($id)
    {
        $log_details = DB::table('broadcast_log')
            ->join('collaborator','collaborator.email_id','=','broadcast_log.email_id')
            ->join('user','collaborator.id','=','user.collaborator_id')
            ->join('email','broadcast_log.email_id','=','email.id')
            ->where('broadcast_log.broadcast_id','=', $id)
            ->select('user.username','broadcast_log.status')
            ->get();
        return json_encode($log_details);
    }

    public function send(Request $request)
    {
        // Input validation
        $request->validate([
            'radio-input' => 'required',
            'subject' => 'required',
            'content' => 'required'
        ]);

        $emails = NULL;

        // Fetch required emails query
        if ($request['radio-input'] == "In Progress Projects")
        {
            $emails = DB::table('email')
                ->join('collaborator','email.id','=','collaborator.email_id')
                ->join('project','project.id','=','collaborator.project_id')
                ->join('proposal','proposal.project_id','=','project.id')
                ->join('review','review.proposal_id','=','proposal.id')
                ->where('review.response','=','accepted')
                ->whereRaw( 'review.created_at + INTERVAL (proposal.duration) MONTH > CURRENT_DATE')
                ->select('email.address', 'email.id')
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
                ->select('email.address', 'email.id')
                ->distinct()
                ->get();
        }
        else if ($request['radio-input'] == "All")
        {
            $emails = DB::table('email')
                ->join('collaborator','email.id','=','collaborator.email_id')
                ->join('project','project.id','=','collaborator.project_id')
                ->join('proposal','proposal.project_id','=','project.id')
                ->join('review','review.proposal_id','=','proposal.id')
                ->where('review.response','=','accepted')
                ->select('email.address','email.id')
                ->distinct()
                ->get();
        }

        // Email details object
        $details=[
            'from'=> 'email@test.com', // TODO: -- Email: Change from email
            'subject'=> $request['subject'],
            'body'=> $request['content'],
        ];

        // Broadcast emails
        if ($emails->isNotEmpty()) {
            $is_sent = false; // True when at least the broadcast was successfully received by 1 recipient
            try {
                DB::beginTransaction();
                $broadcast_id = DB::table('broadcast')->insertGetId([
                    'subject' => $details['subject'], 'body' => $details['body'], 'creator_email_id' => Auth::user()->getAuthIdentifier(),
                ]); // Log broadcast
                // Insert all records as failed
                foreach ($emails as $email) {
                    DB::table('broadcast_log')->insert([
                        'email_id' => $email->id, 'broadcast_id' => $broadcast_id, 'status' => false,
                    ]);
                }
                foreach ($emails as $email) {
                    // Send broadcast and update success recipients status
                    if (Mail::to($email->address)->send(new broadcastMessage($details)) instanceof \Illuminate\Mail\SentMessage) {
                        $is_sent = true;
                        DB::table('broadcast_log')
                            ->where('email_id','=', $email->id)
                            ->where('broadcast_id','=', $broadcast_id)
                            ->update(['status' => true]);
                    }
                }
                DB::commit();
                return back()->with('status', 'success');
            }
            catch (\Exception $e)
            {
                if ($is_sent === false)
                    DB::rollBack();
                return back()->with('status','error');
            }
        }
        else
        {
            return back()->with('status','error');
        }
    }
}
