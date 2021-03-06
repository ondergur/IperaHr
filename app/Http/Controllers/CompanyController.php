<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function get_companies(Request $request)
    {
        $companies = Company::select(['id', 'name', 'address', 'phone', 'email', 'website']);
        return DataTables::of($companies)
            ->filter(function ($query) use ($request) {
                if ($request->filled('name')) {
                    $query->where('name', 'like', "%{$request->get('name')}%");
                }
                if ($request->filled('address')) {
                    $query->where('address', 'like', "%{$request->get('address')}%");
                }
                if ($request->filled('phone')) {
                    $query->where('phone', 'like', "%{$request->get('phone')}%");
                }
                if ($request->filled('email')) {
                    $query->where('email', 'like', "%{$request->get('email')}%");
                }
                if ($request->filled('website')) {
                    $query->where('website', 'like', "%{$request->get('website')}%");
                }
            })
            ->addColumn('actions', function ($company) {
                return
                    Form::open(['method' => 'delete', 'route' => ['companies.destroy', $company]]) .
                    '<a href="' . route('companies.edit', $company) . '" class=" btn btn-xs btn-primary"> Edit</a>' .
                    Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-xs btn-danger']) .
                    Form::close();
            })
            ->editColumn('name', function ($company) {
                return
                    '<a href="' . route('branches.index', $company) . '">' . $company->name . '</a>';
            })
            ->rawColumns(['actions', 'name'])
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
     * @param CompanyFormRequest $request
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
     * @param  \App\Company $company
     * @return void
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return $this->form($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyFormRequest $request
     * @param  \App\Company $company
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
     * @param  \App\Company $company
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index');
    }

    private function form(Company $company)
    {
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
