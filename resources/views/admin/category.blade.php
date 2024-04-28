@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Category</h2>

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary categories" data-toggle="modal" data-target="#addSubjectModel">
    Add Category
  </button>
  {{-- Table --}}
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Category</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
      @if (count($categories) > 0)
        @foreach ($categories as $category)
          <tr>
            <td>{{ $category->id}}</td>
            <td>{{ $category->name}}</td>
            <td>
              <button data-toggle="modal" data-target="#editCategoryModel" class="btn btn-info editButton" data-id="{{ $category->id}}" data-subject="{{ $category->name}}">Edit</button>
            </td>
            <td>
              <button class="btn btn-danger deleteButton" data-toggle="modal" data-target="#deleteSubjectModel" data-id="{{ $category->id}}">Delete</button>
            </td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="4" class="text-center">No Category found.</td>
        </tr>
      @endif
    </tbody>
  </table>
  <!-- Modal -->
  <div class="modal fade" id="addSubjectModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="addCategory" method="POST">
                  @csrf
                  <div class="modal-body">
                    <div class="row ">
                        <div class="col">
                            <select class="w-100" name="subject" id="subject_id" required>
                                <option value="">Subject</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col">
                            <input type="text" class="w-100" name="catName" id="catName"  placeholder="Enter Subject Name" required>
                        </div>
                    </div>
                      {{-- <label for="">Subject</label>
                      <input type="text" name="subject" id="subject" placeholder="Enter subject name"> --}}
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
  <div class="modal fade" id="editCategoryModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="editCategory" method="POST">
                  @csrf
                  <div class="modal-body">
                    <div class="row ">
                        <div class="col">
                            <select class="w-100" name="subject" id="subj_id" required>
                                <option value="">Subject</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col">
                            <input type="text" class="w-100" name="category" id="edit_category"  placeholder="Enter Category name" required>
                        </div>
                    </div>
                      {{-- <input type="text" name="category" id="edit_category" placeholder="Enter Category name"> --}}
                      <input type="hidden" name="id" id="edit_category_id">
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
                <h5 class="modal-title" id="staticBackdropLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="deleteCategory" method="POST">
                  @csrf
                  <div class="modal-body">
                      <p>Are you sure you want to delete this ?</p>
                      <input type="hidden" name="id" id="delete_category_id">
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
      //=================== Add Category ================//

      $('#addCategory').submit(function(e){
          e.preventDefault();
          var formData = $(this).serialize();
          
          $.ajax({
              url: "{{ route('add-category')}}",
              type: 'POST',
              data: formData,
              success: function(data)
              {
                  if(data.status == true)
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

      //============ Edit Category ====================//

      $('.editButton').click(function(){
          var cat_id = $(this).attr('data-id');
          var category = $(this).attr('data-subject');
          $('#edit_category_id').val(cat_id);
          $('#edit_category').val(category);

          $.ajax({
            url:"/category/subject/"+cat_id,
            type:"GET",
            success:function(data)
            {
                var html = '<option value="">Subject</option>';
                        for(var i = 0;i<data.subjs.length;i++)
                        {
                          if(data.cats[0]['subject']['id'] == data.subjs[i]['id'])
                            html += `<option value="`+data.subjs[i]['id']+`" selected>`+data.subjs[i]['name']+`</option>`;
                          else
                            html += `<option value="`+data.subjs[i]['id']+`">`+data.subjs[i]['name']+`</option>`;
                            //html += `<option value="`+data.subjs[i]['id']+`">`+data.subjs[i]['name']+`</option>`;
                        }
                        $('#subj_id').html(html);
            },
            error:function(err)
            {
              console.log(err);
            }
          })
      });

      // =================== Update subject =================//

      $('#editCategory').submit(function(e){
          e.preventDefault();
          let formData = $(this).serialize();
          // console.log(formData);
          // return false;
          $.ajax({
              url: "{{ route('update-category')}}",
              type: 'POST',
              data: formData,
              success: function(data)
              { console.log(data);
                  if(data.status == true)
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

      //================= Delete Category ================//

      $('.deleteButton').click(function(){
        var category_id = $(this).attr('data-id');
      
        $('#delete_category_id').val(category_id);
      });

      $('#deleteCategory').submit(function(e){
          e.preventDefault();
          let formData = $(this).serialize();
      
          $.ajax({
              url: "{{ route('delete-category')}}",
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

      //===================== show subject list ==================//

      $('.categories').click(function()
        {
            $.ajax({
                url:"{{ route('getSubject')}}",
                type:"GET",
                success:function(data)
                {
                    if(data.success == true)
                    {
                        var html = '<option value="">Subject</option>';
                        for(var i = 0;i<data.data.length;i++)
                        {
                            html += `<option value="`+data.data[i]['id']+`">`+data.data[i]['name']+`</option>`;
                        }
                        $('#subject_id').html(html);
                    }
                },
                error:function(err)
                {
                    console.log(err);
                }
            })
        })
        
    });
  </script>
@endsection