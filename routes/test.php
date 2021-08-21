<?php 

Route::group(['middleware' => 'web','prefix' => 'test'], function () {

	Route::get('index','TestController@index');
	Route::get('measurements','TestController@measurements');
	Route::get('measurements/{user_id}','TestController@measurements');
	Route::post('duplicate-measurements','TestController@replicate_measurements');
	Route::get('excel','TestController@excel');
	
});