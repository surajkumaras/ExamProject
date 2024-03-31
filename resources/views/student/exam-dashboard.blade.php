@extends('layout.layout-common')

@section('space-work')
<style>
    
</style>
    @php
        $time = explode(':',$exam[0]['time']);
    @endphp
    <div class="container">
        <p style="color:black;">Welcome, {{Auth::user()->name }}</p>
        <h1 class="text-center">{{ $exam[0]['exam_name']}}</h1>
        
        @php $qcount = 1; @endphp
        @if ($success == true)
           @if (count($qna) > 0)
           <div class="row justify-content-center mt-3">
                <div class="col-md-12">
                    <h4 class="text-right time newtime" >{{ $exam[0]['time']}}</h4>
           <form action="{{ route('examSubmit')}}" method="post" class="mb-5" id="exam_form">
            @csrf
            <input type="hidden" name="exam_id" value="{{$exam[0]['id']}}">
        
            @foreach ($qna as $data)
            <div class="question-container">
                <h5>Q{{$qcount++}}. {{$data['question'][0]['question']}}</h5>
                <input type="hidden" name="q[]" value="{{$data['question'][0]['id']}}">
                <input type="hidden" name="ans_{{$qcount-1}}" id="ans_{{$qcount-1}}">
                @php $acount = 1; @endphp
                @foreach ($data['question'][0]['answers'] as $answer )
                <label class="answer-label">
                    <span class="answer-number">{{$acount++}}).</span>
                    {{$answer['answer']}}
                    <input type="radio" name="radio_{{$qcount-1}}" data-id="{{$qcount-1}}" class="select_ans" value={{ $answer['id']}}>
                    <span class="checkmark"></span>
                </label>
                @endforeach
            </div>
            @endforeach
            <div class="text-center">
                <input type="submit" class="btn btn-info btn-submit" value="Submit">
            </div>
        </form>
    </div>
</div>
        
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
            if (hours === 0 && minutes === 0 && seconds <= 10) 
            {
                $('.newtime').removeClass('.time');
                $('.newtime').attr('id', 'time');
            }
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
        .container {
    width: 100%;
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
}

        /* Add these styles to your existing CSS file or within a <style> tag in your HTML */

/* Container for each question */
.question-container {
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 0px;
    margin-bottom: 20px;
}

/* Styling for answer options */
.answer-label {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 16px;
    z-index: 999;
}

/* Custom radio button design */
.answer-label input[type="radio"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 50%;
}

.answer-label:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, change the background color */
.answer-label input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Hide the default radio button */
.answer-label input:checked ~ .checkmark:after {
    display: block;
}

/* Show the dot/circle when radio button is checked */
.answer-label .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Position the dot/circle */
.answer-label .checkmark:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
}

/* Style for answer number */
.answer-number {
    font-weight: bold;
    margin-right: 5px;
}

/* Button style */
.btn-submit {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.btn-submit:hover {
    background-color: #45a049;
}

        .time {
            overflow: hidden;
            position: fixed;
            top: 0;
            font-size: 24px;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            animation: pulse 1s infinite alternate;
            z-index: 1000;
        }
        #time {
            overflow: hidden;
            position: fixed;
            top: 0;
            font-size: 24px;
            color: #fff;
            background-color: #ff0000;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            animation: pulse 0.5s infinite alternate;
            z-index: 1000;
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