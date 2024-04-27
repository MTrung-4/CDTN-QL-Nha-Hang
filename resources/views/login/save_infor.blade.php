<!-- form.blade.php -->
@extends('main')

@section('content')
    <style>
        h1 {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .account-container {
            margin: 100px auto 50px auto;
            display: flex;
            justify-content: center;
        }

        .container {
            display: flex;
            justify-content: space-between;
            width: 80%;
        }

        .column {
            width: 700px;
            padding: 0 20px;
            border-left: 1px solid black;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        /* .thumb {
                position: relative;
            }

            #upload {
                position: absolute;
                opacity: 0;
                width: 100%;
                height: 100%;
                cursor: pointer;
            }

            #image_show {
                width: 200px;
                height: 200px;
                border-radius: 50%;
                object-fit: cover;
                margin-left: auto;
                margin-right: auto;
                display: block;
                border: 2px solid #ddd;
            }

            #thumb {
                display: none;
            } */

        .upload-wrapper {
            text-align: center;
        }

        .upload-label {
            display: block;
            margin-top: 10px;
        }
    </style>
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    <div class="container account-container">
        <form action="/admin/accounts/profile/store" method="POST" enctype="multipart/form-data">
            @csrf
            <h1>Thông tin cá nhân</h1>
            <div class="container">
                <div class="column">
                    <label>Ảnh cá nhân:</label>
                    <div class="thumb">
                        <div class="m-2" id="image_show">
                            @if($user->thumb)
                                <img src="{{ $user->thumb }}" alt="Avatar" style="width:200px">
                            @endif
                        </div>
                        <div class="m-2">
                            <input type="file" class="form-control" id="upload" name="upload">
                            <input type="hidden" name="thumb" id="thumb" value="{{ $user->thumb ?? old('thumb')  }}">
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="form-group">
                        <label for="fullname">Họ và tên:</label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            value="{{ $user->fullname ?? old('fullname') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ $user->email ?? old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ $user->phone ?? old('phone')  }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ $user->address ?? old('address')  }}">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>

    <script>
        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
@endsection
