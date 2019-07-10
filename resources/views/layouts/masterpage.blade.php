
<?php
/* 
 * basic 404 file return
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Home')</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
    body{
    	padding-top: 70px;
		
    }
	.navbar-default
	{
	    background-color: #006C28;
	}
	
	.navbar-nav
	{
	   padding-left: 20px;
	}
	
	.navbar-default .navbar-nav > li > a {
 
		color: #FFFFFF;
 	}
 
	.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
 
		color: #e5dbdb;
 
	}
	
	.list-group a:focus, .list-group a:hover
	{
	  
	  	 background-color: #006C28;
	  color: #FFFFFF;
	}
	
	.sidebar-nav
	{
		padding-top: 20px;
		
	}	
	
	

</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
		<img src="storage/img/HeaderImage.png">
	</div>
</div>
    
@include('header')
<div class="container">
	@section('JumboTron')
        <div class="jumbotron">
		<h1>Opps!! Something happened</h1>
                <p>The page you are searching for does not exist.  Please try again</p>
                
        </div>
        @show
        <div class =" container"> 
            @yield(' content')
        </div>

  
        
</div>  
@include('footer')
</body>
</html>                            