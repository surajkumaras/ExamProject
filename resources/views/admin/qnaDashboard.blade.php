@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Q & A</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModel">
        Add Q&A
    </button>

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
                <form id=addQna>
                    @csrf
                  <div class="modal-body">
                      <div class="row">
                        <div class="col">
                            <input type="text" class="w-100" name="question" id="" placeholder="Enter Question" required>
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
<script>
  $(document).ready(function(){
     $('#addQna').submit(function(e){
        e.preventDefault(); 

        if($('.answers').length <2)
        {
            $('.error').text('Please add minimum two answers.');
            setTimeout(() => {
                $('.error').text('');
            }, 2000);
        }
        else 
        {
            var checkIsCorrect = false;

            for(let i = 0;i< $('.is_correct').length;i++)
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
                    $('.error').text("");
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
                    <input type="text" class="w-100" name="answers[]" id="" placeholder="Enter Question" required>
                </div>
                <button class="btn btn-danger removeButton">Remove</button>
            </div>`;

            $('.modal-body').append(html);
        }

     });

     $(document).on('click','.removeButton',function()
     {
        $(this).parent().remove();
     })
  });
</script>
  
@endsection