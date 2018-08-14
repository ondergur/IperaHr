@extends('layouts.app')
@section('content')

    <div class="container">

        @if($employee->exists)
            <h1 class="text-center">Edit {{$employee->firsName}} {{$employee->lastName}}</h1>
        @else
            <h1 class="text-center">Create New Department for {{$branch->company->name}}'s {{$branch->name}}</h1>
        @endif

        {{Form::model($department, ['route' => $route, 'files' => true, 'method' => $method])}}

        <div class="form-group row ">
            {{Form::label('name', 'Name: ', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-6">
                {{Form::text('name', null, ['class' => 'form-control']) }}
            </div>
            {{--Name validation--}}
            @if($errors->has('name'))
                <div class="btn btn-danger col-sm-3">
                    {{$errors->first('name')}}
                </div>
            @endif
        </div>

        <div class="form-group row">
            {{Form::label('branch_id', 'Branch: ', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-6">
                {{Form::select('branch_id', $branch_names, $branch->id ,['class' => 'form-control'])}}
            </div>
            {{--Branch_id validation--}}
            @if($errors->has('branch_id'))
                <div class="alert alert-danger col-sm-3">
                    {{$errors->first('branch_id')}}
                </div>
            @endif
        </div>

        <div class="form-group row ">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                {{Form::submit('Save Department', ['class' => 'btn btn-success'])}}
                {{Form::close() }}
            </div>
        </div>
    </div>

@endsection