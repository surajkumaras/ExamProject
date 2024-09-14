@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4 header">Exam: {{$exam->exam_name}} | Subject: {{$exam->subject->name}}</h2>
    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Student Name</th>
                    <th>Marks</th>
                    <th>Status</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                @if (count($data)>0)
                    @php $x = 1;  @endphp
                    @foreach ($data as $student )
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$student->user->name}}</td>
                            <th>{{$student->marks}} /</th>
                            <td><a href="{{route('answersheet-review',['eid' => $student->id, 'sid' => $student->user_id,'exid' => $exam->id])}}">Review</a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>No Exam found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
   

<script>
    $(document).ready(function()
    {
        

        
    })
</script>
@endsection