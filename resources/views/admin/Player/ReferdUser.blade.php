@extends('admin.layout.master')
@section('title')
 Refred By {{$UserData['username']}}
@endsection
@section('css')
 <!--  link custom css link here -->
@endsection
@section('content')
 <!-- BEGIN: Content-->
   <div class="row">
     <!-- Bootstrap Validation -->
      <div class="col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <p class="card-title"><i class="las la-sliders-h"></i> Refred By {{$UserData['username']}}</p>
              <form method="get" action="{{route('search.player.list')}}" data-parsley-validate autocomplete="off">
                @csrf
                <div class="input-group">
                <input type="text" class="form-control" placeholder="Player ID Or Mob Num" name="searchInput" aria-describedby="button-addon2"/>
                <div class="input-group-append" id="button-addon2">
                  <button class="btn btn-primary" type="submit">Search</button>
                </div>
               </div>
              </form>
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
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Player ID</th>
                    <th>Image</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Amount</th>
                    <th>WIN Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $key =>$result)
                  <tr>
                    <td><span class="font-weight-bold">{{ $data->firstItem() + $key }}</span></td>
                    <td>{{ $result->playerid }}</td>
                    <td>
                        @if($result->photo == null)
                        <img class="img-fluid rounded" src="https://xp.io/storage/6YUfyNd.png" height="50" width="50" alt="User avatar"
                      />
                        @else
                        <img class="img-fluid rounded" src="{{$data->photo}}" height="104" width="104" alt="User avatar"
                        />
                       @endif
                    <td>{{ $result->username }}</td>
                    <td>{{ $result->useremail }}</td>
                    <td>{{ $result->totalcoin }} <i class="las la-rupee-sign"></i></td>
                    <td>{{ $result->wincoin }} <i class="las la-rupee-sign"></i></td>
                    <td>
                      @if($result->banned == 1)
                     <div class="badge badge-light-success">Active</div>
                      @else
                     <div class="badge badge-light-danger">Blocked</div>
                      @endif
                    </td>
                    <td>
                       <a href="{{url('admin/player/view/'.Crypt::encrypt($result->userid))}}">
                        <button type="button" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-icon btn-icon rounded-circle btn-success bg-darken-4 border-0 view_buuton"><i class="las la-eye"></i>
                      </button>
                      </a>
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
            {{ $data->onEachSide(3)->links('vendor.pagination.custom') }}
            </div>
          </div>
        </div>
      </div>
      <!-- /Bootstrap Validation -->

  </div>
    <!-- END: Content-->
@endsection
@section('js')
<script src="{{URL::asset('admin-assets/css/custom/js/player/player.js')}}"></script>
@endsection
