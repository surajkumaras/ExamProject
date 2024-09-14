@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4 header">Exam Review</h2>
    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Exam Name</th>
                    <th>Total Attempting</th>
                    <th>Topper</th>
                </tr>
            </thead>
            <tbody>
                @if (count($exams)>0)
                    @php $x = 1;  @endphp
                    @foreach ($exams as $exam )
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$exam->exam_name}}</td>
                            <td><a href="{{route('exam-review',$exam->id)}}">Review</a></td>
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