@extends('layouts.app')
@section('content')

    <div class="container">
        <a href="{{route('branches.index', $company)}}"> <-- Back to Branches of {{$company->name}} Company</a>
        @if($branch->exists)
            <h1 class="text-center">Edit {{$branch->company->name}}'s {{$branch->name}} Branch</h1>
        @else
            <h1 class="text-center">Create New Branch for {{$company->name}}</h1>
        @endif

        {{Form::model($branch, ['route' => $route, 'files' => true, 'method' => $method])}}

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

        <div class="form-group row ">
            {{Form::label('address', 'Address: ', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-6">
                {{Form::textarea('address', null, ['class' => 'form-control'])}}
            </div>
            {{--Address validation--}}
            @if($errors->has('address'))
                <div class="alert alert-danger col-sm-3">
                    {{$errors->first('address')}}
                </div>
            @endif
        </div>

        <div class="form-group row ">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                {{Form::submit('Save Branch', ['class' => 'btn btn-success'])}}
                {{Form::close() }}
            </div>
        </div>
    </div>

@endsection