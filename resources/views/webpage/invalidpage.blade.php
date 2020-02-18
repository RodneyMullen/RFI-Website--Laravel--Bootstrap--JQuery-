
<?php
/* 
 * basic 404 file return
 */

?>
@extends('layouts.masterpage')

@section('title')
<title>'404' </title>
@endsection

@section('content')
<div class="jumbotron">
		<h1>Opps!! Something happened</h1>
                <p>The page you are searching for does not exist.  Please try again</p>
             @if(isset($message))
             <p> {{$message}} </p>
             @endif
                
        </div>

@endsection

