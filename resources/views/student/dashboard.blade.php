@extends('layout.student-layout')

@section('space-work')
    <h1 class="text-center">Exams</h1>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Exam Name</th>
                    <th>Subject Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Passing Marks</th>
                    <th>Total Attempt</th>
                    <th>Available Attempt</th>
                    <th>Copy Link</th>
                </tr>
            </thead>
            <tbody>
                @if (count($exams) > 0)
                    @php $count = 1; @endphp
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $count++ }}</td>
                            <td>{{ $exam->exam_name }}</td>
                            <td>{{ $exam->subjects[0]['name']}}</td>
                            <td>{{ $exam->date }}</td>
                            <td>{{ $exam->time }} hrs</td>
                            <td>{{ $exam->pass_marks }}</td>
                            <td>{{ $exam->attempt }} Time</td>
                            <td>{{ $exam->attempt_counter }} Time</td>
                            <td>
                                {{-- <a href="#" data-code="{{ $exam->enterance_id }}" class="copy"><i class="fa fa-copy"></i></a> --}}
                                <a href="{{ url('/exam/' . $exam->enterance_id) }}"><i class="fa fa-copy"></i>Click me</a>

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
    </div>

    <script>
        $(document).ready(function () {
            $('.copy').click(function () {
                $(this).parent().prepend('<span class="copied_text">Copied</span>');

                var code = $(this).attr('data-code');
                var url = "{{ URL::to('/') }}/exam/" + code;
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();

                setTimeout(() => {
                    $('.copied_text').remove();
                }, 1000);
            });
        });
    </script>
@endsection
