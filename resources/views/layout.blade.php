<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- System title -->
    <title>D6 Invoice &trade;</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/invoice-icon.png') }}">

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: 'Nunito', sans-serif;
        }
        .error{
            color: #FF0000; 
        }
        input.error {
            border: 1px solid #FF0000;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-5">
        <div class="p-3 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="row justify-content-center">
                <div class="col-lg-12 margin-tb">
                    <div class="row">
                        <div class="d-flex justify-content-left align-items-center">
                            <img src="{{ asset('img/invoice-icon.png') }}" height="70" />
                            <h2 class="m-2">
                                D6 Invoice &trade;
                                <small class="d-block fs-6">Version 1.0.11</small>
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <hr />
                        </div>
                    </div>
                </div>
            </div>
        
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
