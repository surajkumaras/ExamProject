@extends('layout.student-layout')
@section('space-work')
  <style>
    body {
      background-color: #f8f9fa;
    }

    .card-custom {
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease-in-out;
      text-align: center;
      padding: 20px;
      /* background-color: white; */
      background: linear-gradient(to top, #dcd5b6 50%, #e3cf8f 90%) no-repeat
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
      font-size: 16px;
      font-weight: bold;
      color: #333;
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
    <h2 class="text-center mt-4">Mock Test</h2>

    <div class="row card-container">
      <!-- Card 1 -->
      @foreach ($categories as $category)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('categoryExam', ['category_id' => $category->id]) }}" style="text-decoration: none;">
                <div class="card-custom">
                    <img src="https://via.placeholder.com/50" alt="{{ $category->name }}">
                    <div class="card-title">{{ $category->name }}</div>
                </div>
            </a>
        </div>
      @endforeach

      

    </div>
  </div>

@endsection