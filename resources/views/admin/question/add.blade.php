@extends('layout.admin-layout')

@section('space-work')
    <h2 class="mb-4">Q & A</h2>

    <!-- Add Q&A Form -->
    <form id="addQna" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="container mt-4">
            <div class="form-row">

                <h5 class="mb-4">Add Question and Answer</h5>

            </div>
            <!-- Subject Selection -->
            <div class="form-group">
                <label for="subject_id">Subject</label>
                <select class="form-control" name="subject" id="subject_id">
                    <option value="">Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Selection (hidden by default) -->
            <div class="form-group" id="category_row" style="display: none;">
                <label for="category_id">Categories</label>
                <select class="form-control" name="category" id="category_id">
                    <option value="">Select Category</option>
                    
                </select>
            </div>

            <!-- File Upload -->
            <div class="form-group">
                {{-- <label for="que_file">Question File</label>
                <input type="file" name="que_file" id="que_file" class="form-control-file"> --}}

                    <label for="que_file">Question Image/Figure (optional)</label>
                    <input type="file" class="dropify" name="que_file" id="que_file">
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                
            </div>

            <!-- Question Input -->
            <div class="form-group">
                <label for="question">Enter Question</label>
                <input type="text" class="form-control" name="question" id="question" placeholder="Enter Question" >
            </div>

            <!-- Explanation Textarea -->
            <div class="form-group">
                <label for="explaination">Explanation (optional)</label>
                <textarea name="explaination" id="explaination" class="form-control" placeholder="Enter your explanation (optional)"></textarea>
            </div>
            <div class="form-group">
                <button type="button" id="addAnswer" class="btn btn-primary">
                    <i class="fa fa-plus-square" style="font-size:24px"></i> Options
                </button>
            </div>
            <!-- Dynamic Answer Fields Container -->
            <div class="answers-container">
                <!-- Dynamic answer fields will be appended here -->
            </div>

            <!-- Error Message -->
            <div class="form-group">
                <span class="error text-danger"></span>
            </div>

            <!-- Form Buttons -->
            <div class="form-group">
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
                <button type="submit" class="btn btn-success">Add Q&A</button>
            </div>
        </div>
    </form>


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
    $(document).ready(function() {
    $('#addAnswer').click(function() {
        if ($('.answers').length >= 6) {
            $('.error').text('You can add a maximum of six answers.');
            setTimeout(() => {
                $('.error').text('');
            }, 2000);
        } else {
            var html = `
                <div class="row mt-2 answers">
                    <div class="col-1">
                        <input type="radio" name="is_correct" class="is_correct" value="0">
                    </div>
                    <div class="col-5">
                        <select class="option-type form-control">
                            <option value="">Select Answer Type</option>
                            <option value="text">Text</option>
                            <option value="file">File</option>
                        </select>
                    </div>
                    <div class="col-4 option-field">
                        <!-- Dynamic option field will be added here -->
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger removeButton"><i class="fa fa-trash-o" style="font-size:24px"></i> Remove</button>
                    </div>
                </div>`;
            $('.answers-container').append(html); // Changed from '.modal1' to '.answers-container'
        }
        console.log("Add Ans:" + $('.answers').length);
    });

    // Event listener for the change in option type
    $(document).on('change', '.option-type', function() {
        var selectedOption = $(this).val();
        var optionField = $(this).closest('.answers').find('.option-field');
        var radio = $(this).closest('.answers').find('.is_correct');

        if (selectedOption === 'text') {
            optionField.html('<input type="text" class="w-100 form-control" name="answers[]" placeholder="Enter Answer" required>');
            radio.val('text');
        } else if (selectedOption === 'file') {
            optionField.html('<input type="file" class="upload-image form-control-file" name="ans_images[]" accept="image/*">');
            radio.val('file');
        } else {
            optionField.empty(); // Clear field if no option is selected
            radio.val(''); // Clear radio value if no option is selected
        }
    });

    // Event listener for removing an answer
    $(document).on('click', '.removeButton', function() {
        $(this).closest('.answers').remove();
    });
});



      
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

    $('#subject_id').change(function() {
        var subjectId = $(this).val();
        
        if (subjectId) 
        {
            $.ajax({
                url: "{{ route('getCategories') }}", // Define a route for fetching categories
                type: "GET",
                data: { subject_id: subjectId },
                success: function(data) {
                    if (data.success) {
                        var html = '<option value="">Select Category</option>';
                        for (var i = 0; i < data.data.length; i++) {
                            html += `<option value="${data.data[i].id}">${data.data[i].name}</option>`;
                        }
                        $('#category_id').html(html);
                        $('#category_row').show(); // Show category row if categories are available
                    }

                    if(data.data.length == 0)
                    {
                        $('#category_row').hide();
                    }
                },
                error: function(err) {
                    alert('Error loading categories');
                }
            });
        } else {
            $('#category_row').hide(); // Hide category row if no subject selected
        }
    });

  });
</script>
  
@endsection