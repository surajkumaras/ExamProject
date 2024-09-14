@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4 header">Student Exam</h2>
    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Exam</th>
                    <th>Status</th>
                    <th>Review</th>
                </tr>
            </thead>
            <tbody>
                @if (count($attempts)>0)
                    @php $x = 1;  @endphp
                    @foreach ($attempts as $attempt )
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$attempt->user->name}}</td>
                            <td>{{$attempt->exam->exam_name}}</td>
                            <td>
                                @if ($attempt->status == 0)
                                    <span style="color:red;">Pending</span>
                                @else 
                                    <span style="color:green;">Completed</span>
                                @endif
                            </td>
                            <td>
                                @if ($attempt->status == 0)
                                    <a href="#" class="reviewExam" data-id="{{$attempt->id}}" data-toggle="modal" data-target="#reviewExamModal">Review & Approved</span>
                                @else 
                                    Completed
                                @endif
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td>No Exam Attempt found!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- Modal -->
        <div class="modal fade" id="reviewExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Review Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="reviewForm">
                    @csrf
                    <input type="hidden" name="attempt_id" id="attempt_id">
                    <div class="modal-body review-exam">
                        Loading ...
                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary approved-btn">Approved</button>
                    </div>
                </form>
            </div>
            </div>
        </div>

<script>
    $(document).ready(function()
    {
        $('.reviewExam').click(function()
        {
            var id = $(this).attr('data-id');
            $('#attempt_id').val(id);
            $.ajax({
                url:"{{ route('reviewQna')}}",
                type:"GET",
                data:{attempt_id:id},
                success:function(data)
                {
                    console.log(data)
                    var html = '';
                    if(data.success == true)
                    {
                        var data = data.data;
                        if(data.length > 0)
                        {
                            function checkExtension(filename, extensions) 
                            {
                                const ext = filename.split('.').pop().toLowerCase();
                                return extensions.includes(ext);
                            }
                            const allowedExtensions = ["jpg", "jpeg", "png"];
                            

                            for(i = 0;i<data.length;i++)
                            {
                                const filename = data[i]['answers']['answer'];

                                let isCorrect = `<span style="color:red" class="fa fa-close"></span>`;

                                if(data[i]['answers']['is_correct'] == 1)
                                {
                                    isCorrect = `<span style="color:green" class="fa fa-check"></span>`;
                                }

                                let answer = data[i]['answers']['answer'];

                                // html += `<div class="row">
                                //             <div class="col-sm-12">
                                //                 <h6>Q.`+(i+1)+`:`+data[i]['question']['question']+`</h6>
                                //                 <p>Ans.`+answer+`: `+isCorrect+`</p>
                                //             </div>
                                //         </div>`;

                                        if (checkExtension(filename, allowedExtensions)) 
                                        {
                                            let ansimg = `<img src="{{ asset('public/image/ans_images/') }}/` + data[i]['answers']['answer'] + `" width="50px" height="50px" alt="image issue">`;

                                            // html += `<tr>
                                            //     <td>`+(j+1)+`</td>
                                            //         <td>`+ansimg+`</td>
                                            //         <td>`+is_correct+`</td>
                                            //     </tr>`;


                                                html += `<div class="row">
                                                            <div class="col-sm-12">
                                                                <h6>Q.`+(i+1)+`:`+data[i]['question']['question']+`</h6>
                                                                <p>Ans.`+ansimg+`: `+isCorrect+`</p>
                                                            </div>
                                                        </div>`;
                                        } 
                                        else 
                                        {
                                            // html += `<tr>
                                            // <td>`+(j+1)+`</td>
                                            //     <td>`+questions[i]['answers'][j]['answer']+`</td>
                                            //     <td>`+is_correct+`</td>
                                            // </tr>`;

                                            html += `<div class="row">
                                                        <div class="col-sm-12">
                                                            <h6>Q.`+(i+1)+`:`+data[i]['question']['question']+`</h6>
                                                            <p>Ans.`+filename+`: `+isCorrect+`</p>
                                                        </div>
                                                    </div>`;
                                        }


                            }
                        }
                        else 
                        {
                            html += `<h6>Student not attempt any Questions!</h6>
                                    <p>If you approve this exam student will fail</p>`;
                        }
                    }
                    else 
                    {
                        html += `<p>Having some issue</p>`;
                    }

                    $('.review-exam').html(html);
                },
                error:function(err)
                {
                    alert(err)
                }
            })
        });

        //approved attempt code
        $('#reviewForm').submit(function(e)
        {
            e.preventDefault();

            $('.approved-btn').html('Please wait <i class="fa fa-spinner fa-spin"></i>')
            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('approvedQna')}}",
                type:"post",
                data:formData,
                success:function(data)
                {
                    console.log(data)
                    if(data.success == true)
                    {
                        location.reload();
                    }
                },
                error:function(err)
                {
                    console.log(err);
                }
            })
        })
    })
</script>
@endsection