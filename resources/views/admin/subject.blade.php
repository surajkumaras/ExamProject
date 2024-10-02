@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4 header">Subjects</h2>

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModel">
  <i class="fa fa-plus-circle"></i> subject
  </button>
  {{-- Table --}}
  <div class="container">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Subject ID</th>
          <th scope="col">Subject</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @if (count($subjects) > 0)
          @foreach ($subjects as $subject)
            <tr>
              <td>{{ $subject->id}}</td>
              <td>{{ $subject->name}}</td>
              <td>
                <button data-toggle="modal" data-target="#editSubjectModel" class="btn btn-info editButton" data-id="{{ $subject->id}}" data-subject="{{ $subject->name}}"><i class="fa fa-edit"></i></button>
              
                <button class="btn btn-danger deleteButton" data-toggle="modal" data-target="#deleteSubjectModel" data-id="{{ $subject->id}}"><i class="fa fa-trash-o"></i></button>
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="4" class="text-center">No subjects found.</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="addSubjectModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="addSubject" method="POST">
                  @csrf
                  <div class="modal-body">
                      <label for="">Subject</label>
                      <input type="text" name="subject" id="subject" placeholder="Enter subject name">
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                </form>
            </div>
        
    </div>
  </div>

  {{-- Edit model --}}
  <div class="modal fade" id="editSubjectModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="editSubject" method="POST">
                  @csrf
                  <div class="modal-body">
                      <label for="">Subject</label>
                      <input type="text" name="subject" id="edit_subject" placeholder="Enter subject name">
                      <input type="hidden" name="id" id="edit_subject_id">
                  </div>
                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
                  </div>
                </form>
            </div>
        
    </div>
  </div>

  {{-- delete model --}}
  <div class="modal fade" id="deleteSubjectModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="deleteSubject" method="POST">
                  @csrf
                  <div class="modal-body">
                      <p>Are you sure you want to delete this ?</p>
                      <input type="hidden" name="id" id="delete_subject_id">
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
    $(document).ready(function(){
      
      $('#addSubject').submit(function(e){
          e.preventDefault();
          var formData = $(this).serialize();
          $.ajax({
              url: "{{ route('add-subject')}}",
              type: 'POST',
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
                  console.log(err)
              }
          });
      });

      $('.editButton').click(function(){
          var subject_id = $(this).attr('data-id');
          var subject = $(this).attr('data-subject');
          $('#edit_subject_id').val(subject_id);
          $('#edit_subject').val(subject);
      });

      // update subject
      $('#editSubject').submit(function(e){
          e.preventDefault();
          let formData = $(this).serialize();
          console.log(formData);
          $.ajax({
              url: "{{ route('edit-subject')}}",
              type: 'POST',
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
                  console.log(err)
              }
          });
      });

      //delete 
      $('.deleteButton').click(function(){
        var subject_id = $(this).attr('data-id');
        $('#delete_subject_id').val(subject_id);
      });

      $('#deleteSubject').submit(function(e){
          e.preventDefault();
          let formData = $(this).serialize();
          $.ajax({
              url: "{{ route('delete-subject')}}",
              type: 'POST',
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
                  console.log(err)
              }
          });
      });
    });
  </script>
@endsection