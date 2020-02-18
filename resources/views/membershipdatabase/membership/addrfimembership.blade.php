<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\CertificationController;
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

$Member_result = $Member_result;
$Membership_types = $Membership_types;
// retreive list of all member certificates frmo member number
$MemberCertificates = $MemberCertificates;

// the following returns strings, expired, due to expired or not expired
$is_reiki_level1_cert = $is_reiki_level1_cert;
$is_reiki_practitioner_cert = $is_reiki_practitioner_cert;
$is_anp_cert = $is_anp_cert;
$is_firsr_aid_cert = $is_firsr_aid_cert;

// returns a collection of insurance types which are due to expired or not expired
$insurance_cert_collection = $insurance_cert_collection;
// returns a collection of all the rfi membership based on member id
$Rfi_membership_results= $Rfi_membership_results;
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Add RFI Membership</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Add RFI Membership</h1>
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
        
           <form action="{{route('rfiMembershipPersist')}}" method="POST">
                    {{ csrf_field() }}         
         <div class="form-group row">
            <label for="membership_no" class="col-md-6 col-form-label text-md-right">Membership Number</label>

            <div class="col-md-6">
                <input id="membership_no" type="text" class="form-control" name="membership_no" value="{{ old('membership_no') ? old('membership_no'):$page}}" required>
            </div>
         </div>
        <div class="form-group row">
        <label for="member_first_name" class="col-md-6 col-form-label text-md-right">Member First Name</label>

            <div class="col-md-6">
                <input id="member_first_name" type="text" class="form-control" name="member_first_name" value="{{ old('member_first_name') ? old('member_first_name'):$Member_result->name}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="member_surname" class="col-md-6 col-form-label text-md-right">Member Surname</label>

            <div class="col-md-6">
                <input id="member_surname" type="text" class="form-control" name="member_surname" value="{{ old('member_surname') ? old('member_surname'):$Member_result->surname}}" required>
            </div>
        </div>
    
                   
        <div class="form-group row">
            <label for="membership_type" class="col-md-6 col-form-label text-md-right">Membership Type</label>                 
            <div class="col-md-6">
                <select class="mdb-select md-form cert_change" id="membership_type" name="membership_type">
                    <option value="" disabled selected>Choose Membership Type</option>
                    @foreach($Membership_types as $current_membership_type)
                                                          
                        <!-- check if the member renewal is present.  or old value is current cert. set as selects
                        otherwise create drop down list option
                        -->
                        
                        @if(strcmp(old('membership_type'),$current_membership_type->membership_type)==0)
                            <option value="{{$current_membership_type->membership_type}}" selected> {{$current_membership_type->membership_type}}</option>
                        @else
                            <option value="{{$current_membership_type->membership_type}}"> {{$current_membership_type->membership_type}}</option>
                        @endif  
                    @endforeach
                
                </select>
            </div>
        </div> 
    </p>
 </div>
