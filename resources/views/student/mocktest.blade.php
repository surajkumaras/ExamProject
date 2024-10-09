@extends('layout.layout-common')

@section('space-work')
<style>
    
</style>
   
<div class="container mt-5">
    <!-- Select Subject Section -->
    <div class="row mb-4">
        <div class="col-12">
            <select name="subject" id="subject" class="form-select">
                <option value="1" disabled selected>Select Subject</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>    
                @endforeach
            </select>
        </div>
    </div>

    <!-- Select Category Section (Initially hidden) -->
    <div id="category-container" class="row mb-4 d-none">
        <div class="col-12">
            <select name="category" id="category" class="form-select">
                <option value="">Select Category</option>
            </select>
        </div>
    </div>

    <!-- Quiz Form Section -->
    <form id="quiz-form">
        @csrf
        <div id="questions-container" class="row">
            <!-- Dynamic questions and answers will be appended here -->
        </div>

        <!-- Submit Button (Initially hidden) -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" id="submit-quiz" class="btn btn-primary d-none w-100">Submit Quiz</button>
            </div>
        </div>
    </form>

    <!-- Results Section -->
    <div id="results-container" class="row mt-5">
        <div class="col-12">
            <!-- Quiz results will be displayed here -->
        </div>
    </div>
</div>




    <script>
        $(document).ready(function()
        {
            $('#subject').change(function()
            {
                let subject_id = $(this).val();
                
                $.ajax({
                    url: "{{ url('/category') }}/" + subject_id,
                    type: "GET",
                    success: function(response)
                    {
                        $('#category').empty();
                        $('#category').append('<option value="1">Select Category</option>');

                        if (response.data.length > 0) 
                        {
                            $.each(response.data, function(key, value) 
                            {
                                $('#category').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });

                            $('#category-container').removeClass('d-none');
                        } 
                        else 
                        {
                            $('#category-container').addClass('d-none');
                        }
                    },
                    error:function(error)
                    {
                        console.log(error);
                    }
                });
            });

            //=================== Get question based on category Id ===================//
        let resp;
        $('#category').change(function() 
        {
            let category_id = $(this).val();

            $.ajax({
                url: "{{ url('/category/exam') }}/" + category_id,
                type: "GET",
                success: function(response) 
                { 
                    resp = response;
                    if (response.success && response.data.length > 0) 
                    {
                        $('#questions-container').empty();
                        $('#submit-quiz').removeClass('d-none'); 

                        // Loop through each question
                        $.each(response.data, function(index, question) 
                        {
                            let questionHtml = '<div class="question-block">' +
                                '<h4>' + (index + 1) + '. ' + question.question + '</h4>' +
                                '<div class="options">';

                            // Loop through each answer for this question and create radio buttons
                            $.each(question.answers, function(key, answer) 
                            {
                                questionHtml += '<div class="form-check">' +
                                    '<input class="form-check-input" type="radio" id="' + answer.id + '" name="question_' + question.id + '" value="' + answer.id + '">' +
                                    '<label class="form-check-label" for="' + answer.id + '">' + answer.answer + '</label>' +
                                    '</div>';
                            });

                            questionHtml += '</div></div>';

                            $('#questions-container').append(questionHtml);
                        });
                    } else {
                        $('#questions-container').html('<p>No questions found for this category.</p>');
                        $('#submit-quiz').addClass('d-none'); // Hide submit button if no questions
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
    });

    $('#submit-btn').prop('disabled', true);
 

    $('#quiz-form').submit(function(e) 
    {
        e.preventDefault();

        $('#quiz-form').addClass('d-none');

        let selectedAnswers = $(this).serializeArray(); // User-selected answers
        let score = 0; // To calculate score
        let totalQuestions = resp.data.length;

        // Prepare a lookup for correct answers
        let correctAnswers = {};
        let userAnswers = {}; 

        resp.data.forEach(question => {
            question.answers.forEach(answer => {
                if (answer.is_correct === 1) {
                    correctAnswers['question_' + question.id] = answer.id;
                }
            });
        });

        // Check selected answers and store for comparison
        $.each(selectedAnswers, function(index, answer) 
        {
            let questionName = answer.name; 
            let selectedAnswerId = answer.value;

            userAnswers[questionName] = selectedAnswerId;

            if (correctAnswers[questionName] && correctAnswers[questionName] == selectedAnswerId) 
            {
                score++;
            }
        });

        // Show the results
        $('#results-container').empty(); // Clear previous results
        resp.data.forEach(function(question, index) {
            let questionHtml = '<div class="question-block">' +
                '<h4>' + (index + 1) + '. ' + question.question + '</h4>' +
                '<div class="options">';

            // Loop through each answer to display it with correct/wrong indication
            question.answers.forEach(function(answer) 
            {
                let inputId = 'question_' + question.id + '_answer_' + answer.id; // Unique ID for each input
                let selectedClass = '';

                // Check if this answer is the user's selected answer
                if (userAnswers['question_' + question.id] == answer.id) 
                {
                    selectedClass = (answer.is_correct === 1) ? 'text-success' : 'text-danger selected-answer'; // Highlight correct/incorrect
                }  

                let correctClass = (answer.is_correct === 1) ? 'font-weight-bold text-success' : '';

                let isChecked = userAnswers['question_' + question.id] == answer.id ? 'checked' : '';

                questionHtml += '<div class="form-check ' + selectedClass + '">' +
                    '<input class="form-check-input" type="radio" name="question_' + question.id + '" value="' + answer.id + '" ' + isChecked + ' disabled>' + // Disable the input after submitting
                    '<label class="form-check-label ' + correctClass + '">' +
                    answer.answer +
                    '</label>' +
                    '</div>';
                // questionHtml += '<div class="form-check ' + selectedClass + '">' +
                //     '<label class="form-check-label ' + correctClass + '">' +
                //     answer.answer +
                //     '</label>' +
                //     '</div>';
            });

            questionHtml += '</div></div>';
            $('#results-container').append(questionHtml);
        });

        // Display the final score
        $('#results-container').append('<h3>Your score: ' + score + ' out of ' + totalQuestions + '</h3>');
    });
 });
    </script>

<style>
 /* Ensure proper padding on smaller devices */
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    /* Make sure the form elements and options adjust to screen width */
    @media (max-width: 576px) {
        .form-select {
            font-size: 14px; /* Smaller font size for mobile */
        }

        .form-check-label {
            font-size: 14px; /* Smaller font size for labels */
        }

        /* Adjust the submit button */
        #submit-quiz {
            font-size: 16px;
            padding: 12px;
        }

        /* Improve layout for results */
        #results-container .question-block h4 {
            font-size: 16px;
        }
    }

    /* Customize radio buttons and question options */
    .form-check {
        margin-bottom: 10px;
    }

    .selected-answer {
        background-color: #f8d7da;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

</style>
    
@endsection