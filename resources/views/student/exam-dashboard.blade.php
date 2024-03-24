@extends('layout.layout-common')

@section('space-work')
    @php
        $time = explode(':',$exam[0]['time']);
    @endphp
    <div class="container">
        <p style="color:black;">Welcome, {{Auth::user()->name }}</p>
        <h1 class="text-center">{{ $exam[0]['exam_name']}}</h1>
        
        @php $qcount = 1; @endphp
        @if ($success == true)
           @if (count($qna) > 0)
           <h4 class="text-right time">{{ $exam[0]['time']}}</h4>
            <form action="{{ route('examSubmit')}}" method="post" class="mb-5" id="exam_form">
                @csrf
                <input type="hidden" name="exam_id" value="{{$exam[0]['id']}}">

                
                @foreach ($qna as $data)
                    <div>
                        <h5>Q{{$qcount++}}. {{$data['question'][0]['question']}}</h5>
                        <input type="hidden" name="q[]" value="{{$data['question'][0]['id']}}">
                        <input type="hidden" name="ans_{{$qcount-1}}" id="ans_{{$qcount-1}}">
                        @php $acount = 1; @endphp
                        @foreach ($data['question'][0]['answers'] as $answer )
                            <p><b>{{$acount++}}).</b>{{$answer['answer']}}
                                <input type="radio" name="radio_{{$qcount-1}}" data-id="{{$qcount-1}}" class="select_ans" value={{ $answer['id']}}>
                            </p>
                        @endforeach
                    </div>
                    <br>
                @endforeach
                <div class="text-center">
                    <input type="submit" class="btn btn-info">
                </div>
            </form>
           @else 
           
           @endif
        @else
            <h1 style="color:red;" class="text-centeer">{{ $msg}}</h1>
        @endif
    </div>

    <script>
        $(document).ready(function()
        {
            $('.select_ans').click(function()
            {
                var no = $(this).attr('data-id');
                $('#ans_'+no).val($(this).val());
            })

            var time = @json($time);
        var hours = parseInt(time[0]);
        var minutes = parseInt(time[1]);
        var seconds = 0;

        // Update the timer display
        function updateTimerDisplay() {
            let tempHours = hours.toString().padStart(2, '0');
            let tempMinutes = minutes.toString().padStart(2, '0');
            let tempSeconds = seconds.toString().padStart(2, '0');
            $('.time').text(tempHours + ':' + tempMinutes + ':' + tempSeconds + ' left time');
        }

        // Update the timer values
        function updateTimer() {
            if (hours === 0 && minutes === 0 && seconds === 0) {
                clearInterval(timer);
                $('#exam_form').submit();
                return;
            }

            if (seconds <= 0) {
                if (minutes > 0) {
                    minutes--;
                    seconds = 59;
                } else if (hours > 0) {
                    hours--;
                    minutes = 59;
                    seconds = 59;
                }
            } else {
                seconds--;
            }

            updateTimerDisplay();
        }

        // Initial timer display
        updateTimerDisplay();

        // Start the timer interval
        var timer = setInterval(updateTimer, 1000);
        })

        function isValid()
        {
            var result = true;
            var qlength = parseInt("{{$qcount}}")-1;
            $('.error_msg').remove();
            for(i=1;i<= qlength;i++)
            {
                if($('#ans_'+i).val() == '')
                {
                    result = false;
                    $('#ans_'+i).parent().append('<span style="color:red;" class="error_msg"> Please select one</span>');
                    
                    setTimeout(() => {
                        $('.error_msg').remove();
                    }, 5000);
                }
            }
            return result;
        }
    </script>
    <style>
        .time {
            font-size: 24px;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            animation: pulse 1s infinite alternate;
        }
    
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
    
            100% {
                transform: scale(1.1);
            }
        }
    </style>
    
@endsection