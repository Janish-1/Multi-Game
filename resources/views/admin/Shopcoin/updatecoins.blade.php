@extends('admin.layout.master')
@section('title')
 Shop Coin
@endsection
@section('css')
 <!--  link custom css link here -->
@endsection
@section('content')
 <!-- BEGIN: Content-->
 <div class="card-body">
          <form class="create_brand" method="POST" action="{{route('update.total.coin')}}" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label>Player ID <span class="text-danger required-sign">*</span></label>
              <input type="number" class="form-control shop_coin" name="playerid" required />
            </div>
            <div class="form-group">
              <label>Update Coins <span class="text-danger required-sign">*</span></label>
              <input type="number" class="form-control shop_coin" name="new_totalcoin" required />
            </div>
            <div class="row my-3">
              <div class="col-12">
              <button type="submit" class="btn btn-orange float-right border-0 submit_btn">Submit</button>
              </div>
            </div>
          </form>
        </div>
    <!-- END: Content-->
@endsection
@section('js')
<!-- link custom js link here -->
<script src="{{URL::asset('admin-assets/css/custom/js/shopcoin/shopcoin.js')}}"></script>
@endsection
