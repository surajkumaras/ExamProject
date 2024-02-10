@extends('layout.layout-common')

@section('space-work')

<h1>Register</h1>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p style="color:red;"> {{ $error}}</p>
    @endforeach
@endif
    <form action="{{route('studentRegister')}}" method="post">
        @csrf
        <input type="text" name="name" id="name" placeholder="Enter name">
        <br><br>
        <input type="email" name="email" placeholder="Enter email">
        <br><br>
        <input type="password" name="password" placeholder="Enter password">
        <br><br>
        <input type="password" name="password_confirmation" placeholder="Enter confirm password">
        <br><br>
        <input type="submit" value="Register">
    </form>

    @if (Session::has('success'))
        <p style="color: green">{{ Session::get('success')}}</p>
    @endif
@endsection