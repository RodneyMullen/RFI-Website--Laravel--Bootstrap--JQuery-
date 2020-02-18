<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\CertificationController;
use App\Http\Controllers\MembershipController;

// message used to transfer a message following a form post
if(!isset($message)){
    $message ="";
} 
else{
    $message = $message;
    
}


if(!isset($page)){
    $page ="";
    
    
    
}
else{
    $page = $page;
}
    
$CertTypeList = $CertTypeList;  // retrieves list of cert types
$Member_result = $Member_result;
$cert_expired_array=array();
foreach($CertTypeList as $current_cert_type)
{
    if($current_cert_type->expires==1)
    {
        array_push($cert_expired_array,$current_cert_type->certification );
        
    }        
            
}
// retreive list of all member certificates frmo member number
$MemberCertificates = $MemberCertificates;


?>
@extends('layouts.masterpage')
  
@section('title')
<title>Add Certification</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Add Certification</h1>
        </div>
    </div>  
</div>
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(strcmp($message,"")!=0)
<p class="card text-black bg-warning mb-3 text-center">  {{$message }} </p> 
 @endif
 
 <p id="message"></p>
 
 <div class="row">
    <div class="col-xs-12">
        <p>      
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
                        <a class = "nav-link" href = "{{ route('viewmembers') }}">View Members
                             <span class = "sr-only">(current)</span>
                        </a>
                   </li>
                </ul>
            </div>
        </nav>
        </p>

    </div>
</div>
 
 <div class="row offset-md-4">
    <p>
        
           <form action="{{route('certPersist')}}" method="POST">
                    {{ csrf_field() }}         
         <div class="form-group row">
            <label for="membership_no" class="col-md-4 col-form-label text-md-right">Membership Number</label>

            <div class="col-md-6">
                <input id="membership_no" type="text" class="form-control" name="membership_no" value="{{ old('membership_no') ? old('membership_no'):$page}}" required>
            </div>
         </div>
        <div class="form-group row">
        <label for="member_first_name" class="col-md-4 col-form-label text-md-right">Member First Name</label>

            <div class="col-md-6">
                <input id="member_first_name" type="text" class="form-control" name="member_first_name" value="{{ old('membership_no') ? old('membership_no'):$Member_result->name}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="member_surname" class="col-md-4 col-form-label text-md-right">Member Surname</label>

            <div class="col-md-6">
                <input id="member_surname" type="text" class="form-control" name="member_surname" value="{{ old('membership_no') ? old('membership_no'):$Member_result->surname}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="cert_type" class="col-md-4 col-form-label text-md-right">Cert Type</label>                 
            <div class="col-md-6">
                <select class="mdb-select md-form cert_change" id="cert_type" name="cert_type">
                    <option value="" disabled selected>Choose Cert Type</option>
                    @foreach($CertTypeList as $current_cert_type)
                                                          
                        <!-- check if the member renewal is present.  or old value is current cert. set as selects
                        otherwise create drop down list option
                        -->
                        
                        @if(strcmp(old('cert_type'),$current_cert_type->certification)==0)
                            <option value="{{$current_cert_type->certification}}" selected> {{$current_cert_type->certification}}</option>
                        @else
                            <option value="{{$current_cert_type->certification}}"> {{$current_cert_type->certification}}</option>
                        @endif  
                    @endforeach
                
                </select>
            </div>
                  
        </div>        
        
        <div class="form-group row">
            <label for="teacher" class="col-md-4 col-form-label text-md-right">Teacher</label>

            <div class="col-md-6">
                <input id="teacher" type="text" class="form-control" name="teacher" value="{{ old('teacher')}}" autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="no_days" class="col-md-4 col-form-label text-md-right">Number of Days of Training</label>

            <div class="col-md-6">
               <input id="no_days" type="text" class="form-control" name="no_days" value="{{ old('no_days')}}">
            </div>
        </div>
                           
        <div class="form-group row">
            <label for="date_of_cert" class="col-md-4 col-form-label text-md-right">Date of Cert</label>
            <div class="col-md-8">  
                <div class="input-group date date-picker-select" id="date_of_cert" data-target-input="nearest">
                    <input type="text" id="date_of_cert"  name="date_of_cert" class="form-control datetimepicker-input" data-target="#date_of_cert"/>
                    <div class="input-group-append date-picker-select" data-target="#date_of_cert" data-toggle="datetimepicker" value="{{old('date_of_cert')}}">
                        <div class="input-group-text"><i class="fa fa-calendar"> Click Here</i></div>
                    </div>
                </div>
            </div>
        </div> 
                    
        <div class="form-group row">
            <label for="date_expires" class="col-md-4 col-form-label text-md-right">Date Expires</label>
            <div class="col-md-8">  
                <div class="input-group date date-picker-select expire-date" id="date_expires" data-target-input="nearest">
                    <input type="text" id="date_expires"  name="date_expires" class="form-control datetimepicker-input expire-date" data-target="#date_expires" value="{{old('date_expires')}}"/>
                    <div class="input-group-append expire-date date-picker-select" data-target="#date_expires" data-toggle="datetimepicker"/>
                        <div class="input-group-text expire-date"><i class="fa fa-calendar"> Click Here</i></div>
                    </div>
                </div>
            </div>
        </div> 
         
        <div class="form-group row">            
            
             <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" id="create_cert_button" name="create_cert_button" value="CreateCert" > Save</button>
                </div>
                 <input type="hidden" name="is_date_expired" id="is_date_expired" value="no"/>
            </div>            
         </div>        
    </p>
 </div>   
