<?php

namespace App\Http\Controllers;

use App\Notifications\JobAffected;
use App\Models\Conversation;
use App\Models\CoverLetter;
use App\Models\Job;
use App\Models\User;
use App\Models\Message;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidatedProposalMail;
use App\Models\Appointment;
use MercurySeries\Flashy\Flashy;




class ProposalController extends Controller
{ 
    public $job;
    public function store(Request $request, Job $job)
    {
        $proposal= Proposal::create([
            'job_id' => $job->id,
            'validated' => false
        ]);

        CoverLetter::create([
            'proposal_id' => $proposal->id,
            'content' => $request->input('content'),
        ]);

        Flashy::message('Request sent !');
        
        return redirect()->route('jobs.index');
    }

    // public function delete($id)
    // {
    //     $job=DB::table('proposals')->where('id', $id)->delete();
    //     // $prod=DB::table('products')->where('id', $id)->delete();
    //     // $proposal= DB::delete('delete proposals where id = ?', [$id]);
    //     Flashy::message('Mission deleted !');

    // }


    public function confirm(Request $request, User $user)
    {
        $proposal=Proposal::findOrFail($request->proposal);
        $proposal->fill(['validated' =>1]);
        if ($proposal ->isDirty()) {

            // $userDuJobEmail= $proposal->job->user->email;
            // dump($userDuJob, $userDuJobEmail);
            // die();
            $proposal->save();
            // $user->notify(new JobAffected($proposal));
            $userQuiASendProposal= $proposal->user->email;
            $titleDuJob= $proposal->job->title;
            $userDuJob= $proposal->job->user;
            // try {
            //     Mail::to($userQuiASendProposal)->send(new ValidatedProposalMail($userDuJob, $titleDuJob));

            // } catch (\Throwable $th) {
            //     throw $th->exeption;
            // }


            // $user->notify(new JobAffected($proposal));


            $conversation = Conversation::updateOrCreate([
                'from' => auth()->user()->id,
                'to' => $proposal->user->id,
                'job_id' => $proposal->job_id
            ]);

            Message::create([
                'user_id' => auth()->user()->id,
                'conversation_id' => $conversation->id,
                'content' => "Hi, I have validated your offer, the date of the interview will 
                be communicated to you later !"
            ]);
            
            Flashy::message('Validated proposal !');

            return redirect()->route('dashboard');
        }


    }

    public function schedule(Request $request, Proposal $id)
    {
        $proposal=Proposal::find($request->proposal_id);
        // dd($proposal);// $proposal->isDirty();
        
        $request->validate([
            'date' => 'required|date',
            'end_time' => 'required',
            'start_time' =>'required',
        ]);
        $rdv= Appointment::updateOrCreate([
            'date' =>$request->date,
            'start_time' =>$request->start_time,
            'end_time' =>$request->end_time,
            'user_id' =>auth()->user()->id,
            'proposal_id' =>$request->proposal_id,
        ]);
        // dd($rdv);
        $conversation = Conversation::updateOrCreate([
            'from' => auth()->user()->id,
            'to' => $proposal->user->id,
            'job_id' => $proposal->job_id
        ]);
        // dd($conversation);
        $message= Message::create([
            'user_id' => auth()->user()->id,

            'conversation_id' => $conversation->id,
            'content' => 'Hello, your interview is scheduled for the'. $request->date. 'th at'.
            'Start :'.$request->start_time . 'End :'. $request->end_time
        ]);
        // dd($message);


        Flashy::message('Interview schedule !');
            return redirect()->route('dashboard');

    }

    public function cancel(Request $request)
    {
        $proposal=Proposal::findOrFail($request->proposal);
        // dd($proposal);
        $proposal->fill(['validated' =>0]);
        if ($proposal ->isDirty()) {
            
            $proposal->save();

            $conversation = Conversation::updateOrCreate([
                'from' => auth()->user()->id,
                'to' => $proposal->user->id,
                'job_id' => $proposal->job_id
            ]);
            // dd($conversation);


            // $conversation = Conversation::update([
            //     'from' => auth()->user()->id,
            //     'to' => $proposal->user->id,
            //     'job_id' => $proposal->job_id
            // ]);


            Message::create([
                'user_id' => auth()->user()->id,

                'conversation_id' => $conversation->id,
                'content' => "Hi, and thank you for your proposal but I declined your offer  !"
            ]);
            
            Flashy::message('Proposal refused !');
            return redirect()->route('dashboard');

        }

    }

}
