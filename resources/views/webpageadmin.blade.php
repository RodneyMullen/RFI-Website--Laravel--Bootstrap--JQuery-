<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Http\Controllers\WebpageController;



$WebpageList = WebpageController::displayWebpageListing();

?>
@extends('layouts.masterpage')
  
@section('title')
<title>Web Administration</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Website Administration</h1>
           <!-- @if(isset($message)) -->
                <p class="well">{{$message }} </p>
           <!-- @endif-->
        </div>
    </div>  
</div>
<div class="row">
    <div class="col-xs-2">
        <div class="wrapper">
            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <div class="list-group">
                       
                        <a href="{{ route('webpagecreate') }}" class="list-group-item">
                             Add Webpage 
                        </a>
                        <a href="#" class="list-group-item"> 
                             Edit Webpage
                        </a>
                        <a href="#" class="list-group-item">
                             Edit Header
                        </a>
                        <a href="#" class="list-group-item">
                            Edit Footer
                        </a>
                    </div>
                </nav>
  
            </div>
        </div>
    </div>

      


    <div class="col-xs-10">
        <p>
            <table class="table table-bordered table-striped table-hover table-condensed">
                <caption> Webpages </caption>
                <thead>
                    <tr>
                        <th> Action </th>
                        <th>Webpage Name</th>
                        <th> Status </th>
                        <th>Parent</th>
                        <th>Date Created</th>
                        <th> Date Edited</th>
                    </tr>    
                </thead> 
                <tbody>
                    @foreach($WebpageList as $page)
                    <tr>
                        <td>
                            <a href="{{ route('webpageedit') }}" Edit </a>
                        </td>
                        
                        <td>
                            {{$page->webpage_name}}
                        </td>
                        <td>
                            @if($page->status==1)
                                Published
                            @else
                                Draft
                            @endif
                        </td>
                        <td>
                            {{$page->parent}}
                        </td>
                        <td>
                            {{$page->created_at}}
                        </td>
                        <td>
                            {{$page->updated_at}}
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
           <table>
              
            


        </p>
        
    </div>
 </div>

@endsection