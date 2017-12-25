<?php

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

Route::get( '/', 'SurveyController@index' )->name( 'home' );

Route::group( [ 'as' => 'survey.' ], function () {
	Route::get( '/create', 'SurveyController@create' )->name( 'create' );
	Route::post( '/create', 'SurveyController@store' )->name( 'store' );
	Route::get( '/created/{survey_slug}', 'SurveyController@created' )->name( 'created' );

	Route::get( '/survey/{survey}/login', 'SurveyController@login' )->name( 'login' );
	Route::post( '/survey/{survey}/login', 'SurveyController@auth' )->name( 'auth' );
	Route::get( '/survey/{survey}', 'SurveyController@view' )->name( 'view' );
	Route::post( '/survey/{survey}', 'SurveyController@answer' )->name( 'answer' );
	Route::get( '/preview/{survey}', 'SurveyController@preview' )->name( 'preview' );
	Route::get( '/manage/{survey_slug}', 'SurveyController@manage' )->name( 'manage' );
	Route::get( '/manage/{survey_slug}/login', 'SurveyController@manage_login' )->name( 'manage_login' );
	Route::post( '/manage/{survey_slug}/login', 'SurveyController@manage_auth' )->name( 'manage_auth' );
	Route::post( '/manage/{survey_slug}/logout', 'SurveyController@manage_logout' )->name( 'manage_logout' );
	Route::post( '/manage/{survey_slug}', 'SurveyController@manage_delete' )->name( 'manage_delete' );
} );