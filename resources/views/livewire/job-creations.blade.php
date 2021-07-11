<div>
    <form action="{{ route('jobs.store', auth()->user()) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row hover:shadow-lg border border-gray-500 bg-white py-4"
            style="margin-top:4%; border-radius: 15px;">
            <div class="form-group col-md-6">
                <label for="">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                    value="{{ old('title') }}" autocomplete="title" autofocus placeholder="">
                @error('title')
                    <span class="text-red-400 text-sm block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <br>

                <div class="col-md-12">
                    <label for="">Qualification</label>
                    <input type="text" class="form-control @error('qualification') is-invalid @enderror" name="qualification"
                        value="{{ old('qualification') }}" autocomplete="qualification" autofocus placeholder="eg:M.Se/M.Eng">
                    @error('qualification')
                        <span class="text-red-400 text-sm block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><br>

                <div class="col-md-12">
                    <label for="">Speciality</label>
                    <input type="text" class="form-control @error('speciality') is-invalid @enderror" name="speciality"
                        value="{{ old('speciality') }}" autocomplete="speciality" autofocus placeholder="eg:Computer engineering">
                    @error('speciality')
                        <span class="text-red-400 text-sm block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><br>

                <div class="col-md-12">
                    <label for="">Post to be occupied</label>
                    <input type="text" class="form-control @error('post') is-invalid @enderror" name="post" 
                        value="{{ old('post') }}" autocomplete="post" autofocus placeholder="eg:Teacher">
                    @error('post')
                        <span class="text-red-400 text-sm block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><br>

                <label for="">Description</label>
                <textarea name="description" cols="30" rows="5" id="job-textarea" class="form-control @error('description') is-invalid @enderror"
                    value="{{ old('description') }}"
                    autocomplete="description" autofocus></textarea>
                @error('description')
                    <span class="text-red-400 text-sm block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <br>

            </div>

            <div class="form-group col-md-6">
                <label for="">Attachment</label>
                <input type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" 
                    value="{{ old('attachment') }}" autocomplete="attachment" autofocus>
                @error('attachment')
                    <span class="text-red-400 text-sm block" role="alert"></span>
                    <strong>{{ $message }}</strong>
                @enderror
                <br>

                <div class="col-md-12">
                    <label for="">Job status</label>
                    <select name="job_type" class="form-control @error('job_type') is-invalid @enderror">
                        <option>--choose a contract status--</option>
                        <option value="permanent">Permanent</option>
                        <option value="temporary">Temporary</option>
                    </select>
                    @error('job_type')
                        <span class="text-red-400 text-sm block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div><br>

                <div class="col-md-6">
                    <label for="">place number</label>
                    <input type="number" class="form-control @error('number') is-invalid @enderror" name="number" 
                    value="{{ old('number') }}" autocomplete="number" autofocus>
                    @error('number')
                        <span class="text-red-400 text-sm block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                

                <div class="form-group">
                    <div class="mt-4 col-6">
                        <p for="role-select" class="font-semibold text-gray-700 mb-2">Status</p>
                        <div class="flex justify-between items-center pb-4">
                            <label for="available">Available
                                <input type="radio" value="1" id="available" name="status">
                                <span class="checkmark"></span>
                            </label>
                            <label for="client">Unavailable
                                <input type="radio" value="2" id="client" name="status">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        @error('status')
                            <span class="text-red-400 text-sm block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-12">
                        <p>Questionnaire</p>
                        @foreach ($questionJobs as $index => $questionJob)
                            <div class="d-flex">
                                <input type="text" class="form-control mb-2"
                                    name="questionJobs[{{ $index }}] question_title[]"
                                    wire:model="questionJobs.{{ $index }}.question_title">
                                <a class="ml-2 mb-2 btn btn-danger"
                                    wire:click.prevent="removeQuestion({{ $index }})">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        @endforeach
                        <a class="btn btn-secondary mt-2" wire:click.prevent="addQuestion"><i
                                class="fas fa-plus"></i></a>
                    </div>
                </div>

                {{-- Hour<input type="time"> --}}

            </div>
            <div class="form-group">
                <x-jet-button class="px-5">Create<i class="fas fa-plus ml-3"></i></x-jet-button>
            </div>
        </div>
    </form>

</div>
@section('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#job-textarea'))
            .catch(error => {
                console.error(error);
            });

    </script>
@endsection
