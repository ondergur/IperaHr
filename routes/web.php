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
    return view('auth.login');
});

Route::group(['middleware' => ['auth']], function (){
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::get('/companies/getcompanies', 'CompanyController@get_companies')->name('company_get_data');
    Route::resource('companies', 'CompanyController');

    Route::get('/companies/{company}/branches', 'BranchController@index')->name('branches.index');
    Route::get('/branches/create', 'BranchController@create')->name('branches.create');
    Route::post('/branches', 'BranchController@store')->name('branches.store');
    Route::get('/branches/{branch}/edit', 'BranchController@edit')->name('branches.edit');
    Route::put('/branches/{branch}', 'BranchController@update')->name('branches.update');
    Route::delete('/branches/{branch}', 'BranchController@destroy')->name('branches.destroy');

    Route::get('/companies/{id}/branches/getbranches', 'BranchController@get_branches')->name('branches.getbraches');
});

Auth::routes();


