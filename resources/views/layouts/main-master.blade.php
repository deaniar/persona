<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo-persona.svg') }}">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <!--[if lt IE 9]>
  <script src="{{ asset('assets/js/html5shiv.min.js') }}"></script>
  <script src="{{ asset('assets/js/respond.min.js') }}"></script>
 <![endif]-->

</head>

<body>
    <div class="main-wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')

        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script defer>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#province').on('change', function() {
                $.ajax({
                    url: '{{ route('address.city') }}',
                    method: 'POST',
                    data: {
                        id: $(this).val()
                    },
                    success: function(response) {
                        $('#city').empty();

                        $.each(response, function(id, name) {
                            $('#city').append(new Option(name, id))
                        })
                    }
                })
            });
            $("#city").on('change', function() {
                $.ajax({
                    url: '{{ route('address.district') }}',
                    method: 'POST',
                    data: {
                        id: $(this).val()
                    },
                    success: function(response) {
                        $('#district').empty();

                        $.each(response, function(id, name) {
                            $('#district').append(new Option(name, id))
                        })
                    }
                })
            });


        });

    </script>
    <script language="javascript">
        function changeImage() {
            document.getElementById("newavatar").src = document.getElementById("input-file").value;
        }

    </script>
    <script>
        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
                // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }

    </script>
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker3').datetimepicker({
                pickDate: false
            });
        });

    </script>
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
</body>

</html>
