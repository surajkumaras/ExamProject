@extends('layout.student-layout')

@section('space-work')
    <h2>Result</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Exam</th>
                <th>Result</th>
                <th>Marks/Out of</th>
                <th>Passing Marks</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if (count($attempts) > 0)
                @php $x = 1;  @endphp
                @foreach ($attempts as $attempt)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $attempt->exam->exam_name}}</td>
                        <td>
                            @if ($attempt->status == 0)
                                Not Declared
                            @else
                                @if ($attempt->marks >= $attempt->exam->pass_marks)
                                   <span style="color:green">Pass</span>
                                @else
                                    <span style="color:red">Failed</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($attempt->marks > 0)
                                {{ $attempt->marks}}/{{ count($attempt->exam->getQnaExam) * $attempt->exam->marks}}
                            @else
                                -- / --
                            @endif
                            
                        </td>
                        <td>
                            {{ $attempt['exam']->pass_marks}}
                        </td>
                        <td>
                            @if ($attempt->status == 0)
                                <span style="color:red">Pending</span>
                            @else
                                <a href="#" class="reviewExam" data-toggle="modal" data-target="#reviewQnaModal" data-id="{{ $attempt->id}}">Review Q&A</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No exam found</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="reviewQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Review Exam</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body review-qna">
                    Loading ...
                </div>

                <div class="modal-footer">
                <a id="pdfLink" href="#" target="_blank"><button type="button" class="btn btn-secondary"  attempt-id="">Print</button></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
        </div>
        </div>
    </div>

    <!-- Explaination Modal -->
    <div class="modal fade" id="explainationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Explaination</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
                <div class="modal-body">
                    <p id="explaination"></p>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
        </div>
        </div>
    </div>

    <script>
        $(document).ready(function()
        {
            var attempt_id = '';
            $('.reviewExam').click(function()
            {
                var id = $(this).attr('data-id');
                attempt_id = id;
                $('#pdfLink').attr('href', '/pdf/answersheet/' + attempt_id);
                $.ajax({
                    url:"{{ route('resultStudentQna')}}",
                    type:"GET",
                    data:{ attempt_id:id},
                    success:function(data)
                    {
                        console.log(data); 
                        var html = '';
                        if(data.success == true) 
                        {
                            var data = data.data;
                            if(data.length > 0) 
                            {
                                for(var i = 0; i < data.length; i++) 
                                {
                                    var is_correct = `<span style="color:red;" class="fa fa-close"></span>`;
                                    if(data[i]['answers']['is_correct'] == 1) {
                                        is_correct = `<span style="color:green;" class="fa fa-check"></span>`;
                                    }
                                    var answers_html = '';
                                   
                                    for(var j = 0; j < data[i]['question']['answers'].length; j++) 
                                    {
                                        if(data[i]['question']['answers'][j]['is_correct'] == 1)
                                        {
                                             answers_html += `<p style="color:green">` + data[i]['question']['answers'][j]['answer'] + `</p>`;
                                        }
                                        else 
                                        {
                                            answers_html += `<p style="color:red">` + data[i]['question']['answers'][j]['answer'] + `</p>`;
                                        }
                                        
                                    }
                                    html += `<div class="row">
                                                <div class="col-sm-12">
                                                    <h6><b>Q.` + (i+1) + `:` + data[i]['question']['question'] + `</b></h6>
                                                    ` + answers_html + `
                                                    <p><b>Your Ans:&nbsp</b>` + data[i]['answers']['answer'] + `` + is_correct + `</p>`;
                                    if(data[i]['question']['explaination'] != null) {
                                        html += `<p><a href="#" data-explaination="` + data[i]['question']['explaination'] + `" class="explaination" data-toggle="modal" data-target="#explainationModal">Explaination</a></p>`
                                    }
                                    html +=`
                                                </div>
                                            </div>`;
                                }
                            } 
                            else 
                            {
                                html += '<p>You do not attempt any questions.</p>';
                            }
                        }
                        else 
                        {
                            html += '<p>Having some issue on server</p>';
                        }

                        $('.review-qna').html(html);
                    },
                    error:function(err)
                    {
                        alert(err);
                    }
                })
            })

           $(document).on('click','.explaination',function()
           {
                var explaination = $(this).attr('data-explaination');
                $('#explaination').text(explaination);
           })

           $('#print').click(function()
           {
                // window.print();
                let attemptId = attempt_id;
                console.log(attemptId);
                $.ajax({
                    url:"/pdf/answersheet/" + attemptId,
                    method:"GET",
                    success:function(data)
                    {
                        console.log(data);
                    },
                    error:function(err)
                    {
                        alert(err);
                    }
                })
           });
        })
    </script>
@endsection