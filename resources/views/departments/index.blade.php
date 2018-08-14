@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container">
        <a href="{{route('branches.index', $branch->company)}}"> <-- Back to {{$branch->company->name}}
            's {{$branch->name}} Branch Index Page</a>
        <div class="row">
            <div class="col-md-7">
                <h1>Departments of {{$branch->company->name}}'s {{$branch->name}} Branch </h1>
            </div>
            <div class="col-md">
                <a href="{{route('departments.create', $branch)}}" class="btn btn-success float-right">Create New
                    Department for {{$branch->name}}</a>
            </div>
        </div>
        {{Form::open(['route' => ['departments.index', $branch], 'method' => 'GET', 'id' => 'departments_filter']) }}
        <div class="row justify-content-between">
            <div class="col-md">
                {{Form::text('name', request('name') , ['class' => 'form-control', 'placeholder' => 'Filter by Name'])}}
            </div>
            {{Form::submit('Filter', ['class' => 'btn btn-success my-2 my-sm-0'])}}
            {{Form::close()}}
        </div>
        <table id="departments_table" class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script>
        $(function () {
            $('#departments_table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('departments.getdepartments', $branch->id) }}',
                    data: function (d) {
                        d.name = $('input[name=name]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush