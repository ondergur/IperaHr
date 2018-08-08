@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container">
        <a href="{{route('companies.index')}}"> <-- Back to Companies Index Page</a>
        <h1>Branches of {{$company->name}} Company</h1>

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
            $('#branches_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('branches.getbraches', $company->id) }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'actions', name: 'actions', orderable:false, searchable:false}
                ]
            });
        });
    </script>
@endpush