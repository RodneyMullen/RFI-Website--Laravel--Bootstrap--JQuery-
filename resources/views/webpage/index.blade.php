<?php
/* 
 * basic 404 file return
 */





?>
@extends('layouts.masterpage')


@section('keywords')
<meta name="keywords" content="{{$Webpage->seo_words}}">
@endsection

@section('description')
<meta name="description" content="{{$Webpage->description}}">
@endsection

@section('title')
<title> {{$Webpage->webpage_name}} </title>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <H1> {{$Webpage->webpage_title}}</H1>
    </div>
</div>
<div class="row">
   <div class="col-xs-12"> 
       
     {!!$Webpage->content!!}
   </div>
</div>
@endsection


