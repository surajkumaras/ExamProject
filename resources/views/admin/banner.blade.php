@extends('layout.admin-layout')
@section('space-work')
    <h1 class="mb-4 header">Banner</h1>

    <!-- Success Message -->
    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
    <div class="container">
      <form class="needs-validation" action="{{route('banner.store')}}" method="post" enctype="multipart/form-data" >
        @csrf
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="bannerImage">Banner Image</label>
                <input type="file" class="dropify" name="bannerImage" id="bannerImage" data-default-file="">
            </div>
            <div class="col-md-8 mb-3">
                <label for="title">Banner Title</label>
                <input type="text" class="form-control" id="title" name="title"  value="TEST"  required>

                <label for="desc">Desctiption</label>
                <input type="text" class="form-control" id="desc" name="desc"  required>

                <label for="urllink">URL Link</label>
                <input type="text" class="form-control" id="urllink" name="urllink"  required>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">Save Changes</button>
        <button class="btn btn-danger" type="button">Add New Banner</button>
      </form>

      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">URL</th>
            <th scope="col">Image</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @if(!@empty($banners))
            @foreach ($banners as $banner)
              <tr>
                <th scope="row">1</th>
                <td>{{ $banner->title}}</td>
                <td>{{ $banner->subtitle}}</td>
                <td>{{ $banner->lint}}</td>
                <td>{{ $banner->title}}</td>
                <td>
                  <a href="#"><i class="fa fa-check-circle-o" style="font-size:24px"></i></a>
                  <a href="#"><i class="fa fa-ban" style="font-size:24px"></i></a>
                </td>
                <td>
                  <a href="#"><i class="fa fa-pencil-square-o"></i></a>
                  <a href="#"><i class="fa fa-trash-o"></i></a>
                </td>
              </tr>
              
            @endforeach
          @else
            <tr>
              <td colspan="7" class="text-center">No Banner Found</td>
            </tr>
          @endif
        </tbody>
      </table>
      <br>
    </div>  

    @if (Session::has('success'))
      <script>
        toastr.options = {
          "closeButton": true,
          "progressBar": true,
          };
          toastr.success("{{ Session::get('success')}}");

      </script>
    @endif
      <script>

      $(document).ready(function()
      {
        $('.dropify').dropify();

       

        $("form").submit(function() 
        {
            var full_number = $(this).serialize();
            console.log(full_number);
            
        });

        setTimeout(() => {
          $('.alert-success').hide();
        }, 3000);
      });
      </script>
@endsection