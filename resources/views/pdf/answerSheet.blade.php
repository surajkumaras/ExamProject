<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Document</title>
</head>
<body>
    <h1>Answer Sheet</h1>
    <table border="1">
        <tr>
            <th>Student name</th>
            <td>{{$student[0]['user']['name']}}</td>
        </tr>
        <tr>
            <th>Exam name</th>
            <td>{{$student[0]['exam']['exam_name']}}</td>
        </tr>
        <tr>
            <th>Marks Obtain</th>
            <td>{{ $student[0]['marks']}}</td>
        </tr>
        <tr>
            <th>Marks per Question</th>
            <td>{{ $student[0]['exam']['marks']}}</td>
        </tr>
        <tr>
            <th>Passing Marks</th>
            <td>{{ $student[0]['exam']['pass_marks']}}</td>
        </tr>
        <tr>
            <th>Exam Date</th>
            <td>{{ $student[0]['exam']['date']}}</td>
        </tr>
        <tr>
            <th>Total Questions</th>
            <td>{{count($examData)}}</td>
        </tr>
    </table>
    <div class="row">
        <div class="col-sm-12">
        @if (count($examData) >0)
            @php
                $i = 1;
            @endphp
            @foreach ($examData as $data)
            <h3><b>Q.{{$i}}: {{$data['question']['question']}}</b></h3>
                @foreach ($data['question']['answers'] as $answeroption)
                    
                        @if ($answeroption['is_correct'] == 1)
                            <p style="color:green">{{$answeroption['answer']}}
                            <span style="color:green">(Correct)</span>
                        @else
                            <p >{{$answeroption['answer']}}
                        @endif
                    </p>
                    
                @endforeach
                <p>Your Ans:{{ $data['answers']['answer']}}
                    @if ($data['answers']['is_correct'] == 1)
                        <span style="color:green" class="fa fa-check"></span>
                    @else
                        <span style="color:red" class="fa fa-close"></span>
                    @endif
                </p>
                @php
                    $i++;
                @endphp
            @endforeach
        @endif
        </div>
    </div>
</body>
</html>