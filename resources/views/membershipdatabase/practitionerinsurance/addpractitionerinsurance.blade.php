<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MembershipController;




if(!isset($page)){
    $page ="";
    
    
    
}

if(!isset($message)){
    $message="";
    
}
$InsuranceTypeList = $InsuranceTypeList;  // retrieves list of insurance types
$Member_result = $Member_result;
$InsuranceProviders_list = $InsuranceProviders_list;  // retrieves list of insurance providers


$PractitionerInsurance_list = $PractitionerInsurance_list;  //retreives list of 
// practitioner insurances


?>
@extends('layouts.masterpage')
  
@section('title')
<title>Add Practitioner Insurance</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Add Practitioner Insurance</h1>
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
        
           <form action="{{route('pratitionerInsurancePersist')}}" method="POST">
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
                <input id="member_first_name" type="text" class="form-control" name="member_first_name" value="{{ old('member_first_name') ? old('member_first_name'):$Member_result->name}}" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="member_surname" class="col-md-4 col-form-label text-md-right">Member Surname</label>

            <div class="col-md-6">
                <input id="member_surname" type="text" class="form-control" name="member_surname" value="{{ old('member_surname') ? old('member_surname'):$Member_result->surname}}" required>
            </div>
        </div>
                    
                    
        <div class="form-group row">
            <label for="insurance_type" class="col-md-4 col-form-label text-md-right">Insurance Type</label>                 
            <div class="col-md-6">
                <select class="mdb-select md-form cert_change" id="insurance_type" name="insurance_type">
                    <option value="" disabled selected>Choose Insurance Type</option>
                    @foreach($InsuranceTypeList as $current_insurance_type)
                                                          
                        <!-- check if the member renewal is present.  or old value is current cert. set as selects
                        otherwise create drop down list option
                        -->
                        
                        @if(strcmp(old('insurance_type'),$current_insurance_type->insurance_type)==0)
                            <option value="{{$current_insurance_type->insurance_type}}" selected> {{$current_insurance_type->insurance_type}}</option>
                        @else
                            <option value="{{$current_insurance_type->insurance_type}}"> {{$current_insurance_type->insurance_type}}</option>
                        @endif  
                    @endforeach
                
                </select>
            </div>
                  
        </div>
                    
                    
         <div class="form-group row">
             <div class="col-md-6">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" class="insurance_provider_radio" name="provider_option" id="provider_list_option" autocomplete="off"> Insurance Provider List
                    </label>
                    <label class="btn btn-secondary active">
                        <input type="radio" class="insurance_provider_radio" name="provider_option" id="new_provider_option" autocomplete="off"> Create New Insurance Provider
                    </label>
                </div>
             </div>
        </div>
        
         <div class="form-group row">
                            
            <div class="col-md-6">
                <label for="provider_list" class="col-md-6 col-form-label text-md-right">Insurance Providers List</label> 
                <select class="mdb-select md-form insurance_provider_list_change" id="provider_list" name="provider_list">
                    <option value="" disabled selected>Choose Insurance Provider</option>
                    @foreach($InsuranceProviders_list as $current_insurance_provider)
                                                          
                        <!-- check if the member renewal is present.  or old value is current cert. set as selects
                        otherwise create drop down list option
                        -->
                        
                        @if(strcmp(old('provider_list'),$current_insurance_provider->insurance_provider_name)==0)
                            <option value="{{$current_insurance_provider->insurance_provider_name}}" selected> {{$current_insurance_provider->insurance_provider_name}}</option>
                        @else
                            <option value="{{$current_insurance_provider->insurance_provider_name}}"> {{$current_insurance_provider->insurance_provider_name}}</option>
                        @endif  
                    @endforeach
                
                </select>
            </div>
            <div class="col-md-6">
                <div class="row">
                    
                    <label for="insurance_provider_name" class="col-md-7 col-form-label text-md-right">New Insurance Provider</label>
                    <input id="insurance_provider_name" type="text" class="form-control insurance_provider_new_change" name="insurance_provider_name" value="{{ old('insurance_provider_name')}}">
                </div>
                <div class="row">
                    
                    <label for="new_provider_description" class="col-md-7 col-form-label text-md-right ">New Provider Description</label>
                    <textarea class="form-control rounded-0 insurance_provider_new_change" name="new_provider_description" id="new_provider_description" rows="2" >{{ old('new_provider_description')}}</textarea>
                </div>
                
                
            </div>
                
            
                  
        </div> 
        
           
        <div class="form-group row">
            <label for="start_date" class="col-md-4 col-form-label text-md-right">Start Date of Insurance</label>
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
            <label for="end_date" class="col-md-4 col-form-label text-md-right">End Date of Insurance</label>
            <div class="col-md-8">  
                <div class="input-group date date-picker-select expire-date" id="end_date" data-target-input="nearest">
                    <input type="text" id="end_date"  name="end_date" class="form-control datetimepicker-input" data-target="#end_date" value="{{old('end_date')}}"/>
                    <div class="input-group-append date-picker-select" data-target="#end_date" data-toggle="datetimepicker"/>
                        <div class="input-group-text expire-date"><i class="fa fa-calendar"> Click Here</i></div>
                    </div>
                </div>
            </div>
        </div> 
                    
                  
         
        <div class="form-group row">            
            
             <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" id="create_practitioner_insurance_button" name="create_practitioner_insurance_button" value="CreatePractitionerInsurance" > Save</button>
                </div>
                 <input type="hidden" name="is_insurance_provider_list" id="is_insurance_provider_list" value="yes"/>
            </div>            
         </div>        
    </p>
 </div>   
<div class="row">
     <p>
      
        <div class="col-xs-12 offset-md-2">
            <div class="row card">
                <div class="card-header card-sucess">
            
                    <h4>Practitioner Insurance</h4>
                </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> Delete </th>
                        <th> Practitioner Insurance type </th>
                        <th> Insurance Provider </th>
                        <th> Date of Cert </th>
                        <th> Date Expires</th>
                        
                        
                    </tr>     
                </thead> 
                            
                <tbody>
                    @foreach($PractitionerInsurance_list as  $current_practitioner_insurance)
                    
                     <tr>
                            
                            <td>
                                <p>
                               
                                    <button type="submit" id="delete_practitioner_insurance_button" name="delete_practitioner_insurance_button"  class="delete-button" value="{{$current_practitioner_insurance->id}}" > Delete</button>
                                </p>
                            </td>
                            
                            <td>
                                <p>{{$current_practitioner_insurance->insurance_type}}</p>
                            </td>
                            <td>
                                <p>{{$current_practitioner_insurance->insurance_provider_name}}</p>
                            </td>
                            <td>
                                <p>{{date("d-m-Y", strtotime($current_practitioner_insurance->start_date))}}</p>
                                
                            </td>
                             <td>
                                <p>{{date("d-m-Y", strtotime($current_practitioner_insurance->end_date))}}</p>
                            </td>
                                                    
                            
                        </tr>
                        <input type="hidden" id="ProviderInsuranceID" name="ProviderInsuranceID" value="{{$current_practitioner_insurance->id}}"/>
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