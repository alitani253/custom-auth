@extends('layout')
@section('title','Login')
@section('content')

<div class="container">

    <div class="mt-5">

        @if ($errors->any())
        <div class="col-12">

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger"> {{$error}} </div>
            @endforeach

        </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

    </div>


    <form  action="{{ route('login.post') }}" method="POST" class="ms-auto me-auto mt-4"  style="width: 500px">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" placeholder="Enter your mail" class="form-control" name="email">
          </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" placeholder="Enter your password" class="form-control" name="password">
        </div>
        <div>
            <a href="{{route("forget.password")}}"> forget password </a>
        </div><br>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

</div>

@endsection
