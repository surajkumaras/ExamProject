@extends('layout.admin-layout')

@section('space-work')
    <h1 class="mb-4 header">Configuration</h1>
    

<style>
/* body {
font-family: Arial, sans-serif;
margin: 20px;
padding: 20px;
background-color: #F0F0F0;
} */



</style>
<script src="
https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css
" rel="stylesheet">

<div class="container">
  <form id="mailSetup">
      <fieldset>
          <legend>MAIL SETUP <button type="button" class="btn btn-primary" id="saveMail">Save</button></legend>
          <div class="form-row">
              <div class="form-group col-md-3">
                <label for="inputHost">HOST</label>
                <input type="text" class="form-control" id="inputHost" name="mail_host" value="{{$config->mail_host??''}}">
              </div>
              <div class="form-group col-md-3">
                <label for="inputPort">PORT</label>
                <input type="text" class="form-control" id="inputPort" name="mail_port" value="{{$config->mail_port??''}}">
              </div>
              <div class="form-group col-md-3">
                  <label for="inputEncryption">ENCRYPTION</label>
                  <input type="text" class="form-control" id="inputEncryption" name="mail_encryption" value="{{$config->mail_enctryption??''}}">
              </div>
              <div class="form-group col-md-3">
                  <label for="inputMailer">MAILER</label>
                  <input type="password" class="form-control" id="inputMailer" name="mail_mailer" value="{{$config->mail_mailer??''}}">
              </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputUsername">USERNAME</label>
                <input type="text" class="form-control" id="inputUsername" name="mail_username" value="{{$config->mail_username??''}}">
              </div>
              <div class="form-group col-md-4">
                <label for="inputPassword">PASSWORD</label>
                <input type="text" class="form-control" id="inputPassword" name="mail_password" value="{{$config->mail_password??''}}">
              </div>
              <div class="form-group col-md-4">
                  <label for="inputEmail">EMAIL FROM</label>
                  <input type="email" class="form-control" id="inputEmail" name="mail_mailfrom" value="{{$config->mail_mailfrom??''}}">
              </div>
          </div>
      </fieldset>
  </form>

</div>
<br>
<div class="container">
  <form id="googleLoginSetup">
    <fieldset>
        <legend>GOOGLE SOCIAL LOGIN SETUP <button type="button" class="btn btn-info" id="saveGoogle">Save</button></legend>
        <div class="form-row">
            <div class="form-group col-md-4">
              <label for="googleClientId">GOOGLE CLIENT ID</label>
              <input type="text" class="form-control" id="googleClientId" name="google_client_id" value="{{$config->google_client_id??''}}">
            </div>
            <div class="form-group col-md-4">
              <label for="googleSecretId">GOOGLE SECRET ID</label>
              <input type="text" class="form-control" id="googleSecretId" name="google_client_secret" value="{{$config->google_client_secret??''}}">
            </div>
            <div class="form-group col-md-4">
                <label for="googleRedirectUri">GOOGLE REDIRECT</label>
                <input type="text" class="form-control" id="googleRedirectUri" name="google_redirect_uri" value="{{$config->google_redirect_uri??''}}">
            </div>
        </div>
    </fieldset>
</form>

</div>
<div class="container">
  <form id="facebookLoginSetup">
    <fieldset>
        <legend>FACEBOOK SOCIAL LOGIN SETUP <button type="button" class="btn btn-info" id="saveFacebook">Save</button></legend>
        <div class="form-row">
            <div class="form-group col-md-4">
              <label for="facebookClientId">FACEBOOK CLIENT ID</label>
              <input type="text" class="form-control" id="facebookClientId" name="facebook_client_id" value="{{$config->facebook_client_id??''}}">
            </div>
            <div class="form-group col-md-4">
              <label for="facebookSecretId">FACEBOOK SECRET ID</label>
              <input type="text" class="form-control" id="facebookSecretId" name="facebook_client_secret" value="{{$config->facebook_client_secret??''}}">
            </div>
            <div class="form-group col-md-4">
                <label for="facebookRedirectUri">FACEBOOK REDIRECT</label>
                <input type="text" class="form-control" id="facebookRedirectUri" name="facebook_redirect_uri" value="{{$config->facebook_redirect_uri??''}}">
            </div>
        </div>
    </fieldset>
