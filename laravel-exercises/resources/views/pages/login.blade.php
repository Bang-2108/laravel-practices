@extends('master')
@section('content')
<div class="container">
  <div id="content">
    @include('error')
    <form action="login" method="POST" class="beta-form-checkout">
      @csrf
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
          <h4>Đăng nhập</h4>
          <div class="space20">&nbsp;</div>

          <div class="form-block">
            <label for="email">Email address*</label>
            <input type="email" id="email" name="email" required>
          </div>

          <div class="form-block">
            <label for="password">Password*</label>
            <input type="password" id="password" name="password" required>
          </div>

          <div class="form-block">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>

        </div>
        <div class="col-sm-3"></div>
      </div>
    </form>
  </div> <!-- #content -->
</div>
@endsection
