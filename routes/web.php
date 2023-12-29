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

Route::get('/', function () {
    return view('auth/login');
});

// Route::get('/', function () {
//     return view('companyProfile');
// });

Auth::routes();

Route::get('view-data', 'AuthorizationController@viewData');
Route::get('create-data', 'AuthorizationController@createData');
Route::get('edit-data', 'AuthorizationController@editData');
Route::get('update-data', 'AuthorizationController@updateData');
Route::get('delete-data', 'AuthorizationController@deleteData');

Route::group(['middleware' => ['role:User|Staff Desa']], function () {
    Route::prefix('surat')->group(function () {
        Route::get('create', 'SuratController@create')->name('suratcreate');
        Route::post('create/store', 'SuratController@store')->name('suratstore');
        Route::get('edit/{id}', 'SuratController@edit')->name('suratedit');
        Route::post('update', 'SuratController@update')->name('suratupdate');
        Route::post('onChangeTypeSurat', 'SuratController@onChangeTypeSurat')->name('onChangeTypeSurat');
        Route::post('getDataOnPrint', 'SuratController@getDataOnPrint')->name('getDataOnPrint');
        Route::post('generateSuratPDF', 'SuratController@generateSuratPDF')->name('geerateSuratPDF');
    });
});

Route::group(['middleware' => ['role:Staff Desa']], function () {
    Route::prefix('templatesurat')->group(function () {
        Route::get('/', 'TemplateSuratController@index')->name('templatesurat');
        Route::get('create', 'TemplateSuratController@create')->name('templatesuratcreate');
        Route::post('create/store', 'TemplateSuratController@store')->name('templatesuratstore');
        Route::get('edit/{id}', 'TemplateSuratController@edit')->name('templatesuratedit');
        Route::post('update', 'TemplateSuratController@update')->name('templatesuratupdate');
        Route::delete('destroy/{id}', 'TemplateSuratController@destroy')->name('templatesuratdestroy');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@index')->name('user');
        Route::post('getDataUserByID', 'UserController@getDataUserByID')->name('getDataUserByID');
        Route::post('giveUserRole', 'UserController@giveUserRole')->name('giveUserRole');
    });
});

Route::group(['middleware' => ['role:User|Staff Desa|Guest']], function () {
    Route::prefix('home')->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
    });

    Route::prefix('user')->group(function () {
        Route::get('edit/{id}', 'UserController@edit')->name('useredit');
        Route::post('update/{id}', 'UserController@update')->name('userupdate');
    });

    Route::get('/surat/', 'SuratController@index')->name('surat');
});

// Route::get('/user/list', 'UserController@store')->name('list');
// Route::get('/user/add', 'UserController@add')->name('add_data');
// Route::post('/user/save', 'UserController@create')->name('create_user');
// Route::get('/user/edit/{id}', 'UserController@edit')->name('edit');
// Route::get('/user/delete/{id}', 'UserController@destroy')->name('destroy');
// Route::post('/user/update/{id}', 'UserController@update')->name('update');
// Route::get('/user/show/{id}', 'UserController@show')->name('show');
// Route::get('/user/trash', 'UserController@trash')->name('trash_user');
// Route::get('/user/restore/{id}', 'UserController@restore')->name('restore_user');
// Route::get('/user/del_permanent/{id}', 'UserController@delete')->name('delete_user');
// Route::get('/user/restore_all', 'UserController@restore_all')->name('restore_all_user');
// Route::get('/user/delete_all', 'UserController@delete_all')->name('delete_all_user');
