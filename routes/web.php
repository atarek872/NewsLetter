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
Auth::routes();
Route::group( ['middleware' => 'auth' ], function() {
    Route::get('/', 'ModerationController@HomeRender')->name('Home');
//create LOB
    Route::get('/Create_LOB', 'ModerationController@CreateLOBRender')->name('create.lob');
    Route::post('/Create_LOB/action', 'ModerationController@CreateLOBAction')->name('create.lob.action');
    Route::post('/Create_LOB/Update', 'ModerationController@EditLOB')->name('create.lob.update');
    Route::post('/Create_LOB/Delete', 'ModerationController@DeleteLOB')->name('create.lob.delete');

//Create News
    Route::get('/Create_News/{id}', 'ModerationController@CreateNewsRender')->name('create.news');
    Route::post('/Create_News/Action/{id}', 'ModerationController@CreateNewsAction')->name('create.news.action');
    Route::post('/Create_News/Update}', 'ModerationController@UpdatePost')->name('create.news.update');
    Route::post('/Create_News/Delete}', 'ModerationController@DeletePost')->name('create.news.Delete');

// List News By LOB
    Route::get('/LatestActivities/{id}', 'ModerationController@NewsRender')->name('news');
    Route::get('/OnePost/{id}/{lob_id}', 'ModerationController@RenderOnePost')->name('one.Post');

});
//Route::get('grocery', 'GroceryController@Render');
//Route::post('/grocery/post', 'GroceryController@store')->name('grocery.action');



