<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\Exam2Controller;
use App\Http\Controllers\TrialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Faculty\FacultyController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\Faculty\FacultyExamController;
use App\Http\Controllers\Faculty\FacultyStudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['register' => false]);

Route::get('/', function () { 
    return redirect()->route('login'); 
});

Route::group(['middleware'=>['auth','student']], function () {
    Route::get('/exam', [ExamController::class, 'indexz'])->name('exam');
    Route::get('/trial', [ExamController::class, 'indexTrial']); 
    Route::get('/results', [ExamController::class, 'indexResults']); 
    Route::get('/examination', [ExamController::class, 'index3'])->name('index3');
    Route::get('/mockexam', [ExamController::class, 'index4'])->name('index4');
    Route::post('/finish', [ExamController::class, 'store'])->name('stored');
});

Route::group(['middleware'=>['auth','faculty']], function () {
    Route::get('/faculty', [FacultyController::class, 'index'])->name('faculty');
    Route::get('/uploadfile', [ExamController::class, 'index2'])->name('faculty.uploadFile');
    Route::get('/createquestion', [QuestController::class, 'index1']); 

    Route::get('/questions', 'QuestController@index')->name('questions.index');
    Route::put('/questions/{questions}', 'QuestController@update')->name('questions.update');
    Route::delete('/questions/{qs}', 'QuestController@destroy')->name('questions.destroy');
    Route::get('/questions/{qs}/edit', 'QuestController@edit')->name('questions.edit');
    Route::post('/questionsupdate', 'QuestController@update')->name('questions.update');

    Route::post('/submitquestion', [QuestController::class, 'store']);
    Route::post('/destroy', [QuestController::class, 'destroy'])->name('question.destroy');
    Route::get('/download/template', [QuestController::class, 'downloadTemplate'])->name('question.download');

    Route::get('/exams', [FacultyExamController::class, 'index'])->name('faculty.exams');
    Route::get('/create-exams', [FacultyExamController::class, 'createExam'])->name('faculty.create-exam');
    Route::post('/add-exams', [FacultyExamController::class, 'addExam'])->name('faculty.add-exam');
    Route::get('/fetch-exams', [FacultyExamController::class, 'fetchExams'])->name('faculty.fetch-exam');
    Route::get('/configure-exam/{id}', [FacultyExamController::class, 'configureExam'])->name('faculty.configure-exam');
    Route::post('/update-exam', [FacultyExamController::class, 'updateExam'])->name('faculty.update-exam');
    Route::get('/exam-report/{id}', [FacultyExamController::class, 'examReport'])->name('faculty.exam-report');

    Route::get('/download-report/{id}', [FacultyExamController::class, 'downloadReport'])->name('faculty.download-report');

    Route::get('/students', [FacultyStudentController::class, 'index'])->name('faculty.student');
});

Route::get('/take-exam', function () {
    return view('takeexam');
});

// Route for view/blade file. Route::get('importExportView'[ExcelController::class, 'importExportView'])->name('importExportView'); 
Route::post('import', 'ExamController@import');
Route::post('news/store', array('as' => 'posts.store', 'uses' => 'ExamController@import'));

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/majorexam', [Exam2Controller::class, 'majorindex'])->name('majorexam');
Route::post('/submit-final-answers', [Exam2Controller::class, 'submitFinalAnswers'])->name('showResults');
Route::post('/save-page-answers', [Exam2Controller::class, 'savePageAnswers'])->name('submitmajorexam');
Route::post('/save-page-answers1', [ExamController::class, 'savePageAnswers'])->name('submittrialexam');