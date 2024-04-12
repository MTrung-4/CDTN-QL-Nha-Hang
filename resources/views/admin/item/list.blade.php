@extends('admin.users.main')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th style="width: 50px">ID</th>
                <th>Tên Thực Đơn</th>
                <th>Giá Bán</th>
                <th>Hoạt Động</th>
                <th>Cập Nhật</th>
                <th style="width: 100px">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $key => $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{!! \App\Helpers\Helper::active($item->active) !!}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/items/edit/{{ $item->id }}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm"
                            onclick="removeRow({{ $item->id }}, '/admin/items/destroy')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        
    <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="{{ $items->previousPageUrl() }}">Previous</a></li>
    
            @for ($i = 1; $i <= $items->lastPage(); $i++)
                <li class="page-item{{ ($i == $items->currentPage()) ? ' active' : '' }}">
                    <a class="page-link" href="{{ $items->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
    
            <li class="page-item"><a class="page-link" href="{{ $items->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>
    <script>
        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
    
@endsection
