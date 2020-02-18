<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Http\Controllers\WebpageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


             
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Member Dashboard</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Member Database Dashboard</h1>
           <!-- @if(isset($message)) -->
                <p class="well">{{$message }} </p>
           <!-- @endif-->
        </div>
    </div>  
</div>
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
                   <li class = "nav-item active">
                        <a class = "nav-link" href = "{{ route('viewmembers') }}">View Members 
                            <span class = "sr-only">(current)</span>
                        </a>
                   </li>
                   
                </ul>
            </div>
        </nav>
    </div>     
</div>
        
        
       
      


    <div class="col-xs-12">
        <div class="row card">
            <div class="card-header card-sucess">
            
                <h4>View RFI Exemptions</h4>
            </div>
           <!-- > <span class="well well-success">View RFI Exemptions</span> </h3>-->
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    
                    <thead>
                        <tr>
                            <th> RFI Number </th>
                            <th>Edit</th>
                            <th>Name</th>
                            <th> RFI Status </th>
                            <th> Cert/Membership </th>
                            <th> Due to expire </th>
                            <th>Practitioner Listing Notes</th>
                            <th>Member Notes</th>
                        </tr>    
                    </thead> 
                    <tbody>
                    
                        <tr>
                        
                            <td>
                                <p>RFI number here</p>
                            </td>
                            <td>
                                <a href="">Edit Member</a> 
                                <br />
                                <a href="">Edit RFI Membership</a>
                            </td>
                            <td>
                                <p>Name</p>
                            </td>
                            <td>
                                <p><span class="badge badge-success"> Active </span></p>
                            </td>
                            <td>
                                <p>RFI Membership</p>
                            </td>
                            <td>
                                <p>06/07/2019</p>
                            </td>
                            <td>
                                <p>Practitioner listing notes</p>
                            </td>
                            <td>
                                <p>Member notes</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
        
         <div class="row card">
            <div class="card-header card-sucess">
            
                <h4> View Certs / Membership due to expire</h4>
            </div>
           <!-- <h3> <span class="well well-success">View RFI Exemptions</span> </h3>-->
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    
                    <thead>
                        <tr>
                            <th> RFI Number </th>
                            <th>Edit</th>
                            <th>Name</th>
                            <th> RFI Status </th>
                            <th> Cert/Membership </th>
                            <th> Due to expire </th>
                            <th>Practitioner Listing Notes</th>
                            <th>Member Notes</th>
                        </tr>    
                    </thead> 
                    <tbody>
                    
                        <tr>
                        
                            <td>
                                <p>RFI number here</p>
                            </td>
                            <td>
                                <a href="">Edit Member</a> 
                                <br />
                                <a href="">Edit RFI Membership</a>
                            </td>
                            <td>
                                <p>Name</p>
                            </td>
                            <td>
                                <p><span class="badge badge-success"> Active </span></p>
                            </td>
                            <td>
                                <p>RFI Membership</p>
                            
                            <td>
                                <p><span class="badge badge-warning">06/07/2019</span></p>
                            </td>
                            <td>
                                <p>Practitioner listing notes</p>
                            </td>
                            <td>
                                <p>Member notes</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
       
        <div class="row card">
            <div class="card-header card-sucess">
            
                <h4> View Certs / Membership Expired</h4>
            </div>
           <!-- <h3> <span class="well well-success">View RFI Exemptions</span> </h3>-->
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    
                    <thead>
                        <tr>
                            <th> RFI Number </th>
                            <th>Edit</th>
                            <th>Name</th>
                            <th> RFI Status </th>
                            <th> Cert/Membership </th>
                            <th> Expired </th>
                            <th>Practitioner Listing Notes</th>
                            <th>Member Notes</th>
                        </tr>    
                    </thead> 
                    <tbody>
                    
                        <tr>
                        
                            <td>
                                <p>RFI number here</p>
                            </td>
                            <td>
                                <a href="">Edit Member</a> 
                                <br />
                                <a href="">Edit RFI Membership</a>
                            </td>
                            <td>
                                <p>Name</p>
                            </td>
                            <td>
                                <p><span class="badge badge-success"> Active </span></p>
                            </td>
                            <td>
                                <p>RFI Membership</p>
                            </td>
                            <td>
                                <p><span class="badge badge-danger">05/03/2019</span></p>
                            </td>
                            <td>
                                <p>Practitioner listing notes</p>
                            </td>
                            <td>
                                <p>Member notes</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            
    </div>
    
@endsection