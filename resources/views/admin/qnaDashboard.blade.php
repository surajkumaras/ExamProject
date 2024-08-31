@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Q & A</h2>

    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" id="addQnaButton" data-toggle="modal" data-target="#addExamModel">
        Add Q&A
    </button> --}}
    <a href="{{ route('question')}}">
        <button type="button" class="btn btn-primary">
            <i class="fa fa-plus-circle" style="font-size:24px"></i> Q&A
        </button>
    </a>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importExamModel">
        <i class="fa fa-upload" style="font-size:24px"></i> Import Q&A
    </button>
    <button type="button"  id="exportQna" class="btn btn-info">
        <i class="fa fa-file-excel-o" style="font-size:24px"></i> Export Q&A
    </button>
    <table class="table" id="myTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Questione</th>
                <th>Answer</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @if (count($questions) > 0)
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->id}}</td>
                        <td>{{ $question->question }}</td>
                        {{-- <td>{{ $question->subjects[0]['name'] }}</td> --}}
                        
                        <td>
                            <a href="#" class="showAnsButton" data-id="{{ $question->id}}" data-toggle="modal" data-target="#showAnsModel">See answer</a>
                        </td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $question->id}}" data-toggle="modal" data-target="#editAnsModel"><i class="fa fa-edit"></i></button>
                        
                            <button class="btn btn-danger deleteButton" data-id="{{ $question->id}}" data-toggle="modal" data-target="#deleteExamModel"><i class="fa fa-trash-o"></i></button>
                        </td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td colspan="3">Data not found</td>
                    </tr>
            @endif
        </tbody>
    </table>

    {{--Add modal --}}
    <div class="modal fade" id="addExamModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Q&A</h5>
    
                    <button id="addAnswer" class="btn btn-info ml-5">Add Answer</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form id="addQna" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="modal-body modal1">
                        <div class="row ">
                            <div class="col">
                                <select class="w-100" name="subject" id="subject_id">
                                    <option value="">Subject</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row " style="display: none" id="category_row">
                            <div class="col">
                                <select class="w-100" name="category" id="category_id">
                                    <option value="">Categories</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row " >
                            <div class="col">
                                <input type="file" placeholder="Please select file" name="que_file" id="que_file" class="w-100">
                            </div>
                        </div>
                          <div class="row ">
                            <div class="col">
                                <input type="text" class="w-100" name="question"  placeholder="Enter Question" required>
                            </div>
                          </div>
                          <div class="row  mt-2">
                            <div class="col">
                                <textarea name="explaination" class="w-100" placeholder="Enter your explaination(optional)"></textarea>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <span class="error" style="color:red;"></span>
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                       <button type="submit" class="btn btn-primary">Add Q&A</button>
                      </div>
                    </form>
                </div>
        </div>
      </div>

  {{-- Edit Modal --}}
  <div class="modal fade" id="editAnsModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Q&A</h5>

                    <button id="addEditAnswer" class="btn btn-info ml-5">Edit Answer</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="editQna" method="POST">
                    @csrf
                  <div class="modal-body editModalAnswers">
                        <div class="row editSubjectRow" style="display: none">
                            <div class="col">
                                <select class="w-100" name="editSubject" id="editSubject_id">
                                    <option value="">Subject</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row editCategory_row" style="display: none">
                            <div class="col">
                                <select class="w-100" name="category" id="editCategory_id">
                                    <option value="">Categories</option>
                                    
                                </select>
                            </div>
                        </div>
                      <div class="row ">
                        <div class="col">
                            <input type="hidden" id="question_id" name="question_id">
                            <input type="text" class="w-100" name="question" id="question" placeholder="Enter Question" required>
                        </div>
                      </div>
                      <div class="row  mt-2">
                        <div class="col">
                            <textarea name="explaination" id="explaination" class="w-100" placeholder="Enter your explaination(optional)"></textarea>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <span class="editError" style="color:red;"></span>
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary">Update Q&A</button>
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
                  <div class="modal-body">
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
<div class="modal fade" id="deleteExamModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="deleteQna" method="POST">
                  @csrf
                  <div class="modal-body">
                      <p>Are you sure you want to delete this ?</p>
                      <input type="hidden" name="id" id="delete_qna_id">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </div>
                </form>
            </div>
        
    </div>
  </div>

  {{-- Import question --}}
  <div class="modal fade" id="importExamModel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Import Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form name="importQna" id="importQna" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="file" id="fileupload"  required accept=".xlsx, .xls, .csv">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Upload</button>
                    </div>
                </form>
        </div>
    </div>
  </div>
