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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/companies/getcompanies', 'CompanyController@get_companies')->name('company_get_data');
    Route::resource('companies', 'CompanyController');

    Route::get('/branches/{company}', 'BranchController@index')->name('branches.index');
    Route::get('/branches/create', 'BranchController@create')->name('branches.create');
    Route::post('/branches', 'BranchController@store')->name('branches.store');
    Route::get('/branches/{branch}/edit', 'BranchController@edit')->name('branches.edit');
    Route::put('/branches/{branch}', 'BranchController@update')->name('branches.update');
    Route::delete('/branches/{branch}', 'BranchController@destroy')->name('branches.destroy');
    Route::get('/branches/{id}/getbranches', 'BranchController@get_branches')->name('branches.getbraches');

    Route::get('departments/{branch}', 'DepartmentController@index')->name('departments.index');
    Route::get('/departments/create', 'BranchController@create')->name('departments.create');
    Route::post('/departments', 'DepartmentController@store')->name('departments.store');
    Route::get('departments/{department}/edit', 'DepartmentController@edit')->name('departments.edit');
    Route::put('/departments/{department}', 'DepartmentController@update')->name('departments.update');
    Route::delete('/departments/{department}', 'DepartmentController@destroy')->name('departments.destroy');
    Route::get('/departments/{id}/getdepartments', 'DepartmentController@get_departments')->name('departments.getdepartments');
});

Auth::routes();


