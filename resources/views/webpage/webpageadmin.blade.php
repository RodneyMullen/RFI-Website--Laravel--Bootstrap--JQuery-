<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$WebpageList = $WebpageList; //list of webpages

  if(!isset($message)){
    $message ="";
}           
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
                
        </div>
    </div> 
   
</div>
 @if(strcmp($message,"")!=0)
                    <p class="card text-black bg-warning mb-3 text-center">  {{$message }} </p> 
                @endif
<div class="row">
    <div class="col-xs-12">
        <div class="wrapper">
            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="sidebar-nav">
                    <div class="list-group">
                       
                        <a href="{{ route('webpagecreate') }}" class="list-group-item">
                             Add Webpage 
                        </a>
                        
                    </div>
                </nav>
  
            </div>
        </div>
    </div>
</div>
      


    <div class="col-xs-12">
        <div class="row card">
            <div class="card-header card-sucess">
            
                <h4>Webpages </h4>
            </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> Edit </th>
                        <th> View </th>
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
                            <a href="{{ url('/webpageedit', $page->webpage_name) }}">Edit</a>
                        </td>
                        <td>
                            <a href="{{ url('/'.$page->webpage_name) }}">View</a>
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
                            {{
                                date("d-m-Y h:i", strtotime($page->created_at)) 
                            }}
                        </td>
                        <td>
                            {{
                                date("d-m-Y h:i", strtotime($page->updated_at)) 
                            }}
                            
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
           <table>
                   
            


        
        </div>
    </div>
 </div
</div>

@endsection