@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Q & A</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModel">
        Add Q&A
    </button>
    <table class="table">
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
                            <button class="btn btn-info editButton" data-id="{{ $question->id}}" data-toggle="modal" data-target="#editAnsModel">Edit</button>
                        
                            <button class="btn btn-danger deleteButton" data-id="{{ $question->id}}" data-toggle="modal" data-target="#deleteExamModel">Delete</button>
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
    <div class="modal-dialog">
        
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Q&A</h5>

                    <button id="addAnswer" class="btn btn-info ml-5">Add Answer</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="addQna" method="POST">
                    @csrf
                  <div class="modal-body modal1">
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
                    $(".is_correct:eq("+i+")").val( $(".is_correct:eq("+i+")").next().find('input').val());
                }
            }

            if(checkIsCorrect)
            {
                var formData = $(this).serialize();

                $.ajax({
                   url:"{{ route('addQna')}}",
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
                $(".error").text("Please select anyone correct answer");
                setTimeout(() => {
                    $('.error').text(' ');
                },2000);
            }
        }
     });

     //add answers
     $('#addAnswer').click(function()
      {  
        if($('.answers').length >= 6)
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
                <input type="radio" name="is_correct" id="" class="is_correct" >
                <div class="col">
                    <input type="text" class="w-100" name="answers[]"  placeholder="Enter Question" required>
                </div>
                <button class="btn btn-danger removeButton">Remove</button>
            </div>`;

            $('.modal1').append(html);
        }
        console.log("Add Ans:"+$('.answers').length);
     });

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
                    html += `<tr>
                        <td>`+(j+1)+`</td>
                            <td>`+questions[i]['answers'][j]['answer']+`</td>
                            <td>`+is_correct+`</td>
                        </tr>`;
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
      
    
  });
</script>
  
@endsection