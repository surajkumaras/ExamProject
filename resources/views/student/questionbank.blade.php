@extends('layout.student-layout')

@section('space-work')
    <h1>Question Bank</h1>
    <hr>
    <h2 class="text-uppercase">Subjects</h2>

    <div class="container">
        <div class="row">
            @foreach($subjects as $subject)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card text-center" style="width: 100%;">
                        <div class="card-body" style="background-color: #d1d2d3; color: #343a40; padding: 20px; border-radius: 5px;">
                            <h5 class="card-title" style="color: #007bff;">{{ $subject->name }}</h5>
                            <p class="card-text"></p>
                            <a href="{{ route('categoryQue', $subject->id)}}" class="btn btn-primary">Check</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
@endsection