 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>{{ $title }}</title>

 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
 <!-- Font Awesome -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
 <!-- icheck bootstrap -->
 <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
 <!-- Theme style -->
 <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
 <link rel="stylesheet" href="/template/admin/dist/css/new.css">

 <!-- Ionicons -->
 <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

 <meta name="csrf-token" content="{{ csrf_token() }}">

 @yield('header')

 <style>
     .hidden {
         display: none;
     }
 </style>
