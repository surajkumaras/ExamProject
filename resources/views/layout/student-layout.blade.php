<!doctype html>
<html lang="en">
  <head>
  	<title>Online Examination System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Exam-PNG-File.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="{{ asset('css/style.css')}}">
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/multiselect-dropdown.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <style>
      /* body {
            height: 100vh;
            background: linear-gradient(to top, #c9c9ff 50%, #ababfe 90%) no-repeat
        }
      .multiselect-dropdown{
        width: 100% ! important;
      } */

      .wrapper {
    position: relative;
}

#sidebar {
    position: fixed;
    top: 0;
    /* left: -250px; */
    width: 250px;
    height: 100%;
    background: #343a40;
    /* background-color: rgb(0,0,0); */
  background-color: rgba(39, 38, 38, 0.9);
    z-index: 1000;
    transition: all 0.5s ease;
}

#sidebar.active {
    left: 0; 
}

#content {
    width: 100%;
    padding: 20px;
    transition: all 0.3s ease;
}

.custom-menu {
    position: absolute;
    top: 10px;
    right: 10px;
}

#sidebarCollapse {
    background-color: #343a40;
    border: none;
    color: #fff;
}

.home-link {
    position: fixed;
    top: 10px; /* Adjust this value to move the link vertically */
    right: 10px; /* Adjust this value to move the link horizontally */
    z-index: 1000; /* Ensures it stays above other elements */
    /* background-color: #f0f0f0; Optional: adds background color */
    padding: 5px 10px; /* Optional: adds some padding */
    border-radius: 5px; /* Optional: adds rounded corners */
    text-decoration: none; /* Removes the underline from the link */
    color: #333; /* Text color */
}

.home-link:hover {
    /* background-color: #ddd; Changes background color on hover */
    color: #ddd; 
}

@media(max-width: 360px)
 {
  body {
      height: 100%
  }
}
    </style>
  </head>
  <body>
    @php
      use App\Models\Company;
      $company = Company::first();

    @endphp
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
        <h1>
          <a href="index.html" class="logo">
              @if ($company && $company->logo)
                  <img src="{{ asset('uploads/logo/' . $company->logo) }}" alt="{{ $company->name }}" style="height: 50px;">
              @endif
              {{-- {{ $company->name }} --}}
          </a>
      </h1>
        
	  		{{-- <h1><a href="javascript:void(0)" class="logo">HII ,{{ Auth::user()->name}}</a></h1> --}}
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="{{ route('admin.dashboard')}}"><span class="fa fa-home mr-3"></span> Homepage</a>
          </li>
          <li>
              <a href="{{ route('studentProfile')}}"><span class="fa fa-user mr-3"></span> Profile</a>
          </li>
          <li>
            <a href="{{ route('resultDashboard')}}"><span class="fa fa-list-alt mr-3"></span> Results</a>
          </li>
          <li>
            <a href="#"><span class="fa fa-graduation-cap mr-3"></span> Free Exam</a>
          </li>
          {{-- <li>
            <a href="{{ route('examDashboard')}}"><span class="fa fa-tasks mr-3"></span> Paid Exams</a>
          </li> --}}
          <li>
            <a href="{{ route('mockTest')}}"><span class="fa fa-flash mr-3"></span>  Mock Test</a>
          </li>
          <li>
            <a href="/question/show"><span class="fa fa-book mr-3"></span> Question Bank</a>
          </li>
          <li>
            <a href="/logout"><span class="	fa fa-comments-o mr-3"></span> Contact Us</a>
          </li>
          <li>
            <a href="/logout"><span class="fa fa-sign-out mr-3"></span> Logout</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
        {{-- <a href="/" >Home</a> --}}
        <a href="{{ route('admin.dashboard')}}" class="home-link"><span class="fa fa-home mr-3" style="font-size:24px"></span></a>
        @yield('space-work')
        
      </div>
		</div>

    {{-- <script src="{{ asset('js/jquery.min.js')}}"></script> --}}
    <script src="{{ asset('js/popper.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
      $(document).ready(function(){
          $('.dropify').dropify();
      });

      $(document).ready(function () 
      {
        // Ensure the sidebar starts closed
        $('#sidebar').removeClass('active');

        // Toggle the sidebar when the button is clicked
        // $('#sidebarCollapse').on('click', function () {
        //     $('#sidebar').toggleClass('active');
        // });
    });

    $(window).on('offline', function() 
    {
      Swal.fire({
                    title: 'No !nternet',
                    text: 'You are offline. Please check your internet connection.',
                    // imageUrl: "{{ asset('images/nointernet.webp') }}",
                    imageWidth: 100,
                    imageHeight: 100,
                    imageAlt: 'No Internet',
                    icon: "warning",
                });
    });

    $(window).on('online', function() 
    {
      
    });
  </script>
  </body>
</html>