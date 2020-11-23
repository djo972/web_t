@extends('bo.layouts.index')

@section('title')
    @lang('messages.title.users')
@endsection

@section('block_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css">
    <style>
        .list-inline.list_button {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="breadcrumb-holder">
                <h1 class="main-title">@lang('messages.title.users')</h1>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-end">
                <button id="addOne" class="btn btn-primary mb-3 mr-2" type="button" data-toggle="modal" data-target="#addUser">
                    @lang('messages.title_add_user')
                    <i class="fa fa-plus"></i>
                </button>
                <button id="addMore" class="btn btn-primary mb-3 mr-2" type="button" data-toggle="modal" data-target="#addUser">
                    @lang('messages.title_add_users')
                    <i class="fa fa-plus"></i>
                </button>
                <button id="addXls" class="btn btn-primary mb-3 mr-2" type="button" data-toggle="modal" data-target="#addUser">
                    @lang('messages.title_add_xls')
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table id="table_id" class="display">
                                <thead>
                                    <tr>
                                        <th>Login</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('bo.user.add_modal')
    @include('bo.user.delete_modal')
@endsection

@section('block_js')
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
        var users = '{!! $users !!}';
        var userURL = "{{ url('/bo/user') }}";
        var usersURL = "{{ url('/bo/users') }}";
    </script>
    <script type="text/javascript" src="{{ asset('/js/user.js') }}"></script>
@endsection