<script>
  $(document).ready(function()
  {
     $('#addQna').submit(function(e){
        e.preventDefault(); 
        console.log("Add Qna:"+ $('.answers').length)
        if( $('.answers').length < 2)
        {
            $('.error').text('Please add minimum two answers.');

            setTimeout(() => {
                $('.error').text('');
            }, 2000);
        }
        else 
        {
            var checkIsCorrect = false;

            for(var i = 0;i< $('.is_correct').length;i++)
            {
                if($(".is_correct:eq("+i+")").prop('checked') == true)
                {
                    checkIsCorrect = true;
                    // $(".is_correct:eq("+i+")").val( $(".is_correct:eq("+i+")").next().find('input').val());
                    $(".is_correct:eq("+i+")").val( $(".is_correct:eq("+i+")").closest('.answers').find('.option-field input').val());
                }
            }

            if(checkIsCorrect)
            {
                var formData = new FormData($(this)[0]);

                $.ajax({
                   url:"{{ route('addQna')}}",
                   type:"POST",
                   data:formData,
                   contentType: false,
                    processData: false,
                   success:function(data)
                   {
                    console.log(data);
                        if(data.success == true)
                        {
                             location.reload();
                        }
                        else 
                        {
                             alert(data.msg);
                        }
                   } 
                });
            }
            else 
            {
                $(".error").text("Please select anyone correct answer");
                setTimeout(() => {
                    $('.error').text(' ');
                },2000);
            }
        }
     });

     //add answers

    //------------- New Code ---------------//
    $('#addAnswer').click(function() 
    {
        if ($('.answers').length >= 6) 
        {
            $('.error').text('You can add maximum six answers.');
            setTimeout(() => {
                $('.error').text('');
            }, 2000);
        } 
        else 
        {
            var html = `
                <div class="row mt-2 answers">
                    <input type="radio" name="is_correct" class="is_correct">
                    <div class="col">
                        <select class="option-type">
                            <option value="">Select Answer Type</option>
                            <option value="text">Text</option>
                            <option value="file">File</option>
                        </select>
                    </div>
                    <div class="col option-field">
                        <!-- Dynamic option field will be added here -->
                    </div>
                    <button class="btn btn-danger removeButton">Remove</button>
                </div>`;
            $('.modal1').append(html);
        }
        console.log("Add Ans:" + $('.answers').length);
    });

    // Event listener for the change in option type
    $(document).on('change', '.option-type', function() 
    {
        var selectedOption = $(this).val();
        var optionField = $(this).closest('.answers').find('.option-field');
        var radio = $(this).closest('.answers').find('.is_correct');

        if (selectedOption === 'text') 
        {
            optionField.html('<input type="text" class="w-100" name="answers[]" placeholder="Enter Answer" required>');
            radio.val('text');
        } 
        else if (selectedOption === 'file') 
        {
            optionField.html('<input type="file" class="upload-image" name="ans_images[]" accept="image/*">');
            radio.val('file');
        }
    });
    console.log("Add Ans:"+$('.answers').length);


     $(document).on('click','.removeButton',function()
     {
        $(this).parent().remove();
     })

     //Show answers code 
     $('.showAnsButton').click(function()
     {
        var questions = @json($questions);
        var qid = $(this).attr('data-id');
        var html = '';
        for(var i = 0;i < questions.length;i++)
        {   console.log(questions[i]['id']);
            if(questions[i]['id'] == qid)
            {
                var answerLength = questions[i]['answers'].length;
                console.log(answerLength)
                for(j= 0;j<answerLength;j++)
                {
                    var is_correct = 'No';
                    if(questions[i]['answers'][j]['is_correct'] == 1)
                    {
                        is_correct = 'Yes';
                    }

                    console.log(questions[i]['answers'][j]['answer'])

                    function checkExtension(filename, extensions) 
                    {
                        const ext = filename.split('.').pop().toLowerCase();
                        return extensions.includes(ext);
                    }

                    const filename = questions[i]['answers'][j]['answer'];
                    const allowedExtensions = ["jpg", "jpeg", "png"];

                    if (checkExtension(filename, allowedExtensions)) 
                    {
                        let ansimg = `<img src="{{ asset('public/image/ans_images/') }}/${questions[i]['answers'][j]['answer']}" width="50px" height="50px" alt="image issue">`
                        html += `<tr>
                            <td>`+(j+1)+`</td>
                                <td>`+ansimg+`</td>
                                <td>`+is_correct+`</td>
                            </tr>`;
                    } 
                    else 
                    {
                        html += `<tr>
                        <td>`+(j+1)+`</td>
                            <td>`+questions[i]['answers'][j]['answer']+`</td>
                            <td>`+is_correct+`</td>
                        </tr>`;
                    }

                   
                }
                break;
            }
        }
        $('.showAnswers').html(html);
     });

     //Edit questions

     $('#addEditAnswer').click(function()
      { 
        if($('.editAnswers').length >= 6)
        {
            $('.editError').text('You can add maximum six answers.');
            setTimeout(() => {
                $('.editError').text('');
            }, 2000);
        }
        else
        {
            var html = `
            <div class="row mt-2 editAnswers">
                <input type="radio" name="is_correct" id="" class="edit_is_correct" >
                <div class="col">
                    <input type="text" class="w-100" name="new_answers[]"  placeholder="Enter Question" required>
                </div>
                <button class="btn btn-danger removeButton">Remove</button>
            </div>`;

            $('.editModalAnswers').append(html);
        }

     });

     $('.editButton').click(function(){
        var qid = $(this).attr('data-id');

        $.ajax({
            url:"{{ route('getQnaDetails')}}",
            type:"GET",
            data:{qid:qid},
            success:function(data)
            {
               var qna = data.data[0];
               $('#question_id').val(qna['id']);
               $('#question').val(qna['question']);
               $('#explaination').val(qna['explaination']);
               $('.editAnswers').remove();
               var html = '';
                var editHtml = '';
               var editHtml = '<option value="">Subject</option>';
                    for(var i = 0;i<data.subjects.length;i++)
                    {
                        if(data.subjects[i]['id'] == qna['subject_id'])
                        {
                            editHtml += `<option value="`+data.subjects[i]['id']+`" selected>`+data.subjects[i]['name']+`</option>`;
                        }
                        else
                        {
                            editHtml += `<option value="`+data.subjects[i]['id']+`">`+data.subjects[i]['name']+`</option>`;
                        }
                        
                    }
                    $('#editSubject_id').html(editHtml);
                    $('.editSubjectRow').css('display','block');

                    var editHtmlCats = '';
                    var editHtmlCats = '<option value="">Category</option>';
                    for(var i = 0;i<data.categories.length;i++)
                    {
                        if(data.categories[i]['id'] == qna['category_id'])
                        {
                            editHtmlCats += `<option value="`+data.categories[i]['id']+`" selected>`+data.categories[i]['name']+`</option>`;
                        }
                        else
                        {
                            editHtmlCats += `<option value="`+data.categories[i]['id']+`">`+data.categories[i]['name']+`</option>`;
                        }
                        
                    }
                    $('#editCategory_id').html(editHtmlCats);
                    $('.editCategory_row').css('display','block');

               for(let i=0; i<qna['answers'].length; i++)
               {
                var checked = '';
                if(qna['answers'][i]['is_correct'] == 1)
                {
                    checked = 'checked';
                }
                  html += `<div class="row mt-2 editAnswers">
                  <input type="radio" name="is_correct" id="" class="edit_is_correct" `+checked+`>
                  <div class="col">
                      <input type="text" class="w-100" name="answers[`+qna['answers'][i]['id']+`]"  placeholder="Enter Question" value="`+qna['answers'][i]['answer']+`" required>
                  </div>
                  <button class="btn btn-danger removeButton removeAnswer" data-id="`+qna['answers'][i]['id']+`">Remove</button>
                    </div>`;
               }
            $('.editModalAnswers').append(html);
            }
        })
     });

     //update question
     $('#editQna').submit(function(e){
        e.preventDefault(); 
        
        if( $('.editAnswers').length < 2)
        {
            $('.editError').text('Please add minimum two answers.');

            setTimeout(() => {
                $('.editError').text('');
            }, 2000);
        }
        else 
        {
            var checkIsCorrect = false;

            for(var i = 0;i< $('.edit_is_correct').length;i++)
            {
                if($(".edit_is_correct:eq("+i+")").prop('checked') == true)
                {
                    checkIsCorrect = true;
                    $(".edit_is_correct:eq("+i+")").val( $(".edit_is_correct:eq("+i+")").next().find('input').val());
                }
            }

            if(checkIsCorrect)
            {
                var formData = $(this).serialize();
                // console.log(formData);
                $.ajax({
                   url:"{{ route('updateQna')}}",
                   type:"POST",
                   data:formData,
                   success:function(data)
                   {
                    console.log(data);
                        if(data.success == true)
                        {
                            location.reload();
                        }
                        else 
                        {
                            alert(data.msg);
                        }
                   } 
                });
            }
            else 
            {
                $(".editError").text("Please select anyone correct answer");
                setTimeout(() => {
                    $('.editError').text(' ');
                },2000);
            }
        }
     });

     //remove answers
    $('.deleteButton').click(function()
    {
        var id = $(this).attr('data-id');
        $('#delete_qna_id').val(id);
    })

    $('#deleteQna').submit(function(e)
    {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
        url:"{{ route('deleteQna')}}",
        type:"POST",
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
        }
       })
    })
      
    $('#addQnaButton').click(function()
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
                alert(err)
            }
        })
    })

    //=============== Category List =================//
    
    $('#subject_id').change(function()
    {
        var subject_id = $(this).val();
        
        
        $.ajax({
            url:"/category/list/"+subject_id,
            type:"GET",
            success:function(data)
            {   console.log(data);
                if(data.success == true)
                {
                    var html = '<option value="">Category</option>';
                    for(var i = 0;i<data.cats.length;i++)
                    {
                        html += `<option value="`+data.cats[i]['id']+`">`+data.cats[i]['name']+`</option>`;
                    }
                    $('#category_id').html(html);
                    $('#category_row').css('display','block');
                }
                else 
                {
                    $('#category_row').css('display','none');
                }
                
            },
            error:function(err)
            {
                alert(err)
            }
        })
    })
    
    //=============== Export Qna ===================//

    $('#exportQna').click(function()
    {
        $.ajax({
            url:"{{ route('exportQna')}}",
            type:"GET",
            success:function(data)
            {
                if(data.success == true)
                {
                    location.href = data.download_link;
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
        })
    });

    //=============== Import Qna ===================//

    $('#importQna').submit(function(e) 
    {
        e.preventDefault(); 

        var formData = new FormData(this); 

        $.ajax({
            url: "{{ route('importQna') }}", 
            type: "POST", 
            data: formData,
            processData: false, 
            contentType: false, 
            success: function(data) 
            {
                if (data.success === true) 
                {
                    location.href = data.download_link;
                }
                else 
                {
                    alert(data.msg);
                }
            },
            error: function(err) {
                alert("An error occurred: " + err.responseText);
            }
        });
    });


  });
</script>
  
@endsection