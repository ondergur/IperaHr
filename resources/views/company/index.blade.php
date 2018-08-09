@extends('layouts.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endpush

@section('content')
    <div class="container">
        <h1>Companies Index Page</h1>
        {{Form::open(['route' => 'companies.index', 'method' => 'GET', 'id' => 'company_filter']) }}
        <div class="row justify-content-between">
            <div class="col-md">
                {{Form::text('name', request('name') , ['class' => 'form-control', 'placeholder' => 'Filter Name'])}}
            </div>
            <div class="col-md">
                {{Form::text('address', request('address') , ['class' => 'form-control', 'placeholder' => 'Filter Address'])}}
            </div>
            <div class="col-md">
                {{Form::text('phone', request('phone') , ['class' => 'form-control', 'placeholder' => 'Filter Phone'])}}
            </div>
            <div class="col-md">
                {{Form::text('email', request('email') , ['class' => 'form-control', 'placeholder' => 'Filter E-mail'])}}
            </div>
            <div class="col-md">
                {{Form::text('website', request('website') , ['class' => 'form-control', 'placeholder' => 'Filter Website'])}}
            </div>
            {{Form::submit('Filter', ['class' => 'btn btn-success my-2 my-sm-0'])}}
            {{Form::close()}}
        </div>
        <table id="company_index_table" class="table">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
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

@push('scripts')
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script>
        $(function () {
            var cTable = $('#company_index_table').DataTable({

                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{{ route('company_get_data') }}',
                    data: function (d) {
                        d.name = $('input[name=name]').val();
                        d.address = $('input[name=address]').val();
                        d.phone = $('input[name=phone]').val();
                        d.email = $('input[name=email]').val();
                        d.website = $('input[name=website]').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'phone', name: 'phone'},
                    {data: 'email', name: 'email'},
                    {data: 'website', name: 'website'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
