@extends('admin.layout.master')
@section('title')
Ads Settings
@endsection
@section('css')
<!--  link custom css link here -->
@endsection @section('content')
<!-- BEGIN: Content-->
@if (session()->get('error'))
<div class="alert alert-danger alert-dismissible ml-1 mr-1" id="notice_msg" role="alert">
    <div class="alert-body">
        <b>{{ session()->get('error') }}</b>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(session()->get('success'))
<div class="alert alert-success alert-dismissible ml-1 mr-1" id="success_msg" role="alert">
    <div class="alert-body">
        <b>{{ session()->get('success') }}</b>
    </div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<div class="row">
    <!-- left menu section -->
    <div class="col-md-3 mb-2 mb-md-0">
        <ul class="nav nav-pills flex-column nav-left">
            <!-- general -->
            <li class="nav-item">
                <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                    <i class="las la-photo-video font-medium-3 mr-1"></i>
                    <span class="font-weight-bold">Ads Image</span>
                </a>
            </li>
        </ul>
    </div>
    <!--/ left menu section -->

    <!-- right content section -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <!-- general tab -->
                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                        <!-- form 1 -->
                        <form id="adForm1" class="general_setting" method="post" action="{{ route('update.Ad.imagea') }}" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="lab la-pagelines font-medium-3 mr-1"></i>
                                        <h4 class="font-weight-bold mb-0 ml-75">Ad 1</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-success">For Best Quality Upload 732x616 Pixels Image</small>
                                    <div class="form-group">
                                        <label class="form-label">Ads Image</label>
                                        <input type="file" accept="image/*" required class="dropify head_logo" name="ad" data-height="176" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-2 mr-1 float-right">Update Ad 1</button>
                            </div>
                        </form>
                        <!--/ form -->
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general-2" aria-labelledby="account-pill-general-2" aria-expanded="true">
                        <!-- form 2 -->
                        <form id="adForm2" class="general_setting" method="post" action="{{ route('update.Ad.imageb') }}" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="lab la-pagelines font-medium-3 mr-1"></i>
                                        <h4 class="font-weight-bold mb-0 ml-75">Ad 2</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-success">For Best Quality Upload 732x616 Pixels Image</small>
                                    <div class="form-group">
                                        <label class="form-label">Ads Image</label>
                                        <input type="file" accept="image/*" required class="dropify head_logo" name="ad" data-height="176" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-2 mr-1 float-right">Update Ad 2</button>
                            </div>
                        </form>
                        <!--/ form -->
                    </div>
                    <!--/ social -->
                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general-2" aria-labelledby="account-pill-general-2" aria-expanded="true">
                        <!-- form 2 -->
                        <form id="adForm3" class="general_setting" method="post" action="{{ route('update.Ad.imagec') }}" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="lab la-pagelines font-medium-3 mr-1"></i>
                                        <h4 class="font-weight-bold mb-0 ml-75">Table Image</h4>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-success">For Best Quality Upload 732x616 Pixels Image</small>
                                    <div class="form-group">
                                        <label class="form-label">Table Image</label>
                                        <input type="file" accept="image/*" required class="dropify head_logo" name="ad" data-height="176" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-2 mr-1 float-right">Update Table Image</button>
                            </div>
                        </form>
                        <!--/ form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ right content section -->
</div>
<!-- END: Content-->
@endsection @section('js')
<!-- link custom js link here -->
<script src="{{ URL::asset('admin-assets/css/custom/js/websitesetting/websitesetting.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#adForm1, #adForm2, $adForm3').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          // Handle success response
          console.log(response);
          // Perform any necessary actions with the response data
        },
        error: function(xhr, status, error) {
          // Handle error response
          console.error(error);
        }
      });
    });
  });
</script>
@endsection