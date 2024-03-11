@extends('admin.layout.master')
@section('title')
Lucky Number
@endsection
@section('css')
<style>
  .scrollable-table {
    max-height: 300px;
    /* Set the max height as per your requirement */
    overflow-y: auto;
    border: 1px solid #ddd;
    /* Add a border for clarity */
  }
</style>
@endsection
@section('content')
<!-- BEGIN: Content-->
<!-- Buttons in the Middle -->
<div class="d-flex justify-content-center mt-3">
  <button id="startgamebutton" class="btn btn-info mr-2">Start Game</button>
  <button id="stopgamebutton" class="btn btn-warning mr-2">Stop Game</button>
  <button id="lockgamebutton" class="btn btn-danger mr-2">Lock Game</button>
  <button id="payoutplayers" class="btn btn-info mr-2">Payout Players</button>
</div>
<br>
<div class="row justify-content-center">
  <!-- Table in the Middle -->
  <div class="col-md-7 col-12">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Game ID</th>
          <th scope="col">Game Status</th>
          <th scope="col">Win Number</th>
          <th scope="col">Created At</th>
          <th scope="col">Updated At</th>
        </tr>
      </thead>
      @if($matkaGame)
      <tbody id="activeLuckyNumTable">
        <tr>
          <td>{{ $matkaGame->id }}</td>
          <td>{{ $matkaGame->mid }}</td>
          <td>{{ $matkaGame->mstatus }}</td>
          <td>{{ $matkaGame->mwinball }}</td>
          <td>{{ $matkaGame->created_at }}</td>
          <td>{{ $matkaGame->updated_at }}</td>
        </tr>
      </tbody>
      @else
      <tbody>
        <tr>
          <td colspan="7">No Data Available for Active Games.</td>
        </tr>
      </tbody>
      @endif
    </table>
  </div>
</div>
<div class="row justify-content-center">
  <!-- Table in the Middle -->
  <div class="col-md-7 col-12">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Game ID</th>
          <th scope="col">Player Pick</th>
          <th scope="col">Ball Value</th>
          <th scope="col">Player ID</th>
          <th scope="col">Bid Amount</th>
          <th scope="col">Winner</th>
        </tr>
      </thead>
      @if($matkaNumbers && count($matkaNumbers) > 0)
      <tbody id="activeLuckyNumTable">
        @foreach($matkaNumbers as $row)
        <tr>
          <td>{{ $row->ID }}</td>
          <td>{{ $row->mid }}</td>
          <td>{{ $row->mpick }}</td>
          <td>{{ $row->mvalue }}</td>
          <td>{{ $row->mplayer }}</td>
          <td>{{ $row->mbid }}</td>
          <td>{{ $row->winner }}</td>
        </tr>
        @endforeach
      </tbody>
      @else
      <tbody>
        <tr>
          <td colspan="7">No Data Available for player picks.</td>
        </tr>
      </tbody>
      @endif
    </table>
  </div>

  <div class="col-md-5 col-12">
    @if($pickCounts && count($pickCounts) > 0)
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Player Pick</th>
          <th scope="col">Count</th>
        </tr>
      </thead>
      <tbody id="secondTable">
        @foreach($pickCounts as $pick => $count)
        <tr>
          <td>{{ $pick }}</td>
          <td>{{ $count }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Player Pick</th>
          <th scope="col">Count</th>
        </tr>
      </thead>
      <tbody id="secondTable">
        <tr>
          <td colspan="2">No data available for player picks.</td>
        </tr>
      </tbody>
    </table>
    @endif
  </div>

  <div class="col-12 mt-3">
    <!-- Form Below the Table -->
    <form>
      <!-- Input Fields -->
      <div class="form-group">
        <label for="inputField1">Game ID</label>
        <input type="text" class="form-control" id="inputField1">
      </div>

      <div class="form-group">
        <label for="inputField2">Set Win Ball</label>
        <input type="text" class="form-control" id="inputField2">
      </div>

      <!-- Submit Button -->
      <button id="setwinball" type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
  </div>
</div>
<!-- END: Content -->
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ URL::asset('admin-assets/css/custom/js/luckyspin/luckyspin.js') }}"></script>
<script>
  $(document).ready(function() {
    // Attaching a click event handler for the Start Game button
    $('#startgamebutton').on("click", function() {
      $.ajax({
        url: "http://localhost:8000/api/creatematka",
        method: "POST",
        success: function(response) {
          console.log("API call successful", response);
          location.reload();
        },
        error: function(error) {
          console.error("API call failed", error);
        }
      });
    });

    // Attaching a click event handler for the Stop Game button
    $('#stopgamebutton').on("click", function() {
      $.ajax({
        url: "http://localhost:8000/api/closegame",
        method: "POST",
        success: function(response) {
          console.log("API call successful", response);
          location.reload();
        },
        error: function(error) {
          console.error("API call failed", error);
        }
      });
    });

    $('#setwinball').on("click", function() {
      // Get the values from the input fields
      var gameId = $('#inputField1').val();
      var setWinBall = $('#inputField2').val();

      // Prepare the data to be sent
      var requestData = {
        mid: gameId,
        mwinball: setWinBall
      };
      $.ajax({
        url: "http://localhost:8000/api/setwinamount",
        method: "POST",
        data: requestData, // Include the data here
        success: function(response) {
          console.log("API call successful", response);
          location.reload();
        },
        error: function(error) {
          console.error("API call failed", error);
        }
      });
    });

    $('#payoutplayers').on("click", function() {
      $.ajax({
        url: "http://localhost:8000/api/payoutplayers",
        method: "POST",
        success: function(response) {
          console.log("API call successful", response);
          location.reload();
        },
        error: function(error) {
          console.error("API call failed", error);
        }
      });
    });

    $('#lockgamebutton').on("click",function (){
      $.ajax({
        url: "http://localhost:8000/api/makegameinactive",
        method: "POST",
        success: function(response) {
          console.log("API call successful", response);
          location.reload();
        },
        error: function(error) {
          console.log("API call failed", error);
        }
      });
    });
  });
</script>
@endsection