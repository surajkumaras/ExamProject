@extends('layout.student-layout')

@section('space-work')
    <h1>Topics</h1>

    <div class="container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card text-center" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text">Total Questions {{$totalQue}}</p>
                            <div class="row">
                                <a href="{{ route('downloadQuePdf', $category->id) }}" class="btn btn-primary">Download PDF</a> &nbsp;
                                <a href="{{ route('categoryQueBank', $category->id) }}" class="btn btn-primary">View</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection