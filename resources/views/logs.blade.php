<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="{{ asset('css/logs.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<<<<<<< HEAD
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
=======
>>>>>>> 974a5ad (import and export issue fixed)
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
<<<<<<< HEAD
        <table id="logTable" class="table table-striped table-bordered display" style="width:100%">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($logs as $log) --}}
                <tr>
                    <td>{{ $logs }}</td>
                    <td>{{ Carbon\Carbon::now()->format('Y-m-d H:i:s')}}</td>
                </tr>
                {{-- @endforeach --}}
            </tbody>
        </table>
        {{-- <pre>{{ $logs }}</pre> --}}
=======
        <pre>{{ $logs }}</pre>
>>>>>>> 974a5ad (import and export issue fixed)
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
<<<<<<< HEAD
    background: #f5f2f2;
    color: #141313;
=======
    background: #333;
    color: #f4f4f4;
>>>>>>> 974a5ad (import and export issue fixed)
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


<<<<<<< HEAD
</style>

<script>
    $(document).ready(function()
    {
        $('#logTable').DataTable();
    });
</script>
=======
</style>
>>>>>>> 974a5ad (import and export issue fixed)
