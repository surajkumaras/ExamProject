@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Subjects</h2>

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModel">
    Add subject
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="addSubjectModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addSubject" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Sibject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <label for="">Subject</label>
                    <input type="text" name="subject" id="subject" placeholder="Enter subject name">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
        </form>
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
    });
  </script>
@endsection