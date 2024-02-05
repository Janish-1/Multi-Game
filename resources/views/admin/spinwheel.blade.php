@extends('admin.layout.master')
@section('title')
Spin Wheel
@endsection
@section('css')
<!--  link custom css link here -->
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="row">
    <!-- Bootstrap Validation -->
    <div class="col-md-5 col-12">
        <div class="card">
            <div class="card-header">
                <p class="card-title"><i class="las la-certificate"></i> Spin Wheel </p>
            </div>
            @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible ml-1 mr-1" id="notice_msg" role="alert">
                <div class="alert-body">
                    <b>{{session()->get('error')}}</b>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->get('success'))
            <div class="alert alert-success alert-dismissible ml-1 mr-1" id="success_msg" role="alert">
                <div class="alert-body">
                    <b>{{session()->get('success')}}</b>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card-body">
                <form class="create_brand" method="post" action="{{route('set.spin.odds')}}" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label> Set Odds <span class="text-danger required-sign">*</span></label>
                        <input type="number" class="form-control bid_value" name="spinodds" required />
                    </div>
                    <div class="row my-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-orange float-right border-0 submit_btn">Submit</button>
                        </div>
                    </div>
                </form>
                <div role="tabpanel" class="tab-pane" id="account-vertical-spin" aria-labelledby="account-pill-spin" aria-expanded="true">
                    <!-- form -->
                    <form class="general_setting" method="post" action="{{ route('daily.spin.increase') }}" data-parsley-validate autocomplete="off">
                        @csrf
                        <div class="row">
                            <!-- social header -->
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="las la-globe-europe font-medium-3 mr-1"></i>
                                    <h4 class="font-weight-bold mb-0 ml-75">Add Daily Spin</h4>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-2 mr-1 float-left">Add
                                    Daily Spins</button>
                            </div>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>
        </div>
    </div>
    <!-- /Bootstrap Validation -->
</div>

@endsection
@section('js')
<!-- link custom js link here -->
<script src="{{URL::asset('admin-assets/css/custom/js/bidvalue/bidvalue.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function () {
    // Submit form for setting spin odds
    $('.create_brand').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                // Handle success response
                $('#success_msg').html('<b>' + response.success + '</b>');
            },
            error: function (error) {
                // Handle error response
                $('#notice_msg').html('<b>' + error.responseJSON.message + '</b>');
            }
        });
    });

    // Submit form for adding daily spins
    $('.general_setting').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                // Handle success response
                alert('Daily spins added successfully!');
            },
            error: function (error) {
                // Handle error response
                alert('Failed to add daily spins. Please try again.');
            }
        });
    });
});
</script>
@endsection