<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//retrieves the list of members 
//$MemberList = MembershipController::displayMemberListing();


if(!isset($message)){
    $message ="";
}  
            
?>
@extends('layouts.masterpage')
  
@section('title')
<title>View Members</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>View Members</h1>
           <!-- @if(isset($message)) -->
                
           <!-- @endif-->
        </div>
    </div>  
</div>
@if(strcmp($message,"")!=0)
                    <p class="card text-black bg-warning mb-3 text-center">  {{$message }} </p> 
                @endif
 
<div class="row">
    <div class="col-xs-12">
        
        <nav class = "navbar navbar-expand-sm navbar-rfi navbar-dark">
            <button class = "navbar-toggler" type = "button" data-toggle = "collapse" 
                data-target = "#navbarNavDropdown" aria-controls = "navbarNavDropdown" 
                aria-expanded = "false" aria-label = "Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class = "collapse navbar-collapse" id = "navbarNavDropdown">
                <ul class = "navbar-nav">
                    <li class = "nav-item">
                        <a class = "nav-link" href = "{{ route('memberdashboard') }}">Member Dashboard
                            
                        </a>
                   </li>
                   <li class = "nav-item active">
                        <a class = "nav-link" href = "{{ route('membercreate') }}">Create new member
                            <span class = "sr-only">(current)</span>
                        </a>
                   </li>
                   <li class = "nav-item dropdown">
                        <a class = "nav-link dropdown-toggle" href = "" 
                            id = "navbarDropdownMenuLink" role = "button" data-toggle = "dropdown" 
                            aria-haspopup = "true" aria-expanded = "false">Extra Tables
                        </a>
                                        
                        <ul class = "dropdown-menu" aria-labelledby = "navbarDropdownMenuLink">
                            <li> 
                                <a class = "dropdown-item" href = "{{route('certtypes')}}">Certification Types
                                </a>
                            </li>
                            <li> 
                                <a class = "dropdown-item" href = "{{route('insurancetypes')}}">Insurance Types
                                </a>
                            </li>
                            <li> 
                                <a class = "dropdown-item" href = "{{route('insuranceproviders')}}">Insurance Providers
                                </a>
                            </li>
                            <li> 
                                <a class = "dropdown-item" href = "{{route('membershiptypes')}}">Membership Types
                                </a>
                            </li>
                            <li> 
                                <a class = "dropdown-item" href = "{{route('practitionerlistingpreference')}}">Practitioner Listing Preferences
                                </a>
                            </li>
                        </ul>
                   </li>
                </ul>
            </div>
        </nav>
    </div>     
</div>
      


    <div class="col-xs-12">
        <div class="row card">
            <div class="card-header card-sucess">
            
                <h4>Members </h4>
            </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> RFI Number </th>
                        <th>Name</th>
                        <th> RFI Status </th>
                        <th> Practitioner Insurance</th>
                        <th> First Aid </th>
                        <th> A&P </th>
                        <th> Webpage Listing </th>   
                        <th> CPD Status </th>  
                        <th>Practitioner Listing Notes</th>
                        <th>Member Notes</th>
                    </tr>     
                </thead> 
                <tbody>
                    @foreach($member_list_result as $member)
                        
                        <tr>
                            
                            <td><!--RFI Number -->
                                <p>{{$member->membership_no}}<br /> 
                                    <a href="{{ url('/memberedit', $member->membership_no) }}">Edit Member</a>
                                </p>
                            </td>
                            
                            <td><!--Name -->
                                <p>{{$member->name}} {{$member->surname}}</p>
                            </td>
                            <td><!--RFI Status -->
                                <p><span class="badge badge-success"> Active </span></p>
                                <a href="{{ url('/addrfimembership', $member->membership_no) }}">Add Membership</a>
                            </td>
                            <td><!--Insurance -->
                                <p><span class="badge badge-success"> Active </span></p>
                                <a href="{{ url('/addpractitionerinsurance', $member->membership_no) }}">Add Insurance</a>
                            </td>
                            <td><!--First Aid -->
                                <p><span class="badge badge-warning"> Active </span></p>
                                 <a href="{{ url('/addcertifications', $member->membership_no) }}">Add Certs</a>
                                
                            </td>
                            <td><!--A&P -->
                                <p><span class="badge badge-danger"> Inactive </span></p>
                                <a href="{{ url('/addcertifications', $member->membership_no) }}">Add Certs</a>
                            </td>
                            <td><!--Web Listing -->
                                <p>Not Requested </p>
                                <a href="{{ url('/practitionerlisting', $member->membership_no) }}">Edit Practitioner Listing </a>
                            </td>   
                            <td><!--CPD Status -->
                                <p>60 out of 100 points </p>
                            </td>  
                            <td><!--Practitioner notes -->
                                <p>Practitioner listing notes</p>
                            </td>
                            <td><!--Member notes -->
                                <p>{{$member->notes}}</p>
                            </td>
                            
                        </tr>
                    @endforeach
                    
                </tbody>
           </table>
                   
            


        
        </div>
    </div>
 </div
</div>
<script>
    $(document).ready(function() {
$('.mdb-select').materialSelect();
    </script>
@endsection