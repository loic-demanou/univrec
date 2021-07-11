<?php

namespace App\Http\Livewire;

use App\Models\Job;
use Livewire\Component;

class JobCreations extends Component
{
    public $questionJobs = [];
    public $allJobs = [];

    public function mount()
    {
        $this->allJobs = Job::all();
        $this->questionJobs = [
            ['question_title' => ""]
        ];
    }

    public function addQuestion()
    {
        $this->questionJobs[] = ['question_title' => ""];

    }

    public function removeQuestion($index)
    {
        unset($this->questionJobs[$index]);
        $this->questionJobs = array_values($this->questionJobs);
    }

    public function render()
    {
        return view('livewire.job-creations');
    }
}
