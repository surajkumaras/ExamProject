@extends('layout.admin-layout')
@section('space-work')
    <h1>Setting</h1>

    <form class="needs-validation" action="{{route('updateSetting')}}" method="post" enctype="multipart/form-data" >
        @csrf
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">Logo</label>
                <input type="file" class="dropify" name="logo" id="file" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
          <div class="col-md-4 mb-3">
            <label for="cname">Orgination name</label>
            <input type="text" class="form-control" id="cname" name="cname" required>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          
          <div class="col-md-4 mb-3">
            <label for="email">Email</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
              </div>
              <input type="text" class="form-control" id="email" name="email" aria-describedby="inputGroupPrepend" required>
              <div class="invalid-feedback">
                Please choose a username.
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="phone">Phone</label>
            <div class="input-group">
              <input type="text" class="form-control" id="phone" name="phone" aria-describedby="inputGroupPrepend" required>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="caddress">Company address</label>
            <input type="text" class="form-control" id="caddress" name="caddress"  required>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
        <div class="form-row">
          <div class="col-md-2 mb-3">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
            {{-- <div class="invalid-feedback">
              Please provide a valid city.
            </div> --}}
          </div>
          <div class="col-md-3 mb-3">
            <label for="state">State</label>
            <select class="custom-select" id="state" name="state" required>
              <option selected disabled value="">Choose...</option>
              <option>...</option>
            </select>
            {{-- <div class="invalid-feedback">
              Please select a valid state.
            </div> --}}
          </div>
          <div class="col-md-3 mb-3">
            <label for="pin">Zip/Pin</label>
            <input type="text" class="form-control" id="pin" name="pin" required>
            {{-- <div class="invalid-feedback">
              Please provide a valid zip.
            </div> --}}
          </div>
        </div>
       
        <button class="btn btn-primary" type="submit">Save Changes</button>
      </form>
      
      <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
    //   (function() 
    //   {
    //     'use strict';
    //     window.addEventListener('load', function() 
    //     {
    //       // Fetch all the forms we want to apply custom Bootstrap validation styles to
    //       var forms = document.getElementsByClassName('needs-validation');
    //       // Loop over them and prevent submission
    //       var validation = Array.prototype.filter.call(forms, function(form) {
    //         form.addEventListener('submit', function(event) {
    //           if (form.checkValidity() === false) {
    //             event.preventDefault();
    //             event.stopPropagation();
    //           }
    //           form.classList.add('was-validated');
    //         }, false);
    //       });
    //     }, false);
    //   })();

      $(document).ready(function()
      {
        $('.dropify').dropify();
      });
      </script>
@endsection