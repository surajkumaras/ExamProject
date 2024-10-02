@extends('layout.layout-common')

@section('space-work')
<meta name="csrf-token" content="{{ csrf_token() }}">

<h1>Login</h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <button onclick="startFCM()"
                    class="btn btn-danger btn-flat">Allow notification
                </button>
            <div class="card mt-3">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{ route('send.web-notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyCe5XcqQYBogMSq77Vbkke7szT0q4NYacw",
        authDomain: "fir-crud-e30d0.firebaseapp.com",
        databaseURL: "https://fir-crud-e30d0-default-rtdb.firebaseio.com",
        projectId: "fir-crud-e30d0",
        storageBucket: "fir-crud-e30d0.appspot.com",
        messagingSenderId: "1085183356658",
        appId: "1:1085183356658:web:d4ec874b79e1e287216a6b",
        measurementId: "G-ZRVERTCXFK"
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                $.ajaxSetup({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                });
                $.ajax({
                    url: '{{ route("store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token stored.');
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
                alert(error);
            });
    }
    messaging.onMessage(function(payload) {
    console.log('Message received. ', payload);
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    
    if (!("Notification" in window)) 
    {
        alert("This browser does not support system notifications.");
    } 
    else if (Notification.permission === "granted") {
        new Notification(notificationTitle, notificationOptions);
    }
});

</script>
@endsection