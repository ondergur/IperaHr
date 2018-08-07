<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\EmployeeFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employee.index');
    }

    public function get_employee_data()
    {
        $employees = Employee::select(['id', 'firstName', 'lastName', 'email', 'phone', 'department_id']);
        return DataTables::of($employees)
            ->addColumn('actions', function ($employee) {
                return '<a href="'.route('employees.edit', $employee).'" class=" btn btn-xs btn-primary"> Edit</a>'.
                    Form::open([ 'method' => 'delete', 'route' => ['employees.destroy', $employee]]).
                    Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger']).
                    Form::close();
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Employee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeFormRequest $request)
    {
        $this->saveEmployee($request, new Employee);
        return redirect(route('employees.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return $this->form($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        $this->saveEmployee($request, $employee);
        return redirect(route('employees.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }

    private function form(Employee $employee){
        if ($employee->exists) {
            $route = ['employees.update', $employee->id];
            $method = 'put';
        } else {
            $route = ['employees.store'];
            $method = 'post';
        }

        $company_names = DB::table('companies')->pluck('name', 'id');
        return view('employee.form', compact('employee', 'route', 'method', 'company_names'));
    }

    private function saveEmployee(Request $request, Employee $employee)
    {
        $attributes = $request->all();
        $employee->fill($attributes);
        $employee->save();
        return $employee;
    }
}
