@extends('admin.layout.master')
@section('title')
Ongoing Tournaments
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
        <p class="card-title"><i class="las la-sliders-h"></i> Ongoing Tournaments </p>
        <form id="deleteAllForm" method="DELETE" action="{{ route('delete.all.tournaments') }}" data-parsley-validate autocomplete="off">
          @csrf
          <button class="btn btn-danger" type="submit">Delete All Tournaments</button>
        </form>
        <a href="{{url('/')}}/admin/tournament/add"><button class="btn btn-orange border-0 round"><i class="las la-plus-circle"></i> Add New Tournament</button></a>
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
      <!-- <div class="row"> -->
      <!-- <div class="col-md-3 mb-2 mb-md-0">
          <ul class="nav nav-pills flex-column nav-left">
            <li class="nav-item">
              <a class="nav-link active" id="account-pill-general" data-toggle="pill" href="#ongoing-tournaments" aria-expanded="true">
                <i class="las la-globe-europe font-medium-3 mr-1"></i>
                <span class="font-weight-bold">Ongoing Tournaments</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="account-pill-logo" data-toggle="pill" href="#completed-tournaments" aria-expanded="false">
                <i class="lab la-pagelines font-medium-3 mr-1"></i>
                <span class="font-weight-bold">Completed Tournaments</span>
              </a>
            </li>
          </ul>
        </div> -->
      <!--/ left menu section -->
      <!-- <div class="col-md-9"> -->
      <div class="card">
        <div class="card-body">
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="ongoing-tournaments" aria-labelledby="account-pill-general" aria-expanded="true">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tournament Id</th>
                        <th>Tournament Title</th>
                        <th>Prize Pool</th>
                        <th>Player Type</th>
                        <th>Winner</th>
                        <th>time Start</th>
                        <th>Game Type</th>
                        <th>Entry Fee</th>
                        <th>No of Tables</th>
                        <th>Tournament Details</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($ongoingtournaments as $key =>$result)
                      <tr>
                        <td><span class="font-weight-bold">{{ $ongoingtournaments->firstItem() + $key }}</span></td>
                        <td>{{ $result->tournament_id }}</td>
                        <td>{{ $result->tournament_name }}</td>
                        <td>{{ $result->prize_pool }} <i class="las la-rupee-sign"></i></td>
                        <td>{{ $result->player_type }}</td>
                        <td>{{ $result->winner }} <i class="las la-users"></i></td>
                        <td>{{ $result->time_start }}</td>
                        <td>{{ $result->game_type }}</td>
                        <td>{{ $result->entry_fee }}</td>
                        <td>{{ $result->nooftables }}</td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu{{ $key }}" data-toggle="collapse" data-target="#collapseData{{ $key }}" aria-expanded="false" aria-controls="collapseData{{ $key }}">
                              v
                            </button>
                          </div>
                        </td>
                        <td>
                          <form method="POST" action="{{ route('delete.tournaments', ['tournament_id' => $result->tournament_id]) }}">
                            @csrf <!-- CSRF protection for POST requests -->
                            @method('DELETE') <!-- Method spoofing for DELETE request -->
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="11" class="p-0">
                          <div class="collapse" id="collapseData{{ $key }}">
                            <div class="card card-body">
                              <p>
                                <strong>Tournament ID:</strong> {{ $result->tournament_id }}<br>
                                <strong>Tournament Name:</strong> {{ $result->tournament_name }}<br>
                                <strong>Prize Pool:</strong> {{ $result->prize_pool }}<br>
                                <!-- Display other tournament details -->
                              </p>
                              <br>
                              <strong>Tables:</strong><br>

                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Table ID</th>
                                    <th>Game Name</th>
                                    <th>Player ID 1</th>
                                    <th>Player ID 2</th>
                                    <th>Player ID 3</th>
                                    <th>Player ID 4</th>
                                    <th>Winner</th>
                                    <th>Status</th>
                                    <th>Updated At</th>
                                    <th>Created At</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @if(isset($result->tables) && !empty($result->tables))
                                  @if(isset($result->tables) && !$result->tables->isEmpty())
                                  @foreach($result->tables as $key => $table)
                                  <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $table->table_id ?? 'N/A' }}</td>
                                    <td>{{ $table->game_name ?? 'N/A' }}</td>
                                    <td>{{ $table->player_id1 ?? 'N/A' }}
                                      <a href="{{url('admin/player/view/'.Crypt::encrypt($table->player_id1))}}">
                                        <button type="button" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-icon btn-icon rounded-circle btn-success bg-darken-4 border-0 view_buuton"><i class="las la-eye"></i>
                                        </button>
                                      </a>
                                    </td>
                                    <td>{{ $table->player_id2 ?? 'N/A' }}
                                      <a href="{{url('admin/player/view/'.Crypt::encrypt($table->player_id2))}}">
                                        <button type="button" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-icon btn-icon rounded-circle btn-success bg-darken-4 border-0 view_buuton"><i class="las la-eye"></i>
                                        </button>
                                      </a>
                                    </td>
                                    <td>{{ $table->player_id3 ?? 'N/A' }}
                                      <a href="{{url('admin/player/view/'.Crypt::encrypt($table->player_id3))}}">
                                        <button type="button" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-icon btn-icon rounded-circle btn-success bg-darken-4 border-0 view_buuton"><i class="las la-eye"></i>
                                        </button>
                                      </a>
                                    </td>
                                    <td>{{ $table->player_id4 ?? 'N/A' }}
                                      <a href="{{url('admin/player/view/'.Crypt::encrypt($table->player_id4))}}">
                                        <button type="button" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-icon btn-icon rounded-circle btn-success bg-darken-4 border-0 view_buuton"><i class="las la-eye"></i>
                                        </button>
                                      </a>
                                    </td>
                                    <td>{{ $table->winner ?? 'N/A' }}</td>
                                    <td>{{ $table->status ?? 'N/A' }}</td>
                                    <td>{{ $table->updated_at ?? 'N/A' }}</td>
                                    <td>{{ $table->created_at ?? 'N/A' }}</td>
                                  </tr>
                                  @endforeach
                                  @endif
                                  @endif
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="my-1">
                {{ $tournaments->onEachSide(3)->links('vendor.pagination.custom') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- END: Content-->
@endsection
@section('js')
<script>
  $(document).ready(function() {
    $('#deleteButton').on('click', function(e) {
      e.preventDefault();

      var tournamentId = $('#tournamentId').val(); // Replace this with how you fetch the tournament ID from your form

      $.ajax({
        url: '/tournament/delete/' + tournamentId,
        type: 'DELETE', // Send a DELETE request
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          // Handle success response
          console.log(response);
          // Check if the deletion was successful
          if (response.success) {
            // Reload the page after successful deletion
            location.reload(true); // Reloads the page from the server
          } else {
            console.log('Deletion unsuccessful.');
          }
        },
        error: function(xhr, status, error) {
          // Handle error response
          console.error(error);
        }
      });

      return false; // Prevent further propagation and default action
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#deleteAllForm').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: $(this).attr('action'),
        type: 'DELETE', // Sending a DELETE request
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          // Handle success response
          console.log(response);
          // Reload the page after successful deletion
          location.reload();
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