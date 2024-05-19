@extends('layout.student-layout')

@section('space-work')
    <h1>Question Bank</h1>

    <div class="container">
        <div class="row">
            @foreach($subjects as $subject)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card text-center" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $subject->name }}</h5>
                            <p class="card-text"></p>
                            <a href="{{ route('categoryQue', $subject->id)}}" class="btn btn-primary">Click me</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
@endsection