@extends('layout.admin-layout')

@section('space-work')
    <h6 class="mb-4 header">Student Name: <b>{{$student->name}}</b> | Exam Name: <b>{{$exam->exam_name}}</b> | Subject Name: <b>{{$exam->subject->name}}</b></h6>
    {{-- <h6 class="mb-4 header">Student Name: <b> --}}
    {{-- <h6 class="mb-4 header">Exam Name: {{$exam->exam_name}}</h6>
    <h6 class="mb-4 header">Subject Name: {{$exam->subject->name}}</h6> --}}

<style>
/* body {
font-family: Arial, sans-serif;
margin: 20px;
padding: 20px;
background-color: #F0F0F0;
} */

.header {
background-color: #efdc13;
padding: 20px;
border-radius: 10px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.container {
background-color: #efecec;
padding: 20px;
border-radius: 10px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.question {
margin-bottom: 20px;
}
.options {
display: flex;
flex-wrap: wrap;
gap: 20px;
}
.option {
width: 200px;
text-align: center;
}
.option img {
max-width: 100%;
height: auto;
border-radius: 5px;
}
.option input[type="radio"] {
margin-top: 10px;
}
</style>

<div class="container">
    @php
        $i = 1;
    @endphp
    @foreach ($examData as $data)
        
        <div class="question">
            <h5>{{$i}}>.{{$data->question->question}}</h5>
            @if ($data->question->image != null)
                <img src="{{ asset('public/image/ans_images/' . $data->question->image) }}" width="10%" height="10%" alt="Question Image">
            @endif
        </div>
        <div class="options">
            @foreach ($data->question->answers as $option)
                <div class="option">
                    @if ($option->image != null)
                        <img src="{{ asset('public/image/ans_images/' . $option->image) }}" width="30%" height="30%" alt="Question Image">
                    @endif
                    {{-- <img src="https://i.natgeofe.com/k/6d4021bf-832e-49f6-b898-27b7fcd7cbf7/eiffel-tower-ground-up.jpg?w=374&h=249" width="40%" height="40%" alt="Paris"> --}}
                    <p><input type="radio"   @if ($option->is_correct == 1) checked @else disabled @endif> {{$option->answer}}
                        @if ($option->is_correct == 0)
                            <span style="color:red;" class="fa fa-close"></span>
                        @elseif ($option->is_correct == 1)
                            <span style="color:green;" class="fa fa-check"></span>
                        @endif
                    </p>
                </div>
   
            @endforeach
            <p>Your Ans: {{$data->answers->answer}}
                @if ($data->answers->is_correct == 0)
                    <span style="color:red;" class="fa fa-close"></span>
                @elseif ($data->answers->is_correct == 1)
                    <span style="color:green;" class="fa fa-check"></span>
                @endif
            </p>
            
        </div>
        @php
            $i++;
        @endphp
        <hr>
    @endforeach
</div>


   

<script>
    $(document).ready(function()
    {
        

        
    })
</script>
@endsection