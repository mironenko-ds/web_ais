<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
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

// Route::get('/clear-cache', function() {
//     Artisan::call('cache:clear');
//     return "Cache is cleared";
// });

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/register', function () {
    return redirect()->route('login');
});

Route::post('/register', 'User\UserController@store');

Route::get('/new-user', 'User\UserController@newUser')->name('new.user');
// protected routes

Route::group(['middleware' => 'auth', 'namespace' => 'File'], function () {
    Route::get('app/uploads/{id}/feedback/{hash}/{filename}', 'FeedbackFileController@getFile');
});

Route::group(['middleware' => 'auth', 'namespace' => 'File'], function () {
    Route::get('app/uploads/{id}/works/{hash}/{filename}', 'WorkFileController@getFile');
});


Route::group(['middleware' => 'auth'], function () {
    // user pages
    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('/index', 'UserController@index')->name('user.index');
        Route::get('/account', 'UserController@account')->name('user.account');
        Route::get('/my-work', 'UserController@myWorks')->name('user.works');
        Route::get('/add-work', 'UserController@addWork')->name('user.addWork');
        Route::get('/feedback', 'UserController@feedback')->name('user.feedback');
        Route::get('/work/{id}', 'UserController@work')->name('user.work');
        Route::get('/my-message', 'UserController@MyMessage')->name('user.message');
        Route::post('/reset-email', 'UserController@resetEmail')->name('user.resetEmail');
        Route::post('/reset-password', 'UserController@resetPassword')->name('user.resetPass');
        Route::post('/send-message', 'UserController@sendMessage')->name('user.sendMessange');
        Route::post('/message', 'UserController@sendMessageUser')->name('user.sendMessageUser');
        Route::post('/create-work', 'UserController@CreateWork')->name('user.CreateWork');
        Route::post('/edit-work', 'UserController@EditWork')->name('user.EditWork');
        Route::get('/change-message/{id}', 'UserController@changeStatusMessage');
        Route::post('/delete-message/{id}', 'UserController@deleteMessage')->name('user.delete-message');
        Route::post('/deleteAllMessage', 'UserController@deleteAllMessage')->name('user.deleteAllMessage');
    });

    // moder pages
    Route::group(['prefix' => 'moderator', 'namespace' => 'Moderator', 'middleware' => 'moderator'], function(){
        Route::get('/index', 'ModeratorController@index')->name('moderator.index');
        Route::get('/employees', 'ModeratorController@employees')->name('moderator.employees');
        Route::post('/employees-edit', 'ModeratorController@employeesEdit')->name('moderator.employeesEdit'); // edit
        Route::post('/employees-delete', 'ModeratorController@employeesDelete')->name('moderator.employeesDelete'); // edit
        Route::get('/request-work', 'ModeratorController@requestWork')->name('moderator.requestWork');
        Route::post('/request-work-add', 'ModeratorController@requestWorkAdd')->name('moderator.requestWorkAdd'); // add work
        Route::post('/request-work-revision', 'ModeratorController@requestWorkRevision')->name('moderator.requestWorkRevision');
        Route::get('/add-user', 'ModeratorController@addUser')->name('moderator.addUser');
        Route::post('/user-add', 'ModeratorController@userAdd')->name('moderator.userAdd');
        Route::post('/no-add-user', 'ModeratorController@noAddUser')->name('moderator.noAddUser');
        Route::get('/users-question', 'ModeratorController@usersQuestion')->name('moderator.usersQuestion');
        Route::post('/users-question-answer', 'ModeratorController@usersQuestionAnswer')->name('moderator.usersQuestionAnswer'); // answer
        Route::get('/works', 'ModeratorController@works')->name('moderator.works');
        Route::get('/work/{id}', 'ModeratorController@work')->name('moderator.work');
        Route::post('/edit-work', 'ModeratorController@editWork')->name('moderator.editWork');
        Route::get('/add-work', 'ModeratorController@addWork')->name('moderator.addWork');
        Route::post('/new-work', 'ModeratorController@newWork')->name('moderator.newWork');
        Route::post('/delete-work', 'ModeratorController@deleteWork')->name('moderator.deleteWork');
        Route::get('/feedback', 'ModeratorController@feedback')->name('moderator.feedback');
        Route::post('/feedback-send', 'ModeratorController@feedbackSend')->name('moderator.feedbackSend');
        Route::get('/account', 'ModeratorController@account')->name('moderator.account');
        Route::get('/my-message', 'ModeratorController@myMessage')->name('moderator.myMessage');

        //Route::get('/send-mail', 'ModeratorController@sendMail')->name('moderator.sendMail');
    });

    // admin pages
    Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'Administrator'], function(){
        Route::get('/index', 'AdministratorController@index')->name('admin.index');
        Route::get('/users', 'EmployeeController@users')->name('admin.users');
        Route::get('/facilty/{id}', 'AdministratorController@faculty')->name('admin.faculty');
        Route::post('/edit-departament', 'AdministratorController@departamentEdit')->name('admin.departamentEdit');
        Route::post('/new-departament', 'AdministratorController@departamentNew')->name('admin.departamentNew');

        Route::post('/edit-faculty', 'AdministratorController@facultyEdit')->name('admin.facultyEdit');
        Route::post('/new-faculty', 'AdministratorController@facultyNew')->name('admin.facultyNew');

        Route::post('delete-departament', 'AdministratorController@deleteDepartament')->name('admin.deleteDepartament');
        Route::post('delete-faculty', 'AdministratorController@deleteFaculty')->name('admin.deleteFaculty');

        Route::get('/academiс-degree', 'AdministratorController@degreeShow')->name('admin.degreeShow');
        Route::post('/academiс-degree-edit', 'AdministratorController@degreeEdit')->name('admin.degreeEdit');
        Route::post('/academiс-degree-delete', 'AdministratorController@degreeDelete')->name('admin.degreeDelete');
        Route::post('/academiс-degree-new', 'AdministratorController@degreeNew')->name('admin.degreeNew');

        Route::get('/post', 'AdministratorController@postShow')->name('admin.postShow');
        Route::post('/post-edit', 'AdministratorController@postEdit')->name('admin.postEdit');
        Route::post('/post-delete', 'AdministratorController@postDelete')->name('admin.postDelete');
        Route::post('/post-new', 'AdministratorController@postNew')->name('admin.postNew');

        // обработка типов работы
        Route::get('/type-work', 'AdministratorController@typeWorkShow')->name('admin.typeWorkShow');
        Route::post('/type-work-edit', 'AdministratorController@typeWorkEdit')->name('admin.typeWorkEdit');
        Route::post('/type-work-delete', 'AdministratorController@typeWorkDelete')->name('admin.typeWorkDelete');
        Route::post('/type-work-new', 'AdministratorController@typeWorkNew')->name('admin.typeWorkNew');

        Route::get('/work-group/{id}', 'AdministratorController@workGroupShow')->name('admin.workGroupShow');
        Route::post('/work-group-edit', 'AdministratorController@workGroupEdit')->name('admin.workGroupEdit');
        Route::post('/work-group-delete', 'AdministratorController@workGroupDelete')->name('admin.workGroupDelete');
        Route::post('/work-group-new', 'AdministratorController@workGroupNew')->name('admin.workGroupNew');

        Route::get('/works/{id}', 'AdministratorController@worksShow')->name('admin.worksShow');
        Route::post('/works-edit', 'AdministratorController@worksEdit')->name('admin.worksEdit');
        Route::post('/works-delete', 'AdministratorController@worksDelete')->name('admin.worksDelete');
        Route::post('/works-new', 'AdministratorController@worksNew')->name('admin.worksNew');



        Route::post('/delete-user', 'EmployeeController@deleteUser')->name('admin.del-user');
        Route::post('/update', 'EmployeeController@update')->name('admin.update');
        Route::get('/questions', 'AdministratorController@questions')->name('admin.questions');
        Route::get('/management', 'AdministratorController@management')->name('admin.management');
        Route::get('/account', 'AdministratorController@account')->name('admin.account');
    });
});
