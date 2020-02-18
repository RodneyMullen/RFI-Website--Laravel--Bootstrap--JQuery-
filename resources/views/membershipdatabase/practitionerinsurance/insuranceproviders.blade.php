<?php

/* 
 * Blade view to list add or delete cert types.
 */



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InsuranceController;

$InsuranceProvider_list = $InsuranceProvider_list;  // retrieves list of insurance providers

if(!isset($message)){
    $message ="";
}  
             
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Edit Insurance Providers</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Insurance Providers</h1>
        </div>
    </div>  
</div>
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(strcmp($message,"")!=0)
<p class="card text-black bg-warning mb-3 text-center">  {{$message }} </p> 
 @endif

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
<form action="{{route('InsuranceProviderPersist')}}" method="POST">
                    {{ csrf_field() }}    

    <div class="form-group row">
        <label for="insurance_provider_name" class="col-md-6 col-form-label text-md-right">Insurance Provider Name </label>

        <div class="col-md-6">
            <input id="insurance_provider_name" type="text" class="form-control" name="insurance_provider_name" value="{{ old('insurance_provider_name') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="insurance_provider_description" class="col-md-6 col-form-label text-md-right ">New Provider Description</label>

        <div class="col-md-6">
             <textarea class="form-control rounded-0 insurance_provider_new_change" name="insurance_provider_description" id="insurance_provider_description" rows="2" >{{ old('insurance_provider_description')}}</textarea>
        </div>
    </div               
        
    <div class="form-group row">                
        
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" id="save_insurance_provider_button" name="save_insurance_provider_button" value="SaveCertType" > Save</button>
            </div>
        </div>  
    </div>

</div>

<div class="row">
   
      
    <div class="col-xs-12 offset-md-4">
        <div class="row card">
            <div class="card-header card-sucess">
            
                <h4>Insurance Providers </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> Insurance Provider Name </th>
                        <th> Insurance Provider Description </th>
                    </tr>     
                </thead> 
                            
                <tbody>
                    @foreach($InsuranceProvider_list as  $current_insurance_provider)
                    
                     <tr>
                            
                            <td>
                                <p>
                               
                                    <button type="submit" id="delete_insurance_provider_button" name="delete_insurance_provider_button"  class="delete-button" value="{{$current_insurance_provider->insurance_provider_name}}" > Delete</button>
                                </p>
                            </td>
                            
                            <td>
                                <p>{{$current_insurance_provider->insurance_provider_name}}</p>
                            </td>
                            <td>
                                <p>{{$current_insurance_provider->description}}</p>
                            </td>
                            
                            
                        </tr>
                        @endforeach
                    
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </p>

</div>
 </form>
<script>
 $(document).ready(function(){
  $('.delete-button').click(function(){
    
         var answer = confirm("Are you sure you want to Delete this insurance provider?");
        return answer;
        
         if(!answer){
                 return false;
             }
    })// end of click button annonymous function
    
 }); //end of document.ready         
        
    

</script>
 @endsection             