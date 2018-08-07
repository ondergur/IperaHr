<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyFormRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Form;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.index');
    }

    public function get_companies()
    {
        $companies = Company::select(['id', 'name', 'address', 'phone', 'email', 'website']);
        return DataTables::of($companies)
            ->addColumn('actions', function ($company) {
                return '<a href="'.route('companies.edit', $company).'" class=" btn btn-xs btn-primary"> Edit</a>'.
                    Form::open([ 'method' => 'delete', 'route' => ['companies.destroy', $company]]).
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
        return $this->form(new Company);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyFormRequest $request)
    {
        $this->saveCompany($request, new Company);
        return redirect(route('companies.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return $this->form($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyFormRequest $request, Company $company)
    {
        $this->saveCompany($request, $company);
        return redirect(route('companies.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }

    private function form(Company $company){
        if ($company->exists) {
            $route = ['companies.update', $company->id];
            $method = 'put';
        } else {
            $route = ['companies.store'];
            $method = 'post';
        }

        return view('company.form', compact('company', 'route', 'method'));
    }

    private function saveCompany(Request $request, Company $company)
    {
        $attributes = $request->all();
        $company->fill($attributes);
        $company->save();
        return $company;
    }

}
