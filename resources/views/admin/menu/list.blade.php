@extends('admin.users.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Tên Danh Mục</th>
                <th>Hoạt Động</th>
                <th>Cập Nhật</th>
                <th width="100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {!!  App\Helpers\Helper::menu($menus) !!}
        </tbody>
    </table>

    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $menus->previousPageUrl() }}">Previous</a></li>
    
            @for ($i = 1; $i <= $menus->lastPage(); $i++)
                <li class="page-item{{ ($i == $menus->currentPage()) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $menus->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
    
            <li class="page-item"><a class="page-link" href="{{ $menus->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>
    <script>
        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
    
@endsection