<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Web Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add any custom styles here */
        .navbar {
            background-color: #1A237E;
        }
        .navbar-brand {
            color: white;
        }
        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        /* Custom Footer */
        footer {
            background-color: #1A237E;
            color: white;
            padding: 20px 0;
        }
        .dashboard-container {
            padding: 20px;
        }
        .quick-links, .calendar {
            background-color: #f8f9fa;
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

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SSC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

<div class="container dashboard-container">
    <!-- Quick Links Section -->
    <div class="quick-links">
        <h4>Quick Links</h4>
        <div class="row">
            <div class="col-6 col-md-3">
                <button class="btn btn-primary w-100">Apply</button>
            </div>
            <div class="col-6 col-md-3">
                <button class="btn btn-info w-100">Admit Card</button>
            </div>
            <div class="col-6 col-md-3">
                <button class="btn btn-warning w-100">Answer Key</button>
            </div>
            <div class="col-6 col-md-3">
                <button class="btn btn-success w-100">Result</button>
            </div>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="calendar">
        <h4>Exam Notice</h4>
        <div class="event">
            <span class="event-date">5 Jan</span> - Grade 'C' Stenographer Limited Departmental Competitive Examination, 2023-2024
        </div>
        <div class="event">
            <span class="event-date">12 Jan</span> - JSA/ LDC Grade Limited Departmental Competitive Examination, 2023-2024
        </div>
        <div class="event">
            <span class="event-date">19 Jan</span> - SSA/ UDC Grade Limited Departmental Competitive Examination, 2023-2024
        </div>
        <div class="event">
            <span class="event-date">1 Feb</span> - Selection Post Examination, Phase-XII, 2024
        </div>
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
</body>
</html>
