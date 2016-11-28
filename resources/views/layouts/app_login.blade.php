<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HZL</title>

    <!-- Fonts -->
<!--    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>-->
    <!-- Styles -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    
    <link href="{{ url('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/custom.css') }}" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
            <!-- JavaScripts -->
    <script src="{{ url('/js/jquery.min.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/moment.min.js') }}"></script>
    <script src="{{ url('/js/webcam.min.js') }}"></script>
    <script src="{{ url('/js/angular.min.js') }}"></script>
    <script src="{{ url('/js/custom-angular.js') }}"></script>
    
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
     <script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script> 
    
    
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout" style="background:url({{ url('images/gb1.jpg') }});">
  <div class="header">
  <div class="logo">
    <table width="641" border="0">
      <tr>
        <td width="118"><img src="{{ url('images/logo-symnol.png') }}" /></td>
        <td width="513"><h1><span style="color:#FFFFFF;">Hindustan Zinc Limited</span></h1></td>
      </tr>
    </table>
    
  </div>
  <div class="social">
    <ul>
    </ul>
  </div>
</div>

    @yield('content')
    <div style="height:50px"></div>
<!--     <footer class="">
        <div class="primary-footer">
            <div class="footer-wrap" align="center"><p> &copy; {{ date('Y') }} <a href="#">Hindustan Zinc</a> - Login Panel. All rights reserved | Design & Developed by :<a href="#"> Avanik Jain @ 94601 95941 </a></p></div>
        </div>
    </footer>  -->
</body>
</html>
