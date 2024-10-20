<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Web Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        /* Custom Footer */
        footer {
            background-color: #1A237E;
            color: white;
            padding: 20px 0;
            /* width: 100%; */
        }
        .dashboard-container {
            padding: 20px;
        }
        .quick-links, .calendar {
            /* background-color: #5cbdb9; */
            background: linear-gradient(to top, #c1f4f5 10%, #5cbdb9 90%);
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .quick-links .btn {
            margin-bottom: 10px;
        }
        .calendar h4 {
            margin-bottom: 15px;
        }
        .calendar .event {
            padding: 10px;
            background-color: #e9ecef;
            border-left: 5px solid #6c757d;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .event-date {
            font-weight: bold;
            color: #6c757d;
        }

        .btn 
        {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .container {
    width: 100%;
    padding-right: 0px !important;
    padding-left: 0px !important;
    margin-right: auto; /* Use 'auto' instead of a percentage for more predictable behavior */
    margin-left: 0%;
}


        @media(max-width: 360px) {
            .carousel-item img {
                width: 100%;
                height: 150px;
                object-fit: cover;
            }

         }


    </style>
</head>
<body>
    @extends('layout.student-layout')

    @section('space-work')

    <!-- Carousel Section -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://via.placeholder.com/1200x500" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1200x500" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1200x500" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Main Content Section -->

    <div class="container-fluid dashboard-container">
        <!-- Quick Links Section -->
        <div class="quick-links">
            <h4>Quick Links</h4>
            <div class="row d-flex justify-content-center">
                <div class="col-6 col-md-3">
                    <a href="{{ route('admin.dashboard')}}"><button class="btn btn-primary w-100">Profile <i class="fa fa-user-circle-o"></i></button></a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('studentProfile')}}"><button class="btn btn-info w-100">Results <i class="fa fa-sticky-note-o"></i></button></a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('resultDashboard')}}"><button class="btn btn-warning w-100">Free Exam <i class="fa fa-laptop"></i></button></a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('mockTest')}}"><button class="btn btn-success w-100">Mock Test <i class="fa fa-pencil-square-o"></i></button></a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/question/show"><button class="btn btn-success w-100">Questions <i class="fa fa-folder-open-o"></i></button></a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="#"><button class="btn btn-success w-100">Contact Us <i class="fa fa-comments-o"></i></button></a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="/logout"><button class="btn btn-success w-100">Logout <span class="fa fa-sign-out mr-3"></button></a>
                </div>
            </div>
        </div>

        <!-- Calendar Section -->
        <div class="calendar">
            <h4>Exam Notice</h4>
            
            @foreach ($exams as $exam)
                <div class="event">
                    @php
                        $examDate = \Carbon\Carbon::parse($exam->date); // Convert string to Carbon instance
                    @endphp

                    <span class="event-date">Exam Date: {{ $examDate->format('d M, Y') }}</span> - {{ $exam->exam_name }} 
                    
                    
                    @if($exam->date < \Carbon\Carbon::today()->toDateString())
                        <span class="badge badge-danger">Expired</span>
                    @elseif ($exam->date > \Carbon\Carbon::today()->toDateString())
                        <span class="badge badge-warning">Coming Soon</span>
                    @else
                        <a href="{{ url('/exam/' . $exam->enterance_id) }}"><i class="badge badge-secondary"></i>Link</a>
                        <span class="badge badge-success">Live</span>
                    @endif

                </div>
            @endforeach
            
        </div>
    </div>
   <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; 2024 Online Examination System</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
</body>
</html>
