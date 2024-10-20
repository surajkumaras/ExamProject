<!doctype html>
<html lang="en">
  <head>
  	<title>Online Examination System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
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
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
      .multiselect-dropdown{
        width: 100% ! important;
      }

      .header {
      background-color: #efdc13;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .container {
      background-color: #efecec;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="{{ route('admin.dashboard')}}"><span class="fa fa-home mr-3"></span> Homepage</a>
          </li>
          <li>
            <a href="/admin/students"><span class="fa fa-group mr-3"></span> Students</a>
          </li>
          <li>
            <a href="/subject"><span class="fa fa-book mr-3"></span> Subjects</a>
          </li>
          <li>
            <a href="/category"><span class="fa fa-cubes mr-3"></span> Category</a>
          </li>
          <li>
            <a href="/admin/exams"><span class="fa fa-tasks mr-3"></span> Exams</a>
          </li>
          <li>
            <a href="/admin/marks"><span class="fa fa-check mr-3"></span> Marks</a>
          </li>
          <li>
            <a href="/admin/qna-ans"><span class="fa fa-question-circle mr-3"></span> Q & A</a>
          </li>
          <li>
            <a href="/admin/review-exams"><span class="fa fa-file-text-o mr-3"></span> Exam Review</a>
          </li>
          <li>
            <a href="{{route('examReview')}}"><span class="fa fa-file-text-o mr-3"></span> Exam Review New</a>
          </li>
          <li>
              <a href="{{ route('settingDashboard')}}"><i class="fa fa-cog fa-spin" style="font-size:20px"></i>  Setting</a>
          </li>
          <li>
            <a href="{{ route('config')}}"><i class="fa fa-gears mr-3"></i> Configuration</a>
          </li>
          <li>
            <a href="{{ route('banner.index')}}"><span class="fa fa-group mr-3"></span> Banner</a>
          </li>
          {{-- <li>
            <a href="/question/show"><span class="fa fa-book mr-3"></span> Question Bank</a>
          </li> --}}
          <li>
            <a href="/logout"><span class="fa fa-sign-out mr-3"></span> Logout</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
        @yield('space-work')
        
      </div>
		</div>

    {{-- <script src="{{ asset('js/jquery.min.js')}}"></script> --}}
    <script src="{{ asset('js/popper.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/main.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
      $(document).ready(function(){
          $('.dropify').dropify();
          $('#myTable').DataTable();
      });
  </script>
  </body>
</html>