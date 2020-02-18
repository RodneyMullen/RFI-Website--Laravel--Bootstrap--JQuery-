
<?php
/* 
 * Master template to include the main headers and template links for content
 */

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
@section('seowords')
<meta name="keywords" content="Reiki, Reiki Federation of Ireland">
@show
@section('description')
<meta name="description" content="Invalid page for the Reiki Federation of Ireland">
@show
 <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('title')
        <title> Home</title>
        @show
       <!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
       -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="  {{ asset('css/jquery-ui.min.css')}}" rel="stylesheet">  
<!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<link href="{{asset('css/summernote-bs4.css')}}" rel="stylesheet" type="text/css">



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" />   

<link href="{{ asset('css/app-rfi.css') }}" rel="stylesheet">
<link href="{{ asset('css/rfi.css') }}" rel="stylesheet">
<!--<link href="{{ asset('css/bootstrap-social.css') }}" rel="stylesheet">-->


<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

 
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>

<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
  <script src="{{ asset('js/summernote-bs4.js')}}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="{{asset('js/summernote-image-attributes.js')}}"></script>
<script src="https://kit.fontawesome.com/8f21eddac5.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"></script>



<!-- HTML5 shim and Respond.js for IE8 support of HTML5
    elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via
    file:// -->
    <!--[if lt IE 9]>
      <script
src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js">
      </script>
      <script
src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


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
                                <a class="nav-link" id="member database_link" href="{{route('memberdashboard')}}"> Membership Database </a>
                            </li> 
                         <li class="nav-item">
                                <a class="nav-link" id="webpageadminlink" href="{{route('webpageadmin')}}"> Website Administration </a>
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
                    <!--<img src="storage/img/HeaderImage.png" class="img-fluid" alt="Responsive image">-->
                     <img src="{{ asset('storage/img/HeaderImage.png') }}" class="img-fluid" alt="Responsive image">
                        <nav class = "navbar navbar-expand-sm navbar-rfi navbar-dark">
                            <a class = "navbar-brand" href = "#">
				<img src="{{ asset('storage/img/RFI-logo-v3.png') }}" width="50" height="50">
                           </a>
                          
               
    
@include('webpage.header')
                </div>

        </div> 
        
<!--</div>
<//<div class="container">-->
	@section('content')
        <div class="jumbotron">
		<h1>Opps!! Something happened</h1>
                <p>The page you are searching for does not exist.  Please try again</p>
                
        </div>
        @show
        

  
        
 
@include('webpage.footer')
</div> 
<script>
  $(document).ready(function() {  
        $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
            }
            var $subMenu = $(this).next('.dropdown-menu');
            $subMenu.toggleClass('show');


            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $('.dropdown-submenu .show').removeClass('show');
            });// end of parents on


        return false;
        }); //end of click
        /**
        $.fn.datetimepicker.Constructor.Default = $.extend({},
            $.fn.datetimepicker.Constructor.Default,
            { icons:
                    { time: 'fas fa-clock',
                        date: 'fas fa-calendar',
                        up: 'fas fa-arrow-up',
                        down: 'fas fa-arrow-down',
                        previous: 'fas fa-arrow-circle-left',
                        next: 'fas fa-arrow-circle-right',
                        today: 'far fa-calendar-check-o',
                        clear: 'fas fa-trash',
                        close: 'far fa-times' } });
  }); // end of document ready*/
</script>
</body>
</html>                            