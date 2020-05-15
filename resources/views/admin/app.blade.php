<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WelPhat</title>
    <link rel="stylesheet" href="{{ asset('/css/admin_style.css')}}" type="text/css">
    {{-- <link rel="stylesheet" href="{{ asset('/css/vue-style.css')}}" type="text/css"> --}}
    {{-- <script type="text/javascript">
        window.welphat_server_data = "{!! addslashes(json_encode($data)) !!}"
    </script> --}}
</head>
<body>
<div id="app"></div>
<script src="{{ asset('js/admin_app.js')}}"></script>
</body>
</html>