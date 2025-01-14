<!DOCTYPE html>
<html lang="en">
<title>SMARTQ | MAJOR EXAM</title>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('/js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="antialiased">
    <div style="background-image: url('{{ asset('assets/background.png') }}'); 
    background-size: cover; 
    background-repeat: no-repeat; 
    background-position: center center; 
    background-attachment: fixed;
    min-height: 100vh; ">
    {{-- Primary Bar --}}
    <nav class="navbar navbar-light bg-light justify-content-between px-3">
        <div>
            <a class="navbar-brand">
                <img  src="/assets/logo.png" alt="Logo" style="height: 48px; width: auto;">
            </a>
            <a class="alert-link text-decoration-none" aria-current="page" style="color: black;">
                SmartQ
            </a>  
        </div>
    </nav>
    <br>
    <div class="card px-5 pb-5 shadow" style="background-color: rgba(0, 0, 0, 0); font-family: Verdana, Geneva, Tahoma, sans-serif;">
        <!-- Greetings Text -->
        <div class="card-header p-4" style="background-color: rgba(0, 0, 0, 0.5); border-top-left-radius: 20px; border-top-right-radius: 20px;">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="h1 p-0 m-0 text-white" style="font-style: italic;">Major Exam</p>
                    <div id="get-topic"></div>
                </div>
            </div>
        </div>
        <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
            <div class="px-5 py-3 justify-content-center">
                <!-- Top Part Grid -->
                <div class="row">
                    <div class="col"><div id="progress-bar"></div></div>
                    <div class="col-2"><div id="timer"></div> <!-- this is the timer--></div>
                </div>
                <!-- The Exam Content -->
                <form method="POST" action="{{ route('submitmajorexam') }}" id="questionnaireForm">
                    @csrf
                    <!-- Hidden input to store answers before submission -->
                    <input type="hidden" name="allAnswers" id="allAnswers">
                    <input type="hidden" name="attemp" id="attemp" value="{{$attemp}}">
                    <input type="hidden" name="user" id="user" value="{{$user}}">
                    <input type="hidden" name="examtype" id="examtype" value="{{$examtype}}">
                    <!-- Question container, updated dynamically -->
                    <div id="question-container">
                        <!-- Dynamic question content will be injected here -->
                    </div>

                    <!-- Navigation buttons -->
                    <div class="d-flex justify-content-between pt-3">
                        <div class="d-flex justify-content-center flex-grow-1">
                            <button type="button" id="prevBtn" class="btn px-3 text-white" style="background-color: #292B4E;" disabled>
                                <i class="bi bi-arrow-left"></i> Previous
                            </button>
                            <button type="button" id="nextBtn" class="btn ml-2 px-9 text-white" style="background-color: #292B4E;">
                                Next <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                        <button type="submit" id="submitBtn" class="btn btn-success px-3">
                            Finish Exam <i class="bi bi-check-lg"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#navigationModal">
                        Navigate Questions
                    </button>                    
                </form>
            </div>
        </div>
        <!-- Times Up Modal -->
        <div class="modal fade" id="timesUpModal" tabindex="-1" aria-labelledby="timesUpModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content" style="background-color: #292B4E; border-radius: 20px; width: 35rem;">
                    <div class="modal-body text-white justify-content-center text-center">
                        <img src="/assets/timesup.png" alt="Times Up" style="height: 300px; margin: 0 auto;" class="py-5"/>
                        <h2 style="font-weight: bold;">Time has run out!</h2>
                        <hr class="m-4" style="border: 1px solid #ddd;"/>
                        <h4 class="px-5">Your exam has been submitted. Choose an option:</h4>
                        <button type="button" id="goToExam" class="btn btn-success m-4 pt-2 px-4" style="border-radius: 10px;">
                            <h4>Go to Exam Page</h4>
                        </button>
                        <button type="button" id="viewResults" class="btn btn-success m-4 pt-2 px-4" style="border-radius: 10px;">
                            <h4>View Results</h4>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Modal -->
        <div class="modal fade" id="navigationModal" tabindex="-1" aria-labelledby="navigationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-end">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="navigationModalLabel">Question Navigation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <!-- Bootstrap Grid Layout for Buttons -->
                            <div class="row g-2" id="questionNavigation">
                                <!-- Buttons populated dynamically -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript to manage questions and answer collection -->
    <script>
        // Load questions from backend
        const questions = @json($questions);
        
        let currentQuestionIndex = 0;
        let number = 1;
        let examTime = {{ $time }} * 60; // Multiply by 60*60 to get total seconds
        let timerInterval;
        let timerElement = document.getElementById("timer");
        
        
        // Initialize answers as a 2D array with default values set to 0
        const answers = {};

        questions.forEach(question => {
            if (!answers[question.sr]) answers[question.sr] = {}; // Initialize inner object if not present
            answers[question.sr][question.no] = 0; // Set default answer to 0
        });

        // Function to display the current question
        function displayQuestion() {
            const question = questions[currentQuestionIndex];
            const questionContainer = document.getElementById('question-container');
            const getTopic = document.getElementById('get-topic');
            const progressBar = document.getElementById('progress-bar');
            
            // Render the current question
            questionContainer.innerHTML = `
                <div>
                    <h3 class="font-weight-bold mb-3">Subtopic: ${question.subtopic}</h3>
                    <div class="row">
                        <div class="col-1 text-center">
                            <div class="justify-content-center">
                                <h1 class="font-weight-bold">${number}</h1>
                                <p>out of ${questions.length}</p>
                            </div>   
                        </div>
                        <div class="col">
                            <div class="form-field col-lg-12 pb-0"> 
                                <h5 class="label" for="name"><h5>${question.desc}</h5></label>
                                <hr class="bg-light border p-0 mt-0"/>
                                <div class="form-check">
                                    <h5><input type="radio" class="form-check-input" name="radio" value="1" ${answers[question.sr][question.no] === 1 ? 'checked' : ''}></h5>
                                    <label class="form-check-label">${question.opt1}</label>
                                </div>
                                <div class="form-check">
                                    <h5><input type="radio" class="form-check-input" name="radio" value="2" ${answers[question.sr][question.no] === 2 ? 'checked' : ''}></h5>
                                    <label class="form-check-label">${question.opt2}</label>
                                </div>
                                <div class="form-check">
                                    <h5><input type="radio" class="form-check-input" name="radio" value="3" ${answers[question.sr][question.no] === 3 ? 'checked' : ''}></h5>
                                    <label class="form-check-label">${question.opt3}</label>
                                </div>
                                <div class="form-check">
                                    <h5><input type="radio" class="form-check-input" name="radio" value="4" ${answers[question.sr][question.no] === 4 ? 'checked' : ''}></h5>
                                    <label class="form-check-label">${question.opt4}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;


            getTopic.innerHTML = `
                <p class="display-4 p-0 m-0 text-white font-weight-bold">${question.topic}</p>
            `;

            // Update the progress bar width
            const answeredPercentage = getAnsweredPercentage();
            progressBar.innerHTML = `
                <div class="row">
                    <div class="col-10 mt-2 pt-1">
                        <div class="progress" style="height: 2rem; border-radius: 2rem;">
                            <div id="progress-bar"
                                class="progress-bar progress-bar-striped progress-bar-animated"
                                role="progressbar"
                                style="width: ${answeredPercentage}%; background-color: #292B4E;"
                                aria-valuenow="${answeredPercentage}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                ${Math.round(answeredPercentage)}%
                            </div>
                        </div>
                    </div>

                    <div class="col-1">
                        <p class="display-4" style="top: -10px; position: relative;">|</p>
                    </div>

                    <div class="col-1">
                        <i class="bi bi-stopwatch-fill display-4"></i>
                    </div>
                
            `;


            // Manage button visibility
            document.getElementById('prevBtn').disabled = currentQuestionIndex === 0;
            document.getElementById('nextBtn').disabled = currentQuestionIndex === questions.length - 1;
            document.getElementById('submitBtn').style.display = currentQuestionIndex === questions.length - 1 ? 'inline-block' : 'inline-block';
        }

        // Save the selected answer for the current question, or set to 0 if none is selected
        function saveAnswer() {
            const question = questions[currentQuestionIndex];
            const selectedOption = document.querySelector('input[name="radio"]:checked');
            if (selectedOption) {
                answers[question.sr][question.no] = parseInt(selectedOption.value);
            } else {
                answers[question.sr][question.no] = 0; // Default to 0 if no selection
            }
        }
        
        // Function to calculate the percentage of questions answered
        function getAnsweredPercentage() {
            const totalQuestions = questions.length;
            let answeredQuestions = 0;

            // Count answered questions
            Object.keys(answers).forEach(questionSr => {
                Object.keys(answers[questionSr]).forEach(questionNo => {
                    if (answers[questionSr][questionNo] !== 0) {
                        answeredQuestions++;
                    }
                });
            });

            // Calculate the percentage
            return (answeredQuestions / totalQuestions) * 100;
        }
        

        function updateTimer() {
            const hours = Math.floor(examTime / 3600);
            const minutes = Math.floor((examTime % 3600) / 60);
            const seconds = examTime % 60;

            timerElement.innerHTML = ` 
                <div class="timer-container pt-1" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; justify-content: right; align-items: right;">
                    <h2 style="font-weight: bold; margin: 0;z-index: 999">${hours}h ${minutes}m ${seconds}s</h2>
                </div>
                <div class="mt-2" style="position: relative; top: -15px;">
                <div class="text-right fs-md-2 fs-lg-3">Time Left</div> 
                </div>
                </div>
            `;

            if (examTime === 0) {
                clearInterval(timerInterval);
                // Set default values for unanswered questions
                // Submit the form
                const submitButton = document.getElementById('submitBtn');
                if (submitButton) {
                    submitButton.click(); // Trigger the click event
                }
                showTimesUpModal(); // Show the modal
            }

            examTime--;
        }

        // Start the countdown timer
        function startTimer() {
            timerInterval = setInterval(updateTimer, 1000);
        }

        // Show the modal when time runs out
        function showTimesUpModal() {
            const modalElement = document.getElementById('timesUpModal');
            const modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static', // Prevent closing by clicking outside
                keyboard: false,    // Prevent closing with the ESC key
            });
            modal.show();

            // Provide options for user redirection
            document.getElementById('goToExam').addEventListener('click', function () {
                window.location.href = '/exam';
            });

            document.getElementById('viewResults').addEventListener('click', function () {
                // Replace with your logic for viewing results
                alert('View results clicked!');
            });
        }


        document.getElementById('prevBtn').addEventListener('click', function () {
            saveAnswer();
            currentQuestionIndex--;
            number--;
            displayQuestion();
        });

        document.getElementById('nextBtn').addEventListener('click', function () {
            saveAnswer();
            currentQuestionIndex++;
            number++;
            displayQuestion();
            console.log('Next button clicked');
        });

        // Before submitting, collect all answers in a hidden input field
        document.getElementById('questionnaireForm').addEventListener('submit', function (e) {
            saveAnswer(); // Save the last answer

            // Add answers object as a JSON string to the hidden input field
            document.getElementById('allAnswers').value = JSON.stringify(answers);
        });

        // Populate the navigation modal with question numbers
        function populateNavigation() {
            const questionNavigation = document.getElementById('questionNavigation');
            questionNavigation.innerHTML = ''; // Clear previous content

            questions.forEach((question, index) => {
                const questionNumber = index + 1;
                const isAnswered = Object.values(answers[question.sr] || {}).some((ans) => ans !== 0);

                // Add question button
                const button = document.createElement('button');
                button.className = `btn ${isAnswered ? 'btn-success' : 'btn-outline-secondary'} w-100`;
                button.textContent = questionNumber;
                button.onclick = () => {
                    currentQuestionIndex = index; // Jump to the selected question
                    number = questionNumber; // Update the question number
                    displayQuestion();
                    const modal = bootstrap.Modal.getInstance(document.getElementById('navigationModal'));
                    modal.hide(); // Close the modal
                };

                const col = document.createElement('div');
                col.appendChild(button);
                questionNavigation.appendChild(col);
            });
        }
        // Initial question display
        displayQuestion();
        startTimer();
        populateNavigation();
    </script>
</body>
<style>
    /* Custom Modal Sliding Animation */
.modal.fade .modal-dialog {
    transform: translateX(100%); /* Initially hide to the right */
    transition: transform 0.5s ease; /* Smooth sliding effect */
}

.modal.fade.show .modal-dialog {
    transform: translateX(0); /* Move modal into view */
}

/* Ensure the modal takes up the full height */
.modal-dialog-end {
    position: fixed;
    top: 0;
    right: 0;
    width: 300px; /* Set width of the modal */
    height: 100vh; /* Make the modal fill the entire height of the viewport */
    max-width: 100%; /* Prevent it from exceeding the width */
    margin: 0; /* Remove margins */
    display: flex;
    flex-direction: column; /* Stack header, body, footer vertically */
    z-index: 1050; /* Ensure modal appears above other content */
}

/* Modal Content */
.modal-content {
    height: 100%; /* Ensure the content stretches the full height */
    display: flex;
    flex-direction: column; /* Align header, body, footer vertically */
}

/* The modal body should be scrollable if the content overflows */
.modal-body {
    overflow-y: auto; /* Allow vertical scrolling */
    flex-grow: 1; /* Allow the body to grow and take up remaining space */
    padding: 10px;
}

/* Header and footer should not grow */
.modal-header, .modal-footer {
    flex-shrink: 0; /* Prevent the header/footer from shrinking */
}

</style>
</html>
