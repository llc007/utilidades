<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Utilidades llc007</title>

    {{--Font Awesome--}}
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    {{--Scripts debe ir primero para q cargue el navbar--}}
    <script src="{{{ asset('js/calendario/jquery.min.js') }}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script src="{{{ asset('js/calendario/moment.min.js') }}}"></script>
    <script src="{{{ asset('js/calendario/fullcalendar.min.js') }}}"></script>
    <script src="{{{ asset('js/calendario/es.js') }}}"></script>
    <script src="{{{ asset('js/calendario/bootstrap-clockpicker.js') }}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">


    {{--Calendario--}}
    <link href={{{ asset('css/calendario/fullcalendar.min.css') }}} rel="stylesheet">
    <link href={{{ asset('css/calendario/bootstrap-clockpicker.css') }}} rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() {
            // nicEditors.allTextAreas()
            new nicEditor().panelInstance('area1');
        });
        //]]>
    </script>

</head>
<body>
{{--Se Incuye NAVBAR--}}
@include('layout.navbar')

{{--Se incluye content--}}
<div class="mt-5">
    @yield('content')
</div>


{{--Aqui se debe incluir footer @include--}}

</body>
</html>