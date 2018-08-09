<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Department;
use App\Http\Requests\DepartmentFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Form;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function index(Branch $branch)
    {
        return view('departments.index', compact('branch'));
    }

    public function get_departments(Request $request, $id)
    {
        $departments = Department::where('branch_id', '=', $id);
        return DataTables::of($departments)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $query->where('name', 'like', "%{$request->get('name')}%");
                }
            })
            ->addColumn('actions', function ($department) {
                return
                    Form::open([ 'method' => 'delete', 'route' => ['departments.destroy', $department]]).
                    '<a href="'.route('departments.edit', $department).'" class=" btn btn-xs btn-primary">Edit</a>'.
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
        return $this->form(new Department);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentFormRequest $request)
    {
        $this->saveBranch($request, new Department);
        return redirect(route('departments.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return $this->form($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentFormRequest $request, Department $department)
    {
        $this->saveDepartment($request, $department);
        return redirect(route('departments.index', $department->branch_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index', $department->branch_id);
    }

    private function form(Department $department)
    {
        if ($department->exists) {
            $route = ['departments.update', $department->id];
            $method = 'put';
        } else {
            $route = ['department.store'];
            $method = 'post';
        }

        $branch_names = DB::table('branches')->pluck('name', 'id');
        return view('departments.form', compact('department', 'route', 'method', 'branch_names'));
    }
}
