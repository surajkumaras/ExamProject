<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="{{ asset('css/logs.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <div class="container">
        <h1>Application Logs</h1>
        <form action="{{ route('logs.clear') }}" method="POST" id="clear-logs-form">
            @csrf
            <button type="submit" class="clear-logs-btn">Clear All Logs</button>
        </form>
        <pre>{{ $logs }}</pre>
    </div>

    <script>
        document.getElementById('clear-logs-form').addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to clear all logs?')) 
            {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

pre {
    white-space: pre-wrap; /* Allows for wrapping */
    word-wrap: break-word; /* Break long words */
    background: #f5f2f2;
    color: #141313;
    padding: 15px;
    border-radius: 3px;
    overflow-x: auto; /* Add horizontal scroll if needed */
}
.clear-logs-btn {
    background-color: #e74c3c;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-bottom: 20px;
}

.clear-logs-btn:hover {
    background-color: #c0392b;
}


</style>