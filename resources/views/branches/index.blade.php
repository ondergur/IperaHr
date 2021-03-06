@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container">
        <a href="{{route('companies.index')}}"> <-- Back to Companies Index Page</a>
        <div class="row">
            <div class="col-md-8">
                <h1>Branches of {{$company->name}} Company</h1>
            </div>
            <div class="col-md">
                <a href="{{route('branches.create', $company)}}" class="btn btn-success float-right">Create New Branch
                    for {{$company->name}}</a>
            </div>
        </div>
        {{Form::open(['route' => ['branches.index', $company], 'method' => 'GET', 'id' => 'branches_filter']) }}
        <div class="row justify-content-between">
            <div class="col-md">
                {{Form::text('name', request('name') , ['class' => 'form-control', 'placeholder' => 'Filter by Name'])}}
            </div>
            <div class="col-md">
                {{Form::text('address', request('address') , ['class' => 'form-control', 'placeholder' => 'Filter by Address'])}}
            </div>
            {{Form::submit('Filter', ['class' => 'btn btn-success my-2 my-sm-0'])}}
            {{Form::close()}}
        </div>
        <table id="branches_table" class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
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
            var bTable = $('#branches_table').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('branches.getbraches', $company->id) }}',
                    data: function (d) {
                        d.name = $('input[name=name]').val();
                        d.address = $('input[name=address]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
        });

        $('#branches_filter').on('submit', function (e) {
            bTable.draw();
            e.preventDefault();
        });
    </script>
@endpush