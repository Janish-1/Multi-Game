@extends('admin.layout.master')
@section('title')
 Jackpot
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
          <p class="card-title"><i class="las la-certificate"></i> Add New Jackpot</p>
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
          <form class="create_brand" method="post" action="{{route('create.jackpoint.new')}}" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
            @csrf
            <div class="form-group">
              <label>Jackpot Entry Fee <span class="text-danger required-sign">*</span></label>
              <input type="text" class="form-control jackpot_entry" name="jackpot_entry" required />
            </div>
            <div class="form-group">
              <label>Number Of Match <span class="text-danger required-sign">*</span></label>
              <input type="text" class="form-control number_of_game" name="number_of_game" required />
            </div>
            <div class="row my-3">
              <div class="col-12">
              <button type="submit" class="btn btn-orange float-right border-0 submit_btn">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Bootstrap Validation -->
    <!-- Merged -->
    <div class="col-md-7 col-12">
          <div class="card">
      <div class="card-header">
        <p class="card-title"><i class="las la-certificate"></i> All Jackpot</p>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Entry Fee</th>
              <th>No. Of Game</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($brands as $key =>$result)
            <tr>
              <td><span class="font-weight-bold">{{ $brands->firstItem() + $key }}</span></td>
              <td><span class="font-weight-bold">{{$result->jackpot_entry}} INR</span></td>
              <td><span class="font-weight-bold">{{$result->number_of_game}} </span></td>
              <td>
              <button type="button" data-id="{{$result->id}}" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-icon btn-icon rounded-circle btn-primary bg-darken-4 border-0 edit_buuton">
               <i class="las la-highlighter"></i>
              </button>
              <button type="button" delete-id="{{$result->id}}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-icon btn-icon rounded-circle btn-danger bg-darken-4 border-0 delete_buuton">
               <i class="las la-trash"></i>
              </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="my-1">
        {{ $brands->onEachSide(3)->links('vendor.pagination.custom') }}
      </div>
    </div>
    </div>
  </div>
  
@endsection
@section('js')
<!-- link custom js link here -->
<script src="{{URL::asset('admin-assets/css/custom/js/Jackpot/Jackpot.js')}}"></script>
@endsection
