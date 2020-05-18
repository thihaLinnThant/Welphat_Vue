<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WelPhat</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/admin_style.css')}}" type="text/css">
    {{-- <link rel="stylesheet" href="{{ asset('/css/vue-style.css')}}" type="text/css"> --}}
    <script type="text/javascript">
        window.welphat_server_data = "{!! addslashes(json_encode($data)) !!}"
        window.csrf_token = "{{ csrf_token() }}"
    </script>
</head>
<body>
<div id="app"></div>
<script src="{{ asset('js/admin_app.js')}}"></script>
</body>
</html>