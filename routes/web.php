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

    Route::get('/{company}/branches', 'BranchController@index')->name('branches.index');
    Route::get('/{company}/branches/create', 'BranchController@create')->name('branches.create');
    Route::post('/{company}/branches', 'BranchController@store')->name('branches.store');
    Route::get('/branches/{branch}/edit', 'BranchController@edit')->name('branches.edit');
    Route::put('/branches/{branch}', 'BranchController@update')->name('branches.update');
    Route::delete('/branches/{branch}', 'BranchController@destroy')->name('branches.destroy');
    Route::get('/branches/{id}/getbranches', 'BranchController@get_branches')->name('branches.getbraches');

    Route::get('/{branch}/departments', 'DepartmentController@index')->name('departments.index');
    Route::get('/{branch}/departments/create', 'DepartmentController@create')->name('departments.create');
    Route::post('/{branch}/departments', 'DepartmentController@store')->name('departments.store');
    Route::get('departments/{department}/edit', 'DepartmentController@edit')->name('departments.edit');
    Route::put('/departments/{department}', 'DepartmentController@update')->name('departments.update');
    Route::delete('/departments/{department}', 'DepartmentController@destroy')->name('departments.destroy');
    Route::get('/departments/{id}/getdepartments', 'DepartmentController@get_departments')->name('departments.getdepartments');

    Route::get('/{department}/employees', 'EmployeeController@index')->name('employees.index');
    Route::get('/{department}/employees/create', 'EmployeeController@create')->name('employees.create');
    Route::post('/{department}/employees', 'EmployeeController@store')->name('employees.store');
    Route::get('/employees/{employee}/edit', 'EmployeeController@edit')->name('employees.edit');
    Route::put('/employees/{employee}', 'EmployeeController@update')->name('employees.update');
    Route::delete('/employees/{employee}', 'EmployeeController@index')->name('employees.destroy');
    Route::get('employees/{id}/getemployees', 'EmployeeController@get_employees')->name('employees.getemployees');
});

Auth::routes();


