@extends('layouts.app')
@section('content')
    <div class="container-fluid">
      <div class="row">
        <nav id="navbarNav" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
          <div class="position-sticky pt-3">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('dashboard')}}">Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="#">報表1</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">報表2</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">報表3</a>
              </li>
            </ul>
          </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1>Dashboard</h1>
            <div class="btn-group">
              {{-- <form action="/catchData" method="post"> --}}
                {{-- @csrf --}}
                <a href="{{route('catchData')}}" class="btn btn-primary" aria-current="page">爬帳</a>
              {{-- </form> --}}
              <a href="{{route('refreshToken')}}" class="btn btn-success">Refresh token</a>
              {{-- <form action="{{route('tableDelete')}}" method="POST">
                @csrf --}}
                <a href="{{route('tableDelete')}}" class="btn btn-danger">刪除資料表</a>
              {{-- </form> --}}
            </div>
          </div>
          @if (session('tokenStatus'))
          <div class="alert alert-success" role="alert">
            Refresh Token {{session('tokenStatus')}}
          </div>
          
              
          @endif
          @if (session('error'))
          <div class="alert alert-danger" role="alert">
            {{session('error')->message}}
          </div>
          @endif
          <p>
            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
              進階查詢
            </a>
          </p>
          <div class="collapse" id="collapseExample">
            <form action="{{route('search')}}" method="GET">
              @csrf
              <div class="card card-body">
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
                </div>
                <div class="mb-3">
                  <label for="id" class="form-label">ID</label>
                  <input type="number" class="form-control" id="id" placeholder="id" name="id">
                </div>
                <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" placeholder="name" name="name">
                </div>
                <button type="submit" class="btn btn-primary">查詢</button>
              </div>
            </form>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">user_id</th>
                  <th scope="col">name</th>
                  <th scope="col">email</th>
                </tr>
              </thead>
              <tbody>
                @if (count($users))
                  @foreach ($users as $user)
                  <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->user_id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                  </tr>
                  @endforeach
                @else
                    <tr>
                      <td colspan="4">Results Not Found</td>
                    </tr>
                @endif
                
              </tbody>
            </table>
            {{$users->links('pagination.default')}}
          </div>
        </main>
      </div>
    </div>
@endsection