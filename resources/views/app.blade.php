<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <link href="{{ mix('/css/plugins.bundle.css') }}" rel="stylesheet" />
    <link href="{{ mix('/css/prismjs.bundle.css') }}" rel="stylesheet" />
    <link href="{{ mix('/css/style.bundle.css') }}" rel="stylesheet" />

    <script src="{{ mix('/js/app.js') }}" defer></script>

    <title>Asset Inventory</title>
    @inertiaHead
</head>
<body id="kt_body" style="background-image: url({{ url('assets/media/bg/450.jpg') }})">

    @inertia

    @include('components.script')
</body>
</html>
