@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Exams</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModel">
        Add exam
    </button>

    {{-- Table --}}
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Exam Name</th>
                <th>Subject</th>
                <th>Data</th>
                <th>Time</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if (count($exams) > 0)
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $exam->id}}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects[0]['name'] }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }} Hrs</td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $exam->id}}" data-toggle="modal" data-target="#editExamModel">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $exam->id}}" data-toggle="modal" data-target="#deleteExamModel">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <!-- Modal -->
  <div class="modal fade" id="addExamModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="addExam" method="POST">
                  @csrf
                  <div class="modal-body">
                      <label for="">Exam</label>
                      <input type="text" name="exam_name" id="exam" placeholder="Enter exam name" class="w-100" required>
                      <br><br>
                      <select name="subject_id" required id="" class="w-100">
                        <option value="">Select Subject</option>
                        @if (count($subjects)> 0)
                            @foreach ($subjects as $subject )
                                <option value="{{ $subject->id}}">{{ $subject->name}}</option>
                            @endforeach
                        @endif
                      </select>
                      <br><br>
                      <input type="date" name="date" class="w-100" required min="@php echo date('Y-m-d');  @endphp">
                      <br><br>
                      <input type="time" name="time" class="w-100" required>
                      <br><br>
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add Exam</button>
                  </div>
                </form>
            </div>
        
    </div>
  </div>

  {{-- Edit --}}

  <div class="modal fade" id="editExamModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="editExam" method="POST">
                  @csrf
                  <div class="modal-body">
                      <label for="">Exam</label>
                      <input type="hidden" name="exam_id" id="exam_id">
                      <input type="text" name="exam_name" id="exam_name" placeholder="Enter exam name" class="w-100" required>
                      <br><br>
                      <select name="subject_id" required id="subject_id" class="w-100">
                        <option value="">Select Subject</option>
                        @if (count($subjects)> 0)
                            @foreach ($subjects as $subject )
                                <option value="{{ $subject->id}}">{{ $subject->name}}</option>
                            @endforeach
                        @endif
                      </select>
                      <br><br>
                      <input type="date" name="date" id="date" class="w-100" required min="@php echo date('Y-m-d');  @endphp">
                      <br><br>
                      <input type="time" name="time" id="time" class="w-100" required>
                      <br><br>
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update Exam</button>
                  </div>
                </form>
            </div>
        
    </div>
  </div>
{{-- delete model --}}
<div class="modal fade" id="deleteExamModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="deleteExam" method="POST">
                  @csrf
                  <div class="modal-body">
                      <p>Are you sure you want to delete this ?</p>
                      <input type="hidden" name="exam_id" id="deleteExamId">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </div>
                </form>
            </div>
        
    </div>
  </div>
  <script>
    $(document).ready(function()
    {
      $('#addExam').submit(function(e)
      {
        e.preventDefault();
        var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('addExam') }}",
                data: formData,
                success: function(data)
                {
                    if(data.success == true)
                    {
                        location.reload();
                    }
                    else 
                    {
                        alert(data.msg);
                    }
                },
                error:function()
                {
                    
                }
            
            });
        });

        // edit exam
        $('.editButton').click(function()
        {
            let id = $(this).attr('data-id');
            $('#exam_id').val(id);
            var url = "{{ route('getExamDetail', 'id') }}";
            url = url.replace('id', id);
            console.log(url);
            $.ajax({
                url:url,
                type:"GET",
                success:function(data)
                {
                    if(data.success == true)
                    {
                        $('#exam_id').val(data.data[0].id);
                        $('#exam_name').val(data.data[0].exam_name);
                        $('#subject_id').val(data.data[0].subject_id);
                        
                        $('#date').val(data.data[0].date);
                        $('#time').val(data.data[0].time);
                    }
                    else
                    {
                        alert(data.msg);
                    }
                    
                    
                }
            });
        });

        //update

        $('#editExam').submit(function(e)
      {
        e.preventDefault();
        var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('updateExam') }}",
                data: formData,
                success: function(data)
                {
                    if(data.success == true)
                    {
                        location.reload();
                    }
                    else 
                    {
                        alert(data.msg);
                    }
                },
                error:function(err)
                {
                    alert(err)
                }
            
            });
        });

        //delete 

        $('.deleteButton').click(function()
        {
            var id = $(this).attr('data-id');
            alert(id);
            $('#deleteExamId').val(id);
        })

        $('#deleteExam').submit(function(e)
      {
        e.preventDefault();
        var formData = $(this).serialize();
            $.ajax({
                type: 'POST',
                url: "{{ route('deleteExam') }}",
                data: formData,
                success: function(data)
                {
                    if(data.success == true)
                    {
                        location.reload();
                    }
                    else 
                    {
                        alert(data.msg);
                    }
                },
                error:function(err)
                {
                    alert(err)
                }
            
            });
        });
    });
  </script>
@endsection