@extends('layout.student-layout')

@section('space-work')
<style>
    /* .custom-card-body {
    background-color: #758a9f; 
    color: #343a40;          
    padding: 20px;            
    border-radius: 10px;     
    } */

    .custom-card-title {
        color: #007bff;           /* Blue color for the title */
    }
</style>
    <h1>Topics</h1>

    <div class="container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card text-center" style="width: 100%;">
                        <div class="card-body" style="background-color: #d1d2d3; color: #343a40; padding: 20px; border-radius: 5px;">
                            <h5 class="card-title" style="color: #007bff;">{{ $category->name }}</h5>
                            <p class="card-text">Total Questions {{$category->question_count}}</p>
                            <div class="row">
                                <a href="{{ route('downloadQuePdf', $category->id) }}" class="btn btn-success">Download PDF</a> &nbsp;
                                <a href="{{ route('categoryQueBank', $category->id) }}" class="btn btn-primary">View</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection