@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Branches of {{$company->name}} Company</h1>
        <ul>
            @foreach($company->branches as $branch)
                <li>{{$branch->name}}</li>
            @endforeach
        </ul>
    </div>
@endsection