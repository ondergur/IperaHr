<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Company;
use App\Http\Requests\BranchFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Form;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        return view('branches.index', compact('company'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function get_branches(Request $request, $id)
    {
        $branches = Branch::where('company_id', '=', $id);
        return DataTables::of($branches)
            ->filter(function ($query) use ($request) {
                if ($request->filled('name')) {
                    $query->where('name', 'like', "%{$request->get('name')}%");
                }
                if ($request->filled('address')) {
                    $query->where('address', 'like', "%{$request->get('address')}%");
                }
            })
            ->addColumn('actions', function ($branch) {
                return
                    Form::open(['method' => 'delete', 'route' => ['branches.destroy', $branch]]) .
                    '<a href="' . route('branches.edit', $branch) . '" class=" btn btn-xs btn-primary">Edit</a>' .
                    Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger']) .
                    Form::close();
            })
            ->editColumn('name', function ($branch) {
                return
                    '<a href="' . route('departments.index', $branch) . '">' . $branch->name . '</a>';
            })
            ->rawColumns(['actions', 'name'])
            ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Company $company)
    {
        return $this->form(new Branch, $company);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Company $company
     * @param BranchFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Company $company, BranchFormRequest $request)
    {
        $this->saveBranch($request, new Branch);
        return redirect(route('branches.index', $company));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch $branch
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Branch $branch)
    {
        return $this->form($branch, $branch->company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BranchFormRequest $request
     * @param  \App\Branch $branch
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BranchFormRequest $request, Branch $branch)
    {
        $this->saveBranch($request, $branch);
        return redirect(route('branches.index', $branch->company));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch $branch
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index', $branch->company);
    }

    /**
     * @param Branch $branch
     * @param Company $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function form(Branch $branch, Company $company)
    {
        if ($branch->exists) {
            $route = ['branches.update', $branch];
            $method = 'put';
        } else {
            $route = ['branches.store', $company];
            $method = 'post';
        }

        return view('branches.form', compact('branch', 'route', 'method', 'company'));
    }

    /**
     * @param Request $request
     * @param Branch $branch
     * @return Branch
     */
    private function saveBranch(Request $request, Branch $branch)
    {
        $attributes = $request->all();
        $branch->fill($attributes);
        $branch->save();
        return $branch;
    }
}