<div class="row">
        <p>
            <div class="col-xs-8 form-group">
                <div class="row card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th> Reiki Level 1 </th>
                                    <th> Reiki Practitioner Module </th>
                                    <th> Introduction to Anatomy and Physiology </th>
                                    <th> First Aid</th>
                                    <th> Active Insurance Certifications </th>
                                    <th> CPD </th>
                        
                                </tr>     
                            </thead> 
                            
                            <tbody>
                          
                                <tr>
                            
                                    <td><!-- Reiki Level 1 -->
                                        <p>
                                            
                                            @switch($is_reiki_level1_cert)
                                                @case('Not Certified')
                                                    <span class="badge badge-danger"> Not Certified </span>
                                                @break
                                                @case('Certified')
                                                    <span class="badge badge-success"> Certified </span>
                                                @break
                                                 
                                            @endswitch
                                        </p>
                                    </td>
                                    <td><!-- Reiki Practitioner Module -->
                                        <p>
                                            @switch($is_reiki_practitioner_cert)
                                                @case('Not Certified')
                                                    <span class="badge badge-danger"> Not Certified </span>
                                                @break
                                                @case('Certified')
                                                    <span class="badge badge-success"> Certified </span>
                                                @break   
                                            @endswitch
                                        </p>
                                    </td>
                                    <td><!-- Introduction to Anatomy and Physiology -->
                                        <p>
                                            @switch($is_anp_cert)
                                                @case('Not Certified')
                                                    <span class="badge badge-danger"> Not Certified </span>
                                                @break
                                                @case('Certified')
                                                    <span class="badge badge-success"> Certified </span>
                                                @break
                                            @endswitch
                                        </p>
                                    </td>
                                    <td><!-- First Aid -->
                                        <p>
                                           
                                            @switch($is_firsr_aid_cert )
                                                @case('expired')
                                                    <span class="badge badge-danger"> Expired </span>
                                                @break
                                                @case('not expired')
                                                    <span class="badge badge-success"> Active </span>
                                                @break
                                                @case('due to expire')
                                                    <span class="badge badge-warning"> Due to Expire </span>
                                                @break    
                                            @endswitch
                                        </p>
                                    </td>
                                    <td><!-- Insurance Certifications -->
                                        
                                        <ul>
                                            <p>
                                             
                                            @if($insurance_cert_collection->isEmpty())
                                            <span class="badge badge-danger"> Expired </span></p>
                                            @else
                                                @foreach($insurance_cert_collection as $current_cert => $cert_status)
                                                    <li>
                                                        <p> {{$current_cert}}
                                                            @switch($cert_status )
                                                                @case('not expired')
                                                                    <span class="badge badge-success"> Active </span>
                                                                @break
                                                                @case('due to expire')
                                                                    <span class="badge badge-warning"> Due to Expire </span>
                                                                @break    
                                                            @endswitch
                                                        </p>
                                                    </li>
                                
                                                @endforeach
                                            @endif
                                        </ul>
                                    </td>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
         </p>
        
   </div>
 
   <div class="row offset-md-5">
     
       <p>
        <div class="form-group row">            
            <label for="notes" class="col-md-3 col-form-label text-md-right ">notes</label>
                <div class="col-md-9">
                    
                        <textarea class="form-control rounded-0" name="notes" id="notes" rows="2" >{{ old('notes')}}</textarea>
                    
                </div>    
                
           
        </div>
       </p>
    </div>
    <div class="row offset-md-4">
        <p>
        <div class="form-group row">
            <label for="start_date" class="col-md-4 col-form-label text-md-right">Start Date of Membership</label>
            <div class="col-md-8">  
                <div class="input-group date date-picker-select" id="start_date" data-target-input="nearest">
                    <input type="text" id="start_date"  name="start_date" class="form-control datetimepicker-input" data-target="#start_date"/>
                    <div class="input-group-append date-picker-select" data-target="#start_date" data-toggle="datetimepicker" value="{{old('start_date')}}">
                        <div class="input-group-text"><i class="fa fa-calendar"> Click Here</i></div>
                    </div>
                </div>
            </div>
        </div> 
                    
        <div class="form-group row">
            <label for="end_date" class="col-md-4 col-form-label text-md-right">End Date of Membership</label>
            <div class="col-md-8">  
                <div class="input-group date date-picker-select expire-date" id="end_date" data-target-input="nearest">
                    <input type="text" id="end_date"  name="end_date" class="form-control datetimepicker-input" data-target="#end_date" value="{{old('end_date')}}"/>
                    <div class="input-group-append date-picker-select" data-target="#end_date" data-toggle="datetimepicker"/>
                        <div class="input-group-text expire-date"><i class="fa fa-calendar"> Click Here</i></div>
                    </div>
                </div>
            </div>
        </div> 
    </p>
    </div>
    <div class="row offset-md-6">
        <p>
            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" id="create_rfi_membership_button" name="create_rfi_membership_button" value="CreateRFIMembership" > Save</button>
                </div>
                 
            </div>            
               
    </p>
 </div>   
<div class="row">
     <p>
      
        <div class="col-xs-12 offset-md-4">
            <div class="row card">
                <div class="card-header card-sucess">
            
                    <h4>RFI Membership</h4>
                </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> Delete </th>
                        <th> Membership type </th>
                        <th> Start Date </th>
                        <th> End Date</th>
                        <th> Notes </th>
                        
                    </tr>     
                </thead> 
                            
                <tbody>
                    @foreach($Rfi_membership_results as  $current_rfi_membership)
                    
                     <tr>
                            
                            <td>
                                <p>
                               <!-- Delete button -->
                                    <button type="submit" id="delete_rfi_membership_button" name="delete_rfi_membership_button"  class="delete-button" value="{{$current_rfi_membership->id}}" > Delete</button>
                                </p>
                            </td>
                            
                            <td><!-- Membership Type -->
                                <p>{{$current_rfi_membership->membership_type}}</p>
                            </td>
                            <td><!-- Start Date -->
                                <p>{{date("d-m-Y", strtotime($current_rfi_membership->start_of_membership))}}</p>
                            </td>
                            <td><!-- End date -->
                                <p>{{date("d-m-Y", strtotime($current_rfi_membership->end_of_membership))}}</p>
                                
                            </td>
                             <td><!-- Notes -->
                                <p>{{$current_rfi_membership->notes}}</p>
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
    
    // on load disable the provider list item
    $('.insurance_provider_new_change').prop('disabled',true);
    
    //checks if the insurance provider radio button as changed. 
    //if the radio for provider_list_option is selected then disable the control for the insurance_provider_new_change class. 
    //Enable other control for #provider_list this is the new name and desctiption for an insurance provider
    // if the radio for new_provider_option is selected then disable the control for the provider_list item.
    //Enable other control for insurance_provider_new_change class this is the insurance provider list
    // set hidden value #is_insurance_provider_list to yes or no depending on route required
       
     $('.insurance_provider_radio').change(function(){
         
         
         
         
        if($('#provider_list_option').is(':checked')){
            
            $('.insurance_provider_new_change').prop('disabled',true);
            $('.insurance_provider_list_change').prop('disabled',false);
            
            $('#is_insurance_provider_list').val("yes"); 
            
        }
        else{
            
             $('.insurance_provider_new_change').prop('disabled',false);
            $('.insurance_provider_list_change').prop('disabled',true);
            $('#is_insurance_provider_list').val("no"); 
        }
    }); // end of change of change function for insurance provider radio
       
 
    
    
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