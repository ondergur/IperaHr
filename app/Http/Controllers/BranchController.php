<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        $this->saveBranch($request, new Branch);
        return redirect(route('companies.index'));
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
     *
     * @return void
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Branch $branch
     *
     * @return void
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch $branch
     *
     * @return void
     */
    public function destroy(Branch $branch)
    {
        //
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