<div class="row">
     <p>
      
        <div class="col-xs-12 offset-md-2">
            <div class="row card">
                <div class="card-header card-sucess">
            
                    <h4>Certicates</h4>
                </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> Delete </th>
                        <th> Certificate </th>
                        <th> Teacher </th>
                        <th> Training number days </th>
                        <th> Date of Cert </th>
                        <th>Date Expires</th>
                        
                        
                    </tr>     
                </thead> 
                            
                <tbody>
                    @foreach($MemberCertificates as  $current_member_cert)
                    
                     <tr>
                            
                            <td>
                                <p>
                               
                                    <button type="submit" id="delete_certificate_button" name="delete_certificate_button"  class="delete-button" value="{{$current_member_cert->id}}" > Delete</button>
                                </p>
                            </td>
                            
                            <td>
                                <p>{{$current_member_cert->certificate}}</p>
                            </td>
                            <td>
                                <p>{{$current_member_cert->teacher}}</p>
                            </td>
                            <td>
                                <p>{{$current_member_cert->number_of_days_of_training}}</p>
                            </td>
                             <td>
                                <p>{{date("d-m-Y", strtotime($current_member_cert->date_of_cert))}}</p>
                            </td>
                            <td>
                                @if(!$current_member_cert->date_expires)
                                    <p>  No Expiry </p> 
                                @else
                                    <p>{{date("d-m-Y", strtotime($current_member_cert->date_expires))}}</p>
                                @endif
                               
                            </td>
                            
                            
                        </tr>
                    @endforeach
                    
                </tbody>
                </table>
            </div>
        </div>
    </div>
        
        
        
        </form>
    </p>
</div>
<script>
 
 $(document).ready(function(){
    
     // initialise format for dates   
    $(function () {
        $('.date-picker-select').datetimepicker({
                 
            format: 'D/M/YYYY'
         });    // end of datetime picker function
     }); //end of annonymous function  
    
     
    
    // create array of cert types which expire
    
    var cert_type_array = {!! json_encode($cert_expired_array ) !!};
    
    
    checkCertType();   // check if date expires field is required from the start   
    
    // if the cert type menu changes, check if date expires field is required
    $('.cert_change').change(function(){
        
        checkCertType();
        
        
    }); //end of cert type change function
    
    function checkCertType(){
        
        
        // if the cert type is inclucded in the cert_expired_array, as in if it expires, grey out the box
        if(cert_type_array.includes($('#cert_type').children("option:selected").val()) ){
            
           
            $('.expire-date').prop('disabled',false);
            $('#is_date_expired').val('yes');
                
        }
        else{
            $('.expire-date').prop('disabled',true);
            $('#is_date_expired').val('no');
                
        }
            
        
    } // end of check cert type 
    
    
    $('.delete-button').click(function(){
    
         var answer = confirm("Are you sure you want to Delete this Certificate?");
        return answer;
        
         if(!answer){
                 return false;
         }
    })// end of click button annonymous function
    
    
    
     
 }); //  end of document ready
    
        
</script>        
        
 @endsection    