</form>

</div>
<br>
<div class="container">
    <form>
        <fieldset>
            <legend>PAYPAL PAYMENT <button type="submit" class="btn btn-primary">Save</button></legend>
        {{-- <label for="inputEmail4"></label> --}}
        
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCity">PAYPAL_BUSINSEE_MAIL</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            
              <div class="form-group col-md-2">
                <label for="inputPassword4">PAYPAL_MODE</label>
                <input type="password" class="form-control" id="inputPassword4">
              </div>
              <div class="form-group col-md-4">
                <label for="inputCity">PAYPAL_CLIENT_ID</label>
                <input type="text" class="form-control" id="inputCity">
              </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCity">PAYPAL_CHECKOUT_URL</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            
              <div class="form-group col-md-6">
                  <label for="inputCity">PAYPAL_CLIENT_SECRET</label>
                  <input type="text" class="form-control" id="inputCity">
                </div>
        </div>
    </fieldset>
      </form>
</div>

   

<script>
    $(document).ready(function()
    {
      //==================== Update MAIL setup ====================//
        $('#saveMail').click(function(e) 
        {
          e.preventDefault();

          var formData = {
              mail_host: $('#inputHost').val(),
              mail_port: $('#inputPort').val(),
              mail_encryption: $('#inputEncryption').val(),
              mail_mailer: $('#inputMailer').val(),
              mail_username: $('#inputUsername').val(),
              mail_password: $('#inputPassword').val(),
              mail_mailfrom: $('#inputEmail').val(),
              _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel or similar
          };

          $.ajax({
              url: "{{route('config.mail')}}", 
              type: 'POST',
              data: formData,
              success: function(response) 
              {
                // Set toastr options
                toastr.options = {
                    "debug": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "fadeIn": 300,
                    "fadeOut": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "progressBar" : true
                };
                
                // Show a success toastr notification
                toastr.success(response.msg);
              },
              error: function(xhr, status, error) 
              {
                  console.error(error);
                  alert('Error saving mail settings.');
              }
          });
      });

      //========================= update GOOGLE AUTH ========================//

      $('#saveGoogle').click(function(e) 
      {
        e.preventDefault();

        var googleFormData = {
            google_client_id: $('#googleClientId').val(),
            google_client_secret: $('#googleSecretId').val(),
            google_redirect_uri: $('#googleRedirectUri').val(),
            _token: '{{ csrf_token() }}' 
        };

        // AJAX request
        $.ajax({
            url: "{{route('config.google.setauth')}}", // Replace with your backend URL
            type: 'POST',
            data: googleFormData,
            success: function(response) 
            {
                // Set toastr options
                toastr.options = {
                    "debug": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "fadeIn": 300,
                    "fadeOut": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "progressBar" : true
                };
                
                // Show a success toastr notification
                toastr.success(response.msg);
            },
            error: function(xhr, status, error) 
            {
                console.error(error);
                alert('Error saving Google login settings.');
            }
        });
    });
        
      //========================= UPDATE FACEBOOK DETAILs ================//
      $('#saveFacebook').click(function(e) 
      {
        e.preventDefault();

        var facebookFormData = {
            facebook_client_id: $('#facebookClientId').val(),
            facebook_client_secret: $('#facebookSecretId').val(),
            facebook_redirect_uri: $('#facebookRedirectUri').val(),
            _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel or similar
        };

        $.ajax({
            url: "{{route('config.facebook.setauth')}}", // Replace with your backend URL
            type: 'POST',
            data: facebookFormData,
            success: function(response) 
            {
                // Set toastr options
                toastr.options = {
                    "debug": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "fadeIn": 300,
                    "fadeOut": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "progressBar" : true
                };
                
                // Show a success toastr notification
                toastr.success(response.msg);
            },
            error: function(xhr, status, error) 
            {
                console.error(error);
                alert('Error saving Facebook login settings.');
            }
        });
    });
    })
</script>
@endsection