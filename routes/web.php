<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\User\UserWelcomeController::class, 'getUserWelcome'])->middleware('auth')->name('/');;
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/mercado', [App\Http\Controllers\Student\MarketController::class, 'getMarket'])->middleware('studentAuth');
Route::get('/mercado/buy-item/{saleName}/{saleCost}', [App\Http\Controllers\Student\MarketController::class, 'buyItem'])->middleware('studentAuth');
Route::get('/mercado/heal-student/{healCost}', [App\Http\Controllers\Student\MarketController::class, 'healStudent'])->middleware('studentAuth');

Route::get('/manage-students/handle-student-data/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentDataController::class, 'captureStudentData'])->middleware('teacherAuth');
Route::post('/manage-students/handle-student-data/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentDataController::class, 'editStudentData'])->middleware('teacherAuth');
Route::post('/manage-students/handle-student-data/edit-email/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentDataController::class, 'editStudentUserEmail'])->middleware('teacherAuth');
Route::get('/manage-students/add-student', [App\Http\Controllers\Teacher\ManageStudents\AddStudentController::class, 'createView'])->middleware('teacherAuth');
Route::post('/manage-students/add-student', [App\Http\Controllers\Teacher\ManageStudents\AddStudentController::class, 'addStudent'])->middleware('teacherAuth');
Route::get('/manage-students/delete-student', [App\Http\Controllers\Teacher\ManageStudents\DeleteStudentController::class, 'createView'])->middleware('teacherAuth');
Route::post('/manage-students/delete-student', [App\Http\Controllers\Teacher\ManageStudents\DeleteStudentController::class, 'deleteStudent'])->middleware('teacherAuth');

