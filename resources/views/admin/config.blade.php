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

<div class="container">
    <form>
        <fieldset>
            <legend>MAIL SETUP <button type="submit" class="btn btn-primary">Save</button></legend>
        {{-- <label for="inputEmail4"></label> --}}
        
        <div class="form-row">
            <div class="form-group col-md-3">
              <label for="inputCity">HOST</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-3">
              <label for="inputCity">PORT</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-3">
                <label for="inputCity">ENCRYPTION</label>
                <input type="text" class="form-control" id="inputCity">
              </div>
              <div class="form-group col-md-3">
                <label for="inputPassword4">MAILER</label>
                <input type="password" class="form-control" id="inputPassword4">
              </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputCity">USERNAME</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
              <label for="inputCity">PASSWORD</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
                <label for="inputEmail4">EMAIL FROM</label>
                <input type="email" class="form-control" id="inputEmail4">
              </div>
        </div>
    </fieldset>
      </form>
</div>
<br>
<div class="container">
    <form>
        <fieldset>
            <label>GOGGLE SOCIAL LOGIN SETUP <button type="submit" class="btn btn-info">Save</button></label>
        
        <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputCity">GOOGLE_CLIENT_ID</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
              <label for="inputCity">GOOGLE_SECRET_ID</label>
              <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
                <label for="inputCity">GOOGLE_REDIRECT</label>
                <input type="text" class="form-control" id="inputCity">
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
        

        
    })
</script>
@endsection