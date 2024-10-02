@extends('layout.student-layout')
@section('space-work')
    <h1>Profile</h1>

    <!-- Success Message -->
    @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
    <!-- Error Message -->
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <form class="needs-validation" action="{{route('profileUpdate')}}" method="post" enctype="multipart/form-data" >
        @csrf
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">Profile Image</label>
                <input type="file" class="dropify" style="font-size: 18px !important;" name="profileImg" id="file" 
                  @if ($data && $data->image)
                      data-default-file="{{ asset('public/profile/' . $data->image) }}"
                  @endif>
                <div class="valid-feedback">
                  Looks good!
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Username</label>
                        <input type="text" class="form-control" id="name" name="name" @if ($data) value="{{$data->name}}" @endif required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="email">Email</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                          </div>
                          <input type="text" class="form-control" id="email" name="email" @if ($data) value="{{$data->email}}" @endif aria-describedby="inputGroupPrepend" required>
                          <div class="invalid-feedback">
                            Please choose a username.
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="cname">Gender</label>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="gender1" @if ($data && $data->gender == 'Male') checked @endif value="Male">
                          <label class="form-check-label" for="gender1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="gender2" @if ($data && $data->gender == 'Female') checked @endif value="Female">
                          <label class="form-check-label" for="gender2">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="gender3" @if ($data && $data->gender == 'Others') checked @endif value="Others">
                          <label class="form-check-label" for="gender3">Others</label>
                        </div>
                     </div>

                      <div class="col-md-6 mb-3">
                        <label for="phone">Phone</label>
                        <div class="input-group">
                          <input type="tel" class="form-control" name="phone_number[main]" id="phone_number" @if ($data) value="{{$data->phone}}" @endif aria-describedby="inputGroupPrepend" required/>
                          {{-- <input type="text" class="form-control" id="phone" name="phone" aria-describedby="inputGroupPrepend" required> --}}
                        </div>
                      </div>
                      <div class="col-md-12 mb-2">
                          <label for="caddress">Address</label>
                          <input type="text" class="form-control" id="address" name="address" @if ($data) value="{{$data->address}}" @endif required>
                          <div class="valid-feedback">
                            Looks good!
                          </div>
                      </div>
                  </div>
            </div>
            
          
        </div>
        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" @if ($data) value="{{$data->city}}" @endif required>
            {{-- <div class="invalid-feedback">
              Please provide a valid city.
            </div> --}}
          </div>
          <div class="col-md-4 mb-3">
            <label for="state">State</label>
            <input type="text" class="form-control" id="state" name="state" @if ($data) value="{{$data->state}}" @endif required>
            {{-- <select class="custom-select" id="state" name="state" required>
              <option selected disabled value="">Choose...</option>
              <option>...</option>
            </select> --}}
            {{-- <div class="invalid-feedback">
              Please select a valid state.
            </div> --}}
          </div>
          <div class="col-md-2 mb-3">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country" @if ($data) value="{{$data->country}}" @endif required>
            {{-- <div class="invalid-feedback">
              Please provide a valid city.
            </div> --}}
          </div>
          
          <div class="col-md-2 mb-3">
            <label for="pin">Zip/Pin</label>
            <input type="text" class="form-control" id="pin" name="pin" @if ($data) value="{{$data->zip_code}}" @endif required>
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

        var phone_number = window.intlTelInput(document.querySelector("#phone_number"), 
        {
          separateDialCode: true,
          preferredCountries:["in"],
          hiddenInput: "full",
          utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
        });

        $("form").submit(function() 
        {
          var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
          $("input[name='phone_number[full]'").val(full_number);
            // alert(full_number)
            
        });

        setTimeout(() => {
          $('.alert-success').hide();
        }, 3000);
      });
      </script>
@endsection