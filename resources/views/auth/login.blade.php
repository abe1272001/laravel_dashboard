@extends('layouts.app')
@section('content')
  <div class="container vh-100">
    <div class="d-flex flex-column h-100 justify-content-start align-items-center mt-5">
      <form method="post" action="/login">
        @csrf
        <h2>Login Page</h2>
        @if (session('error'))
          <div class="alert alert-danger" role="alert">
            {{session('error')->message}}
          </div>
        @endif
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" value="{{old('email')}}">
          <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>
        <!--<div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div> -->
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
@endsection