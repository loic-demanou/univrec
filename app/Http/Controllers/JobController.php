<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Stroage;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use MercurySeries\Flashy\Flashy;

class JobController extends Controller
{

    // public function dash()
    // {
    //     return view('Admin.dashboard');
    // }

    public function dashboard()
    {
        return view('dashboard');
    }

    public $search;

    public function index()
    {
        //$jobs=Job::online()->latest()->get();
        // $proposal=DB::table('proposals')->where('user_id')->select();

        $jobs = Job::latest()->paginate(10);

        // return view('jobs.index', compact('jobs'), compact('proposal'));
        return view('jobs.index', [
            'jobs' => $jobs,

        ]);
    }

    public function show(Job $id)
    {
        return view('jobs.show', [
            'jobs' => $id
        ]);
    }

    public function create()
    {

        return view("jobs.create");
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['required', 'string', 'max:5000'],
            'status' => ['required'],
            'speciality' => ['required', 'string'],
            'question_title' => ['nullable'],
            'attachment' => ['nullable', 'file'],
            'qualification' => 'string|required',
            'post' => 'string|required',
            'number' => 'integer|required',
            'job_type' => 'string|required',

        ]);
        // $pdf=request('attachment')->store('pdf', 'public');
        $file = $request->attachment;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $request->attachment->move('assets', $filename);

        $jobs = Job::create([
            'title' => request('title'),
            'description' => request('description'),
            'status' => request('status'),
            'attachment' => $filename,
            'number' => request('number'),
            'speciality' => request('speciality'),
            'qualification' => request('qualification'),
            'post' => request('post'),
            'job_type' => request('job_type'),
            'user_id' => auth()->user()->id,
        ]);


        // $jobs = Auth::user()->jobs()->create($request->all());


        foreach ($request->questionJobs  as $questions) {
            //     $jobs->questions()->create($request->all());
            // 
            $test = $jobs->questions()->create([
                'question_title' => $questions
            ]);
            // dd($test);
        }

        Flashy::message('New mission created !');
        return redirect()->route('jobs.index', compact('jobs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['required', 'string', 'max:5000'],
            'status' => ['required'],
            'speciality' => ['required', 'string'],
            'question_title' => ['nullable'],
            // 'attachment' => ['nullable', 'file'],
            'qualification' => 'string|required',
            'post' => 'string|required',
            'number' => 'integer|required',
            'job_type' => 'string|required',
        ]);
        // dd($test);
        // $file = $request->attachment;
        // $filename = time() . '.' . $file->getClientOriginalExtension();
        // $request->attachment->move('assets', $filename);

        $jobs = DB::table('jobs')
        ->where('id', $id)
        ->update([
            'title' => request('title'),
            'description' => request('description'),
            'status' => request('status'),
            // 'attachment' => $filename,
            'number' => request('number'),
            'speciality' => request('speciality'),
            'qualification' => request('qualification'),
            'post' => request('post'),
            'job_type' => request('job_type'),
            'user_id' => auth()->user()->id,
            // 'description'=> request('description'),
        ]);
        // dd($jobs);

        // $jobs = DB::table('jobs')
        //     ->where('id', $id)
        //     ->update([
        //         'title' => request('title'),
        //         'description' => request('description'),
        //         'status' => request('status'),
        //         'price' => request('price'),
        //         // 'description'=> request('description'),
        //     ]);
        flashy("Edited job");
        return redirect()->route('dashboard', compact('jobs'));
    }

    public function edit($id)
    {
        $jobs = Job::findOrFail($id);
        return view("jobs.edit", compact('jobs'));
    }

    public function delete($id)
    {
        $job = DB::table('jobs')->where('id', $id)->delete();
        Flashy::message('Mission deleted !');
        // session()->flash('message', 'Deleted mission');
        // session()->flash('notification.type', 'danger');

        return redirect()->route('dashboard');
    }

    public function download(Request $request, $file)
    {
        return response()->download(public_path('assets/'.$file));
    }

    public function view(Request $request, $id)
    {
        $data = Job::find($id);
        // return response()->download(public_path('assets/'.$file));
        return view('jobs.attachment', compact('data'));

    }

}
