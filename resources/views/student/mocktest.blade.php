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
                    <option value="{{ $subject->id}}">{{$subject->name}}</option>    
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
        <div id="questions-container">
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
    .container 
    {
        width: 100%;
        padding-right: 0px;
        padding-left: 0px;
        margin-right: auto;
        margin-left: auto;
    }

/* Container for each question */
.question-container {
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 0px;
    margin-bottom: 20px;
}

/* Styling for answer options */
.answer-label {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 16px;
    z-index: 999;
}

/* Custom radio button design */
.answer-label input[type="radio"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 50%;
}

.answer-label:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, change the background color */
.answer-label input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Hide the default radio button */
.answer-label input:checked ~ .checkmark:after {
    display: block;
}

/* Show the dot/circle when radio button is checked */
.answer-label .checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Position the dot/circle */
.answer-label .checkmark:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
}

/* Style for answer number */
.answer-number {
    font-weight: bold;
    margin-right: 5px;
}

/* Button style */
.btn-submit {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.btn-submit:hover {
    background-color: #45a049;
}

        .time {
            overflow: hidden;
            position: fixed;
            top: 0;
            font-size: 24px;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            animation: pulse 1s infinite alternate;
            z-index: 1000;
        }
        #time {
            overflow: hidden;
            position: fixed;
            top: 0;
            font-size: 24px;
            color: #fff;
            background-color: #ff0000;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            animation: pulse 0.5s infinite alternate;
            z-index: 1000;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
    
            100% {
                transform: scale(1.1);
            }
        }
    </style>
    
@endsection