@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Student</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModel">
        Add Student
    </button>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @if (!empty($students))
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id}}</td>
                        <td>{{ $student->name}}</td>
                        <td>{{ $student->email}}</td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $student->id}}" data-name="{{ $student->name}}" data-email="{{ $student->email}}" data-toggle="modal" data-target="#editStudentModel">Edit</button>
                        
                            <button class="btn btn-danger deleteButton" data-id="{{ $student->id}}" data-toggle="modal" data-target="#deleteStudentModel">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td colspan="3">Student not fount!</td>
                    </tr>
            @endif
           
        </tbody>
    </table>

    {{--Add modal --}}
  <div class="modal fade" id="addStudentModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Q&A</h5>

                    <button id="addAnswer" class="btn btn-info ml-5">Add Answer</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="addStudent" method="POST">
                    @csrf
                  <div class="modal-body">
                      <div class="row ">
                        <div class="col">
                            <input type="text" class="w-100" name="name"  placeholder="Enter Student Name" required>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col">
                            <input type="text" class="w-100" name="email"  placeholder="Enter Student Email" required>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <span class="error" style="color:red;"></span>
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary">Add Student</button>
                  </div>
                </form>
            </div>
    </div>
  </div>

  {{-- Edit Modal --}}
  <div class="modal fade" id="editStudentModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Student</h5>

                    <button id="addEditAnswer" class="btn btn-info ml-5">Edit Student</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="editStudent" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row ">
                          <div class="col">
                            <input type="hidden" name="id" id="id">
                              <input type="text" class="w-100" name="name" id="name"  placeholder="Enter Student Name" required>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col">
                              <input type="text" class="w-100" name="email" id="email" placeholder="Enter Student Email" required>
                          </div>
                        </div>
                    </div>
                  <div class="modal-footer">
                    <span class="editError" style="color:red;"></span>
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary updateButton">Update Student</button>
                  </div>
                </form>
            </div>
    </div>
  </div>
  {{-- End edit modal --}}

  {{-- Show Answer Modal --}}
  <div class="modal fade" id="showAnsModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Show Answer</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                  <div class="modal-body2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Answer</th>
                                <th>Is_correct</th>
                            </tr>
                        </thead>
                        <tbody class="showAnswers">
                            
                        </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <span class="error" style="color:red;"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
            </div>
    </div>
  </div>
  {{-- End model --}}

  {{-- delete model --}}
<div class="modal fade" id="deleteStudentModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="deleteStudent" method="POST">
                  @csrf
                  <div class="modal-body">
                      <p>Are you sure you want to delete this ?</p>
                      <input type="hidden" name="id" id="student_id">
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
        $('#addStudent').submit(function(e)
        {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('addStudent')}}",
                type:"post",
                data:formData,
                success:function(data)
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

                }
            })
        })

        //edit 

        $('.editButton').click(function()
        {
            $('#id').val($(this).attr('data-id'));
            $('#name').val($(this).attr('data-name'));
            $('#email').val($(this).attr('data-email'));
        })

        //update 
        $('#editStudent').submit(function(e)
        {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log(formData);
            $('.updateButton').prop('disabled',true);

            $.ajax({
                url:"{{ route('editStudent')}}",
                type:"post",
                data:formData,
                success:function(data)
                {console.log(data);
                    if(data.success == true)
                    {
                        $('.updateButton').prop('disabled',false);
                        location.reload();
                    }
                    else
                    {
                        $('.updateButton').prop('disabled',false);
                        alert(data.msg);
                    }
                },
                error:function(err)
                {
                    $('.updateButton').prop('disabled',false);
                    alert(err.msg);
                }
            })
        }) 

        //delete 

        $('.deleteButton').click(function()
        {
            var id = $(this).attr('data-id');

            $('#student_id').val(id);

            
        })

        $('#deleteStudent').submit(function(e)
        {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log(formData);

            $.ajax({
                url:"{{ route('deleteStudent')}}",
                type:"post",
                data:formData,
                success:function(data)
                {console.log(data);
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
                    alert(err.msg);
                }
            })
        })
    })
</script>
  
@endsection