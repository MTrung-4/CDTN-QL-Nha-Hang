@extends('admin.users.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Tài Khoản</th>
                <th>Vai Trò</th>
                <th>Email</th>
                <th>Cập Nhật</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $key => $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->role }}</td>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/accounts/edit/{{ $account->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $account->id }}, '/admin/accounts/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $accounts->previousPageUrl() }}">Previous</a></li>

            @for ($i = 1; $i <= $accounts->lastPage(); $i++)
                <li class="page-item{{ $i == $accounts->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ $accounts->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            <li class="page-item"><a class="page-link" href="{{ $accounts->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>
    <script>
        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
@endsection
