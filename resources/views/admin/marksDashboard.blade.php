@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4 header">Marks</h2>

    <div class="container">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Exam Name</th>
                    <th>Marks/Q</th>
                    <th>Total marks</th>
                    <th>Passing marks</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($exams))
                @php $i= 1; @endphp
                    @foreach ($exams as $exam)
                        <tr>
                            <td>{{ $i++}}</td>
                            <td>{{ $exam->exam_name}}</td>
                            <td>{{ $exam->marks}}</td>
                            <td>{{ count($exam->getQnaExam) * $exam->marks }}</td>
                            <td>{{ $exam->pass_marks}}</td>
                            <td>
                                <button class="btn btn-info editMarks" data-id="{{$exam->id}}" data-pass-marks="{{ $exam->pass_marks}}" data-name="" data-marks="{{$exam->marks}}" data-totalq="{{ count($exam->getQnaExam)}}" data-toggle="modal" data-target="#editMarksModal">Edit</button>
                            
                                <button class="btn btn-danger deleteButton" data-id="" data-toggle="modal" data-target="#deleteStudentModel">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                        <tr>
                            <td colspan="5">Exam not fount!</td>
                        </tr>
                @endif
            
            </tbody>
        </table>
    </div>
    {{-- Edit modal --}}
    <div class="modal fade" id="editMarksModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Marks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form id="editMarks" method="POST">
                      @csrf
                      <div class="modal-body">
                          <div class="row">
                            <div class="col-sm-3">
                                <label for="marks">Marks/Q</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="hidden" name="exam_id" id="exam_id">
                                <input type="text" id="marks" onkeypress="return event.charCode >= 48 && event.charCode <=57 || event.charCode == 46" name="marks" placeholder="Enter marks" required>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-sm-3">
                                <label for="marks">Total Marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="marks" placeholder="Total marks" id="tmarks" disabled>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-sm-3">
                                <label for="pass_marks">Passing Marks</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="pass_marks" placeholder="Passing marks" id="pass_marks" onkeypress="return event.charCode >= 48 && event.charCode <=57 || event.charCode == 46" required>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update Marks</button>
                      </div>
                    </form>
                </div>
            {{-- TEst --}}
        </div>
      </div>
    <script>
        $(document).ready(function()
        {
            var totalQna = 0;
            $('.editMarks').click(function()
            {
                var exam_id = $(this).attr('data-id');
                var marks = $(this).attr('data-marks');
                var totalq = $(this).attr('data-totalq');

                $('#marks').val(marks);
                $('#exam_id').val(exam_id);
                $('#tmarks').val((marks * totalq).toFixed(1));
                totalQna = totalq;

                $('#pass_marks').val($(this).attr('data-pass-marks'));
            })

            $('#marks').keyup(function()
            {
                $('#tmarks').val(($(this).val()*totalQna).toFixed(1));
            })

            $('#pass_marks').keyup(function()
            {
                $('.pass-error').remove();
                var tmarks = $('#tmarks').val();
                var pmarks = $(this).val();

                if(parseFloat(pmarks) >= parseFloat(tmarks))
                {
                    $(this).parent().append('<p style="color:red" class="pass-error">Passing marks will be less than total marks. </p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);
                }
            })

            $('#editMarks').submit(function(e)
            {
                e.preventDefault();

                $('.pass-error').remove();
                var tmarks = $('#tmarks').val();
                var pmarks = $('#pass_marks').val();

                if(parseFloat(pmarks) >= parseFloat(tmarks))
                {
                    $('#pass_marks').parent().append('<p style="color:red" class="pass-error">Passing marks will be less than total marks. </p>');
                    setTimeout(() => {
                        $('.pass-error').remove();
                    }, 2000);

                    return false;
                }

                var formData = $(this).serialize();
                console.log(formData);
                $.ajax({
                    url:"{{ route('updateMarks')}}",
                    type:"POST",
                    data:formData,
                    success:function(data)
                    {
                        if(data.success == true)
                        {
                            location.reload();
                        }

                        if(data.success == false)
                        {
                            alert(data.msg);
                        }
                    },
                    error:function(err)
                    {

                    }
                })
            })
        })
    </script>
@endsection