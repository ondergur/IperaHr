@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container">
        <a href="{{route('branches.index', $department->branch->company)}}"> <-- Back to Departments Index Page of {{$department->branch->name}} Branch</a>
        <div class="row">
            <div class="col-md-7">
                <h1>Employees of {{$department->branch->name}} Branch </h1>
            </div>
            <div class="col-md">
                <a href="{{route('employees.create', $department)}}" class="btn btn-success float-right">Create New
                    Employee for {{$department->name}} Department</a>
            </div>
        </div>
        {{Form::open(['route' => ['employees.index', $department], 'method' => 'GET', 'id' => 'employee_filter']) }}
        <div class="row justify-content-between">
            <div class="col-md">
                {{Form::text('name', request('firstName') , ['class' => 'form-control', 'placeholder' => 'Filter by Name'])}}
            </div>
            <div class="col-md">
                {{Form::text('lastName', request('lastName') , ['class' => 'form-control', 'placeholder' => 'Filter by Last Name'])}}
            </div>
            <div class="col-md">
                {{Form::text('email', request('email') , ['class' => 'form-control', 'placeholder' => 'Filter by E-mail'])}}
            </div>
            <div class="col-md">
                {{Form::text('phone', request('phone') , ['class' => 'form-control', 'placeholder' => 'Filter by Phone'])}}
            </div>
            {{Form::submit('Filter', ['class' => 'btn btn-success my-2 my-sm-0'])}}
            {{Form::close()}}
        </div>
        <table id="employees_table" class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">E-Mail</th>
                <th scope="col">Phone</th>
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
            $('#employees_table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('employees.getemployees', $department->id) }}',
                    data: function (d) {
                        d.firstName = $('input[name=firstName]').val();
                        d.lastName = $('input[name=lastName]').val();
                        d.email = $('input[name=email]').val();
                        d.phone = $('input[name=phone]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'firstName', name: 'firstName'},
                    {data: 'lastName', name: 'lastName'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush