<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .quiz-container {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 10px;
        }

        .quiz-header h2 {
            font-size: 1.5rem;
        }

        .quiz-content {
            background-color: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-check-label {
            font-size: 1.1rem;
        }

        .quiz-navigation button {
            width: 48%;
        }

        .quiz-submit button {
            width: 100%;
            padding: 10px;
            font-size: 1.2rem;
        }

        .timer {
            font-size: 1.2rem;
        }

        @media (max-width: 576px) {
            .quiz-header h2 {
                font-size: 1.2rem;
            }

            .form-check-label {
                font-size: 1rem;
            }

            .quiz-navigation button {
                width: 100%;
                margin-bottom: 10px;
            }
        }

    </style>
</head>
<body>

    <div class="container-fluid quiz-container">
        <!-- Quiz Header -->
        <div class="quiz-header text-center">
            <h3>{{$category[0]->subject->name}} - {{$category[0]->name}}</h3>
            {{-- <div class="timer mt-2">
                <span>Time Left: </span>
                <span id="timer">03:00</span> 
            </div> --}}
        </div>
    
        <!-- Quiz Questions -->
        <form method="POST" action="{{ route('mocktest.result')}}"> {{-- Assuming you have a route for form submission --}}
            @csrf
            <input type="hidden" name="category_id" value="{{ $category[0]->id }}">
            @foreach ($questions as $index => $question)
                <div class="quiz-content mt-4" id="question{{ $index }}" style="display: none;">
                    <h4>Question {{ $index + 1 }} of {{ $questions->count() }}</h4>
                    <p>{{ $question->question }}</p>
    
                    <!-- Options/Answers -->
                    <div class="options-list">
                        @foreach ($question->answers as $answer)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" id="answer{{ $answer->id }}" value="{{ $answer->id }}">
                                <label class="form-check-label" for="answer{{ $answer->id }}">
                                    {{ $answer->answer }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
    
            <!-- Navigation and Submit -->
            <div class="quiz-navigation mt-4 d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
            </div>
    
            <!-- Submit Button -->
            <div class="quiz-submit mt-4 text-center">
                <button type="submit" class="btn btn-success" style="display: none;" id="submitBtn">Submit Quiz</button>
            </div>
        </form>
    </div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let currentQuestion = 0;
    const totalQuestions = {{ $questions->count() }};

    // Function to show the current question
    function showQuestion(index) {
        document.querySelectorAll('.quiz-content').forEach((element, idx) => {
            element.style.display = (idx === index) ? 'block' : 'none';
        });

        // Disable "Previous" button on the first question
        document.getElementById('prevBtn').disabled = (index === 0);

        // Hide "Next" button and show "Submit" on the last question
        if (index === totalQuestions - 1) {
            document.getElementById('nextBtn').style.display = 'none';
            document.getElementById('submitBtn').style.display = 'inline-block';
        } else {
            document.getElementById('nextBtn').style.display = 'inline-block';
            document.getElementById('submitBtn').style.display = 'none';
        }
    }

    // Show the first question initially
    showQuestion(currentQuestion);

    // "Next" button click handler
    document.getElementById('nextBtn').addEventListener('click', () => {
        if (currentQuestion < totalQuestions - 1) {
            currentQuestion++;
            showQuestion(currentQuestion);
        }
    });

    // "Previous" button click handler
    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentQuestion > 0) {
            currentQuestion--;
            showQuestion(currentQuestion);
        }
    });
</script>
</body>
</html>