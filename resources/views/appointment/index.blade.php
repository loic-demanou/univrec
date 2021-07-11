<!-- Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('appointment.schedule', $proposal->id) }}" method="post">
            @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Appointment</h5><button type="button" class="btn-close"
                    data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="Date">Date</label>
                    <input type="date" name="date" class="form-control  @error('date') is-invalid @enderror">
                    @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>

                <input type="number" name="proposal_id" value="{{ $proposal->id }}" hidden>

                <div class="form-group">
                    <label for="start_time">Start time</label>
                    <input type="time" name="start_time" class="form-control  @error('start_time') is-invalid @enderror">
                    @error('start_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                </div>
                <div class="form-group">
                    <label for="end_time">End time</label>
                    <input type="time" name="end_time" class="form-control  @error('end_time') is-invalid @enderror">
                    @error('end_time')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                </div>
                
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                    Close</button>
                {{-- <a href="{{ route('resume-proposal.download') }}" class="btn btn-primary">Schedule</a> --}}
                <input type="submit" value="Schedule" class="btn btn-primary">
            </div>
        </div>
    </form>
    </div>
</div>
@if (Session::has('errors'))
    <script>
        $(function() {
            $('#appointmentModal').modal({
                show: true
            });
        });
    </script>
@endif

