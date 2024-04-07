@extends('admin.layout.master')
@section('title')
    Add New Tournament
@endsection
@section('css')
@endsection
@section('content')
    <!-- BEGIN: Content-->
    <form class="create_brand" method="post" action="{{route('create.tournament.new')}}" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
    @csrf
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label>Tournament Name <span class="text-danger required-sign">*</span></label>
                <input type="text" class="form-control tournament_name" name="tournament_name" required />
            </div>
            <div class="col-md-6">
                <label>Prize Pool <span class="text-danger required-sign">*</span></label>
                <input type="text" class="form-control prize_pool" name="prize_pool" required />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Time Start <span class="text-danger required-sign">*</span></label>
                <input type="datetime-local" class="form-control time_start" name="time_start" required />
            </div>
            <div class="col-md-6">
                <label>Player Type <span class="text-danger required-sign">*</span></label>
                <select class="form-control player_type" name="player_type" required>
                    <option value="">Select Player Type</option>
                    <option value="1v1">1 v 1</option>
                    <option value="1v3">1 v 3</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Game Type <span class="text-danger required-sign">*</span></label>
                <select class="form-control game_type" name="game_type" required>
                    <option value="">Select Game Type</option>
                    <option value="timeattack">Time Attack</option>
                    <option value="dicerolls">Dice Rolls</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Entry Fee <span class="text-danger required-sign">*</span></label>
                <input type="number" class="form-control entry_fee" name="entry_fee" required />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Number of Tables <span class="text-danger required-sign">*</span></label>
                <select class="form-control nooftables" name="nooftables" required>
                    <option value="">Select Number of Tables</option>
                    <option value="1">1</option>
                    <option value="4">4</option>
                    <option value="16">16</option>
                    <option value="64">64</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-orange float-right border-0 submit_btn">Submit</button>
            </div>
        </div>
    </div>
</form>

    <!-- END: Content-->
@endsection
@section('js')
    <!-- link custom js link here -->
    <script src="{{ URL::asset('admin-assets/css/custom/js/tournament/tournament.js') }}"></script>
@endsection
