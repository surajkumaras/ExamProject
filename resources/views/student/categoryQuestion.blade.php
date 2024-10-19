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
    <h1 class="text-uppercase">Subjects</h1>

    <div class="container">
        <div class="row">
            @foreach($categories as $category)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card text-center" style="width: 100%;">
                        <div class="card-body" style="background-color: #d1d2d3; color: #343a40; padding: 20px; border-radius: 5px;">
                            <h5 class="card-title" style="color: #007bff;">{{ $category->name }}</h5>
                            <p class="card-text">Total Questions {{$category->question_count}}</p>
                            @if($category->question_count > 0)
                                <div class="row">
                                    {{-- <a href="{{ route('downloadQuePdf', $category->id) }}" class="btn btn-success">Download PDF</a> &nbsp; --}}
                                    <a href="#" id="downloadPdfBtn" class="btn btn-success downloadPdfBtn" data-url="{{ route('downloadQuePdf', $category->id) }}">Download PDF</a>
                                    <a href="{{ route('categoryQueBank', $category->id) }}" class="btn btn-primary">View</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="loader-wrapper" style="display: none;">
        <img src="{{ asset('images/loder.gif') }}" style="width: 100px; height: 100px;" alt="Loader image">
        <div>Please wait ...</div>
    </div>
    <script>
        $(document).ready(function() {
            $('.downloadPdfBtn').click(function(e) 
            {
                e.preventDefault();
                // Show the loader
                $('.loader-wrapper').show();
        
                // Get the download URL from the data attribute
                var url = $(this).data('url');
        
                var categoryName = $(this).closest('.card-body').find('.card-title').text().trim(); // Or get from data if stored
                var sanitizedCategoryName = categoryName.replace(/[^A-Za-z0-9\-]/g, '_');

                // Perform an AJAX request
                $.ajax({
                    url: url,
                    method: 'GET',
                    xhrFields: 
                    {
                        responseType: 'blob' // Ensures the response is treated as a file
                    },
                    success: function(data) 
                    {
                        // Create a new Blob object using the response data
                        var blob = new Blob([data], { type: 'application/pdf' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = sanitizedCategoryName + "_questions.pdf"; // Optional, set the download filename
                        link.click();
        
                        // Hide the loader after the file is prepared for download
                        $('.loader-wrapper').hide();
                    },
                    error: function() 
                    {
                        // Hide the loader if there's an error
                        $('.loader-wrapper').hide();
                        alert('Error while downloading the file.');
                    }
                });
            });
        });
        </script>
@endsection