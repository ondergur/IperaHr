<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Form;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Department $department
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    {
        return view('employees.index', compact('department'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function get_employees(Request $request, $id)
    {
        $employees = Employee::where('department_id', '=', $id);
        return DataTables::of($employees)
            ->filter(function ($query) use ($request) {
                if ($request->filled('firstName')) {
                    $query->filled('firstName', 'like', "%{$request->get('firstName')}%");
                }
                if ($request->filled('lastName')) {
                    $query->filled('lastName', 'like', "%{$request->get('lastName')}%");
                }
                if ($request->filled('email')) {
                    $query->filled('email', 'like', "%{$request->get('email')}%");
                }
                if ($request->filled('phone')) {
                    $query->filled('phone', 'like', "%{$request->get('phone')}%");
                }
            })
            ->addColumn('actions', function ($employee) {
                return
                    Form::open(['method' => 'delete', 'route' => ['employees.destroy', $employee]]) .
                    '<a href="' . route('employees.edit', $employee) . '" class=" btn btn-xs btn-primary">Edit</a>' .
                    Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger']) .
                    Form::close();
            })
            ->editColumn('name', function ($employee) {
                return
                    '<a href="' . route('employees.edit', $employee) . '">' . $employee->name . '</a>';
            })
            ->rawColumns(['actions', 'name'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function create(Branch $branch)
    {
        return $this->form(new Employee, $branch);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Branch $branch
     * @param EmployeeFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Branch $branch, EmployeeFormRequest $request)
    {
        $this->saveEmployee($request, new Employee);
        return redirect(route('employees.index', $branch));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return $this->form($employee, $employee->branch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeFormRequest $request
     * @param  \App\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeFormRequest $request, Employee $employee)
    {
        $this->saveEmployee($request, $employee);
        return redirect(route('employees.index', $employee->branch));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee $employee
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index', $employee->branch);
    }

    private function form(Employee $employee, Department $department)
    {
        if ($employee->exists) {
            $route = ['employees.update', $employee];
            $method = 'put';
        } else {
            $route = ['employees.store', $department];
            $method = 'post';
        }

        $department_names = DB::table('departments')->pluck('name', 'id');
        return view('employees.form', compact('employee', 'route', 'method', 'department_names', 'department'));
    }
}
