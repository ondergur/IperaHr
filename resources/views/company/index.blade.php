@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Companies Index Page</h1>

        <table id="company_index_table" class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">E-mail</th>
            <th scope="col">Website</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
        </table>

    </div>
@endsection