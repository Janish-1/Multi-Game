@extends('admin.layout.master')
@section('title')
Lucky Number
@endsection
@section('css')
<!--  link custom css link here -->
@endsection
@section('content')
<!-- BEGIN: Content-->
<!-- Buttons in the Middle -->
<div class="d-flex justify-content-center mt-3">
  <button class="btn btn-info mr-2">Start Game</button>
  <button class="btn btn-warning">Stop Game</button>
</div>
<br>
<div class="row justify-content-center">
  <!-- Table in the Middle -->
  <div class="col-md-7 col-12">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Date</th>
          <th scope="col">Pick</th>
          <th scope="col">Start Time</th>
          <th scope="col">Lock Time</th>
          <!-- Add more columns as needed -->
        </tr>
      </thead>
      <tbody>
        <!-- Add your data rows here -->
      </tbody>
    </table>
  </div>

  <div class="col-12 mt-3">
    <!-- Form Below the Table -->
    <form>
      <!-- Input Fields -->
      <div class="form-group">
        <label for="inputField1">Set Reward Ball</label>
        <input type="text" class="form-control" id="inputField1">
      </div>

      <div class="form-group">
        <label for="inputField2">Set Reward Amount</label>
        <input type="text" class="form-control" id="inputField2">
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
  </div>
</div>
<!-- END: Content -->
@endsection

@section('js')
<!-- link custom js link here -->
<script src="{{ URL::asset('admin-assets/css/custom/js/luckyspin/luckyspin.js') }}"></script>
<!-- Add your custom JavaScript for toggle, automation, locking game, and payouts -->
@endsection