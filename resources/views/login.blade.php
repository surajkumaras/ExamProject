@extends('layout.layout-common')

@section('space-work')

<h1>Login</h1>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p style="color:red;"> {{ $error}}</p>
    @endforeach
@endif
    <form action="{{route('userLogin')}}" method="post">
        @csrf
        
        <input type="email" name="email" value="{{ old('email')}}" placeholder="Enter email">
        <br><br>
        <input type="password" name="password" placeholder="Enter password">
        <br><br>
        
        <input type="submit" value="Login">
    </form>
    <a href="/forget-password" class="btn btn-success">forget password</a>
    <a href="{{ route('register')}}" class="btn btn-info">Create a new account</a>
    @if (Session::has('error'))
        <p style="color: red">{{ Session::get('error')}}</p>
    @endif
@endsection