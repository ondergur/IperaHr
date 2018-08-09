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

    public function get_branches(Request $request, $id)
    {
        $branches = Branch::where('company_id', '=', $id);
        return DataTables::of($branches)
            ->filter(function ($query) use ($request) {
                if ($request->has('name')) {
                    $query->where('name', 'like', "%{$request->get('name')}%");
                }
                if ($request->has('address')) {
                    $query->where('address', 'like', "%{$request->get('address')}%");
                }
            })
            ->addColumn('actions', function ($branch) {
                return
                    Form::open([ 'method' => 'delete', 'route' => ['branches.destroy', $branch]]).
                    '<a href="'.route('branches.edit', $branch).'" class=" btn btn-xs btn-primary">Edit</a>'.
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
        return $this->form(new Branch);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchFormRequest $request)
    {
        $this->saveBranch($request, new Branch);
        return redirect(route('branches.index'));
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        return $this->form($branch);
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
        return redirect(route('branches.index', $branch->company_id));
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
        return redirect()->route('branches.index', $branch->company_id);
    }

    private function form(Branch $branch)
    {
        if ($branch->exists) {
            $route = ['branches.update', $branch->id];
            $method = 'put';
        } else {
            $route = ['branches.store'];
            $method = 'post';
        }

        $company_names = DB::table('companies')->pluck('name', 'id');
        return view('branches.form', compact('branch', 'route', 'method', 'company_names'));
    }

    private function saveBranch(Request $request, Branch $branch)
    {
        $attributes = $request->all();
        $branch->fill($attributes);
        $branch->save();
        return $branch;
    }
}
