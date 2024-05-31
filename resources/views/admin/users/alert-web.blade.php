<style>
    .alert {
        position: fixed;
        bottom: 0;
        right: 0;
        width: 300px;
        margin: 120px 20px 20px 20px;
        z-index: 9999; /* Đặt giá trị z-index cao để đảm bảo thông báo nổi lên trên */
    }

    .alert.alert-danger {
        text-align: center;
        font-weight: bold;
    }

    .alert.alert-success {
        text-align: center;
        font-weight: bold;
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<script>
    // Kiểm tra nếu tồn tại thông báo thành công thì thực hiện ẩn sau 3 giây
    @if (Session::has('success'))
        setTimeout(() => {
            document.querySelector('.alert-success').style.display = 'none';
        }, 10000); // 10 giây
    @endif
</script>
