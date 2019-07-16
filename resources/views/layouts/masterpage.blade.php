
<?php
/* 
 * basic 404 file return
 */
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
<title>@yield('title', 'Home')</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="{{ asset('css/app-rfi.css') }}" rel="stylesheet">
<link href="{{ asset('css/rfi.css') }}" rel="stylesheet">
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}" defer></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                   <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}" id="registerlink">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                         <li class="nav-item">
                                <a class="nav-link" id="webpageadminlink" href="{{route('webpageadmin')}}"> Administration </a>
                            </li>   
                        <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} 
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                               
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
                    <img src="storage/img/HeaderImage.png" class="img-fluid" alt="Responsive image">
                </div>

        </div> 
    
@include('header')
   
        
</div>
<div class="container">
	@section('content')
        <div class="jumbotron">
		<h1>Opps!! Something happened</h1>
                <p>The page you are searching for does not exist.  Please try again</p>
                
        </div>
        @show
        

  
        
</div>  
@include('footer')
</body>
</html>                            