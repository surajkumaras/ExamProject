@extends('layout.admin-layout')

@section('space-work')
<h2 class="mb-4">Dashboard</h2>

<div class="container">
  <div class="row">
    
    <div class="col-md-3">
      <div class="card border-info mb-3" style="max-width: 18rem;">
        <div class="card-header"><a href="{{ route('studentDashboard')}}">Total Students <i class="fa fa-group" style="font-size:36px"></i></a></div>
        <div class="card-body text-info">
          <h5 class="card-title"><span class="count" data-count="{{ $students }}">0</span></h5>
          {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-info mb-3" style="max-width: 18rem;">
        <div class="card-header"><a href="{{ route('examDassboard')}}">Total Exams <i class="fa fa-file-text-o" style="font-size:36px;"></i></a></div>
        <div class="card-body text-info">
          <h5 class="card-title"><span class="count" data-count="{{ $exams }}">0</span></h5>
          {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-info mb-3" style="max-width: 18rem;">
        <div class="card-header"><a href="{{ route('qnaDashboard')}}"> Total Questions <i class="fa fa-stack-overflow" style="font-size:36px"></i></a></div>
        <div class="card-body text-info">
          <h5 class="card-title"><span class="count" data-count="{{ $questions }}">0</span></h5>
          {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-info mb-3" style="max-width: 18rem;">
        <div class="card-header"><a href="{{ route('subject')}}"> Total Subjects <i class="fa fa-files-o" style="font-size:36px;"></i></a></div>
        <div class="card-body text-info">
          <h5 class="card-title"><span class="count" data-count="{{ $subjects }}">0</span></h5>
          {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card border-info mb-3" style="max-width: 18rem;">
        <div class="card-header"><a href="#">Total E-Books <i class="fa fa-book" style="font-size:36px"></i></div>
        <div class="card-body text-info">
          <h5 class="card-title"><span class="count" data-count="{{ $subjects }}">0</span></h5>
          {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
        </div>
      </div>
    </div>
    
  </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

<script>
$(document).ready(function() {
  $('.count').each(function() {
    $(this).prop('Counter', 0).animate({
      Counter: $(this).data('count')
    }, {
      duration: 2000,
      easing: 'swing',
      step: function(now) {
        $(this).text(Math.ceil(now));
      }
    });
  });
});
</script>


@endsection