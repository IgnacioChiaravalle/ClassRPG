<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\User\UserWelcomeController::class, 'getUserWelcome'])->middleware('auth')->name('/');
Route::get('/log-me-in', function () {
	return view('auth.login');
})->name('/log-me-in');

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
Route::get('/manage-students/delete-student/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\StudentDeleterController::class, 'deleteStudent'])->middleware('teacherAuth');
Route::get('/manage-students/add-student', [App\Http\Controllers\Teacher\ManageStudents\StudentAdditionController::class, 'createView'])->middleware('teacherAuth');
Route::post('/manage-students/add-student', [App\Http\Controllers\Teacher\ManageStudents\StudentAdditionController::class, 'addStudent'])->middleware('teacherAuth');
Route::get('/manage-students/share-student/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\ShareStudentController::class, 'createView'])->middleware('teacherAuth');
Route::post('/manage-students/share-student/{studentName}', [App\Http\Controllers\Teacher\ManageStudents\ShareStudentController::class, 'shareStudent'])->middleware('teacherAuth');

Route::get('/manage-teachers', function () {
	return view('teacher.manage_teachers.show_teachers');
})->middleware('adminTeacherAuth')->name('/manage-teachers');
Route::get('/manage-teachers/get-teachers', [App\Http\Controllers\Teacher\ManageTeachers\TeacherManagerController::class, 'getTeachers'])->middleware('adminTeacherAuth');
Route::get('/manage-teachers/update-can-manage-teachers/{teacherName}/{canManageTeachers}', [App\Http\Controllers\Teacher\ManageTeachers\TeacherManagerController::class, 'updateCanManageTeachers'])->middleware('adminTeacherAuth');
Route::get('/manage-teachers/delete-teacher/{teacherName}', [App\Http\Controllers\Teacher\ManageTeachers\TeacherManagerController::class, 'deleteTeacher'])->middleware('adminTeacherAuth');
Route::get('/manage-teachers/add-teacher', function () {
	return view('teacher.manage_teachers.add_teacher');
})->middleware('adminTeacherAuth');
Route::post('/manage-teachers/add-teacher', [App\Http\Controllers\Teacher\ManageTeachers\TeacherAdditionController::class, 'addTeacher'])->middleware('adminTeacherAuth');

Route::get('/manage-market', [App\Http\Controllers\Teacher\ManageMarket\MarketStockController::class, 'createView'])->middleware('teacherAuth');
Route::get('/manage-market/{className}', function () {
	return view('teacher.manage_market.class_specific_market');
})->middleware('teacherAuth');
Route::get('/manage-market/get-stock/{className}', [App\Http\Controllers\Teacher\ManageMarket\MarketStockController::class, 'getClassStock'])->middleware('teacherAuth');
Route::get('/manage-market/update-marketable/{saleName}/{marketable}', [App\Http\Controllers\Teacher\ManageMarket\MarketSaleEditionController::class, 'updateMarketable'])->middleware('teacherAuth');
Route::get('/manage-market/delete-sale/{saleName}', [App\Http\Controllers\Teacher\ManageMarket\MarketSaleDeletionController::class, 'deleteSale'])->middleware('teacherAuth');
Route::get('/manage-market/add-sale/{className}', function () {
	return view('teacher.manage_market.add_sale');
})->middleware('teacherAuth');
Route::post('/manage-market/add-sale/{className}', [App\Http\Controllers\Teacher\ManageMarket\MarketSaleAdditionController::class, 'addSale'])->middleware('teacherAuth');
Route::post('/manage-market/edit-sale/{saleName}', [App\Http\Controllers\Teacher\ManageMarket\MarketSaleEditionController::class, 'editSale'])->middleware('teacherAuth');

Route::get('/manage-classes', function () {
	return view('teacher.manage_classes.rpg_classes_manager');
})->middleware('teacherAuth');
Route::get('/manage-classes/get-classes', [App\Http\Controllers\Teacher\ManageClasses\RPGClassesController::class, 'getRPGClasses'])->middleware('teacherAuth');
Route::get('/manage-classes/add-class', function () {
	return view('teacher.manage_classes.add_class');
})->middleware('teacherAuth');
Route::post('/manage-classes/add-class', [App\Http\Controllers\Teacher\ManageClasses\RPGClassAdditionController::class, 'addClass'])->middleware('teacherAuth');
Route::post('/manage-classes/edit-class/{className}', [App\Http\Controllers\Teacher\ManageClasses\RPGClassesController::class, 'editClass'])->middleware('teacherAuth');
Route::get('/manage-classes/delete-class/{className}', [App\Http\Controllers\Teacher\ManageClasses\RPGClassesController::class, 'deleteClass'])->middleware('teacherAuth');
