<!DOCTYPE html>
<html lang="en">

<head>
    @include('head')
</head>

<body> <!--class="animsition" -->
    <style>
        .fe3173ed6eda3342aedf {
            max-width: 400px;
            max-height: 500px;

        }

        .fda3723591e0b38e7e52 {
            margin-bottom: 100px;
        }
    </style>


    <!-- Header -->
    @include('header')

    <!-- Cart -->
    @include('cart')

    @yield('content')

    @include('footer')
   
    {{-- <script src="https://sf-cdn.coze.com/obj/unpkg-va/flow-platform/chat-app-sdk/0.1.0-beta.3/libs/oversea/index.js"></script>
    <script>
        new CozeWebSDK.WebChatClient({
          config: {
            bot_id: '7367821828846813200',
          },
          componentProps: {
            title: 'Coze',
          },
        });
    </script> --}}
  

</body>

</html>
