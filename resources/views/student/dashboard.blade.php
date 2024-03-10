@extends('layout.student-layout')

@section('space-work')
    <h1>Exams</h1>

    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Total Attempt</th>
            <th>Available Attempt</th>
            <th>Copy Link</th>
        </thead>
        <tbody>
            @if (count($exams) >0)
                @php $count = 1; @endphp
                @foreach ($exams as $exam )
                    <tr>
                        <td style="display: none;">{{ $exam->id }}</td>
                        <td>{{ $count++ }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects[0]['name']}}</td>
                        <td>{{ $exam->date}}</td>
                        <td>{{ $exam->time}} hrs</td>
                        <td>{{ $exam->attempt}} Time</td>
                        <td>{{ $exam->attempt_counter}} Time</td>
                        <td></td>
                        <td>
                            <a href="#" data_code="{{ $exam->enterance_id}}" class="copy"><i class="fa fa-copy"></i></a>
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="8">No exam available!</td>
                </tr>
            @endif
        </tbody>
    </table>
    <script>
        $(document).ready(function()
        {
            $('.copy').click(function()
            {
                $(this).parent().prepend('<span class="copied_text">Copied</span>');

                var code = $(this).attr('data_code');
                var url = "{{URL::to('/')}}/exam/"+code;
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();

                setTimeout(() => {
                    $('.copied_text').remove();
                }, 1000);
            })
        });
    </script>
@endsection