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
        <link href="{{ url('/css/custom.css') }}" rel="stylesheet"> <!-- This should be included  as last css --> 
    
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
<body id="app-layout">
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class='menu-wrap'>
                
            </div>
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    HZL
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
<!--                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>-->

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())                        
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @else
                        @if(Auth::user()->hasRole('admin'))
                        <li><a href="{{ url('/user') }}">Add New User</a></li>
                        @endif
                        @if(Auth::user()->hasRole(['owner', 'admin']))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Stay <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/room') }}">All Rooms</a></li>
                                <li><a href="{{ url('/guestroomallotment/create') }}">Room Allotment</a></li>
                                <li><a href="{{ url('/guestroomallotment') }}">Checked In Guests</a></li>
                                <li><a href="{{ url('/guestroomallotment/checkout') }}">Checked Out Guests</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Food <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/food') }}">Food</a></li>
                                <li><a href="{{ url('/foodserved') }}">Food Served</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/guesthouse') }}">Guest House</a></li>
                        <li><a href="{{ url('/guestroomallotment') }}">Guest Room Allotment</a></li>
                        <li><a href="{{ url('/guest_info') }}">Guest Info</a></li>
                        @endif
                        <li><a href="{{ url('/booking_request') }}">Book Guest House</a></li>            
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
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
       <div class="footer-wrap"></div>
        <div class="copyright-wrap">
          <div class="panel">
            <div class="content">
              <p> &copy; {{ date('Y')}} <a href="#">Hindustan Zinc</a> - All rights reserved | Design &amp; Developed by :<a href="#"> Avanik Jain @ 94601 95941 </a></p>

            </div>
          </div>
        </div>
      </div>
    </footer>  -->
</body>
</html>
