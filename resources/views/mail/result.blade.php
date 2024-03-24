<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title']}}</title>
</head>
<body>
    <div class="container">
        
        <center><h3><b>PROVISIONAL-RESULT-CUM-DETAILED MARKSSHEET</b></h3></center>
        <center><h4><i><b><u>{{$data['exam_name']}}</u></b></i></h4></center>
        
            <table border=2>
            <tr>
                <td colspan="4">Student ID No :<b>{{ $data['user_id']}}</b><br>Name:<b>{{$data['name']}}</b><br>Class:<b>----</b></td>
            </tr>
            
            <tr> 
                <td><b>Exam ID:</b></td>
                <td><b>Exam Name</b></td>
                <td><b>Max. Marks</b></td>
                <td><b>Obtain Marks</b></td>
                <td><b>Passing Marks</b></td>
                <td><b>Marks per Question</b></td>
            </tr>
            
            <tr>
                <td>{{ $data['exam_id']}}</td>
                <td>{{ $data['exam_name']}}</td>
                <td>{{$data['max_marks']}}</td>
                <td>{{$data['obt_marks']}}</td>
                <td>{{$data['pass_marks']}}</td>
                <td>{{$data['per_qna_marks']}}</td>
            </tr>
            
            <tr><td colspan=4>Result Status:
                @if ($data['obt_marks'] >= $data['pass_marks'])
                    <b><span style="color:green">Pass</span> </b>
                @else
                    <b><span style="corgb(247, 74, 6)reen">Failed</span> </b>
                @endif </td>
            </tr>
            <tr><td colspan=4>Result Date:{{ $data['date']}}</td>
          <table>
    </div>
</body>
</html>
<style>
    table 
    {
        margin-left: auto;
        margin-right: auto;
        background-color: white;
        border-collapse: collapse;
    }
    body 
    {
        background-color: #ccffff;
    }
    img 
    {
        
        width: 140;
        height: 100;
        border-radius: 25%;
    }
    H1 
    {
        background-color: black;
        color: white;
    }
    .sidebar 
    {
        background-color: yellow;
        height: 300px;
        width: 200px;
        
        margin-top: 20px;
    }
    button 
    {
        margin-top: 50px;
        
        margin-left: 50px;
        margin-right: 50px;
    }
</style>