<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\User\UserWelcomeController::class, 'getUserWelcome'])->middleware('auth')->name('/');
Route::get('/login-me-in', function () {
    return view('auth.login');
})->name('/login-me-in');

Route::get('/my-account', [App\Http\Controllers\User\UserAccountController::class, 'createUserDataView'])->middleware('auth');
Route::post('/my-account', [App\Http\Controllers\User\UserAccountController::class, 'editUserData'])->middleware('auth');
Route::get('/my-account/change-password', [App\Http\Controllers\User\UserAccountController::class, 'createChangePasswordView'])->middleware('auth', 'password.confirm');
Route::post('/my-account/change-password', [App\Http\Controllers\User\UserAccountController::class, 'changeUserPassword'])->middleware('auth');
Route::get('/my-account/delete-self', [App\Http\Controllers\User\UserAccountController::class, 'deleteSelf'])->middleware('auth');

Route::get('/market', [App\Http\Controllers\Student\MarketController::class, 'getMarket'])->middleware('studentAuth');
Route::get('/market/buy-item/{saleName}/{saleCost}', [App\Http\Controllers\Student\MarketController::class, 'buyItem'])->middleware('studentAuth');
Route::get('/market/heal-student/{healCost}', [App\Http\Controllers\Student\MarketController::class, 'healStudent'])->middleware('studentAuth');

Route::get('/manage-students/handle-student-data/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentDataController::class, 'captureStudentData'])->middleware('teacherAuth');
Route::post('/manage-students/handle-student-data/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentDataController::class, 'editStudentData'])->middleware('teacherAuth');
Route::post('/manage-students/edit-student-email/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentUserController::class, 'editStudentUserEmail'])->middleware('teacherAuth');
Route::get('/manage-students/delete-student/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentUserController::class, 'deleteStudent'])->middleware('teacherAuth');
Route::get('/manage-students/add-student', [App\Http\Controllers\Teacher\ManageStudents\AddStudentController::class, 'createView'])->middleware('teacherAuth');
Route::post('/manage-students/add-student', [App\Http\Controllers\Teacher\ManageStudents\AddStudentController::class, 'addStudent'])->middleware('teacherAuth');

Route::get('/manage-teachers', [App\Http\Controllers\Teacher\ManageTeachers\TeacherManagerController::class, 'createView'])->middleware('teacherAuth');
