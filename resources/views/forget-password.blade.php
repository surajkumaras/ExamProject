@extends('layout.layout-common')

@section('space-work')

<h1>Forget Password</h1>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <p style="color:red;"> {{ $error}}</p>
    @endforeach
@endif
    <form action="{{route('forgetPassword')}}" method="post">
        @csrf
        
        <input type="email" name="email" placeholder="Enter email">
        <br><br>
        
        
        <input type="submit" value="Forget password">
    </form>
    <a href="/login">Login</a>
    @if (Session::has('error'))
        <p style="color: red">{{ Session::get('error')}}</p>
    @endif

    @if (Session::has('success'))
        <p style="color: rgb(42, 159, 21)">{{ Session::get('error')}}</p>
    @endif
@endsection