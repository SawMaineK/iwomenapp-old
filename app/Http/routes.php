<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

# Forgot Password Confirmation
Route::get('forgot-password/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'UserController@getForgotPasswordConfirm'));
Route::post('forgot-password/{userId}/{passwordResetCode}', 'UserController@postForgotPasswordConfirm');

Route::group([/*'middleware' => 'oauth',*/ 'prefix' => 'api-v1'], function () {

    Route::resource('post', 'PostController');
    Route::resource('resource_post', 'ResourcePostController');
    Route::resource('category', 'CategoryController');
    Route::resource('author', 'AuthorController');
    Route::resource('group', 'GroupController');
    Route::resource('comment', 'CommentController');
    Route::resource('like', 'LikeController');
    Route::resource('app', 'APKController');
    Route::resource('sister_app', 'SisterAppController');
    Route::resource('resource_category', 'ResourceCategoryController');
    Route::resource('post_notification', 'PostNotificationController');
    Route::resource('seen_notification', 'SeenNotificationController');
    Route::resource('competition', 'CompetitionController');
    Route::resource('error_report', 'AndroidErrorReportController');
    Route::resource('review', 'ReviewController');

    Route::post('competitionanswer', 'CompetitionController@answer');

    Route::get('competitionanswer/{id}', 'CompetitionController@getUserAnswer');

    Route::get('competitiongroup', 'CompetitionController@getGroupUser');

    // Authentication routes...
	Route::get('auth/login', 'UserController@getLogin');
	Route::post('auth/login', 'UserController@postLogin');
	Route::get('auth/logout', 'UserController@getLogout');

	// Registration routes...
	Route::get('auth/token', 'UserController@getRegister');
	Route::post('auth/register', 'UserController@postRegister');
	
	Route::post('auth/edit/{id}', 'UserController@postEdit');
	
	Route::post('auth/photo', 'UserController@postUpload');

	Route::post('auth/role', 'UserController@postRole');

	Route::post('auth/permission', 'UserController@postPermission');

    Route::post('author/photo', 'AuthorController@postUpload');

    Route::post('like/{id}/delete', 'LikeController@destroy');

	Route::post('post/photo', 'PostController@postUpload');

	Route::post('resource_post/photo', 'ResourcePostController@postUpload');

	Route::post('post/audio', 'PostController@postUploadAudio');

	Route::post('post/video', 'PostController@postUploadVideo');

	Route::post('resource_category/photo', 'ResourceCategoryController@postUpload');

	Route::post('sister_app/photo', 'SisterAppController@postUpload');

	Route::get('post/count/{user_id}', 'PostController@getCount');

	Route::post('download/audio/{filename}', 'PostController@postDownloadAudio');

	# Account Activation
	Route::get('activate/{userId}', 'UserController@getActivate');

	# Forget Password
	Route::post('forget-password', 'UserController@postForgotPassword');


});


Route::get('/api-v1/app_vesion', function(){
	$app['version_id'] = 1;
	$app['version_name'] = '1.1';
	$app['updated_at'] ='2015-09-01';
	return response()->json($app);
});





//admin routes

Route::get('/administration',    	'AdminLoginController@getadminlogin');
Route::post('/administration',    	'AdminLoginController@postLogin');

Route::group(['middleware' => 'auth', 'prefix' => 'admin', ], function ()
{
	Route::get('/logout', 				'AdminLoginController@logout');
    Route::get('/dashboard',            'AdminLoginController@dashboard');

    Route::resource('users',            'UsersController');
    Route::post('users/{id}',       	'UsersController@update');
    Route::get('users/{id}/delete',     'UsersController@destroy');

    Route::resource('competition-question',             'CompetitionQuestionController');
    Route::post('competition-question/{id}/update',     'CompetitionQuestionController@update');
    Route::get('competition-question/{id}/delete',      'CompetitionQuestionController@destroy');

    Route::resource('competition-answers',              'CompetitionAnswerController');
    Route::get('competition-answers-correct/{id}',      'CompetitionAnswerController@correct');
    Route::get('competition-answers-uncorrect/{id}',    'CompetitionAnswerController@uncorrect');
    Route::resource('group-users',    		            'GroupUserController');

});
