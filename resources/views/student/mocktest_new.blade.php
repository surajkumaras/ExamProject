@extends('layout.student-layout')
@section('space-work')
  <style>
    body {
      background-color: #f8f9fa;
    }

    .card-custom {
      border-radius: 16px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease-in-out;
      text-align: center;
      padding: 20px;
  
      opacity: 0.6;
      background-color: rgb(76, 156, 32);
      /* background: linear-gradient(to top, #dcd5b6 50%, #c5d9c4 90%) */
    }

    .card-custom:hover {
      transform: scale(1.05);
    }

    .card-custom img {
      width: 50px;
      height: 50px;
      margin-bottom: 10px;
    }

    .card-title {
      font-size: 12px;
    font-weight: bold;
    color: #0e0e0e;
    opacity: 1;
    }

    .card-container {
      margin-top: 20px;
    }

    /* Ensuring cards are well spaced */
    .card-container .col {
      margin-bottom: 15px;
    }

    .col-6 {
        margin-bottom: 5%;
    }
  </style>


  <div class="container">
    <h2 class="text-center mt-4 text-uppercase">Subjects</h2>

    <div class="row card-container">
      <!-- Card 1 -->
      @foreach ($subjects as $subject)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('categorySubject', ['subject_id' => $subject->id]) }}" style="text-decoration: none;">
                <div class="card-custom">
                    <img src="https://via.placeholder.com/50" alt="{{ $subject->name }}">
                    <div class="card-title">{{ $subject->name }}</div>
                </div>
            </a>
        </div>
      @endforeach
    </div>
  </div>

@endsection