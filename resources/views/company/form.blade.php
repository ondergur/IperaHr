@extends('layouts.app')
@section('content')

    <div class="container">

        @if($company->exists)
            <h1 class="text-center">Edit {{$company->name}}</h1>
        @else
            <h1 class="text-center">Create New Company</h1>
        @endif

        {{Form::model($company, ['route' => $route, 'files' => true, 'method' => $method])}}

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
            {{Form::label('email', 'E-Mail Address: ', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-6">
                {{Form::text('email', null, ['class' => 'form-control']) }}
            </div>
            {{--Mail validation--}}
            @if($errors->has('email'))
                <div class="btn btn-danger col-sm-3">
                    {{$errors->first('email')}}
                </div>
            @endif
        </div>

        <div class="form-group row ">
            {{Form::label('phone', 'Telephone Number: ', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-6">
                {{Form::text('phone', null, ['class' => 'form-control'])}}
            </div>
        </div>


        <div class="form-group row ">
            {{Form::label('website', 'Web Site: ', ['class' => 'col-sm-3 col-form-label'])}}
            <div class="col-sm-6">
                {{Form::text('website', null, ['class' => 'form-control'])}}
            </div>
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
                {{Form::submit('Save Company', ['class' => 'btn btn-success'])}}
                {{Form::close() }}
            </div>
        </div>
    </div>

@endsection