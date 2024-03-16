@extends('admin.users.main')

@include('admin.users.header')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Name</th>
                <th>Active</th>
                <th>Update</th>
                <th width="100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {!!  App\Helpers\Helper::menu($menus) !!}
        </tbody>
    </table>
@endsection