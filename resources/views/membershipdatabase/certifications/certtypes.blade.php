<?php

/* 
 * Blade view to list add or delete cert types.
 */



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CertificationController;

$CertTypeList = $CertTypeList; // retrieves list of cert types

if(!isset($message)){
    $message ="";
}  
             
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Edit Cert Types</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Cert Types</h1>
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
<form action="{{route('certTypePersist')}}" method="POST">
                    {{ csrf_field() }}    

    <div class="form-group row">
        <label for="cert_name" class="col-md-4 col-form-label text-md-right">Certificate </label>

        <div class="col-md-6">
            <input id="cert_name" type="text" class="form-control" name="cert_name" value="{{ old('cert_name') }}">
        </div>
    </div>
                 
    <div class="form-group row">
        <label class="col-md-4 col-form-label text-md-right" for="does_expire">Tick if Expires</label>
         <div class="col-md-6"> 
             @if(old('does_expire')==1)
                <input type="checkbox" class="form-check-input" id="does_expire" name="does_expire" value="1" checked>
             @elseif(old('does_expire')==0)
                <input type="checkbox" class="form-check-input" id="does_expire" name="does_expire" value="1">
             @else
                <input type="checkbox" class="form-check-input" id="does_expire" name="does_expire" value="1">
             @endif
         </div>
    </div>  
                    
    <div class="form-group row">
        <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" name="description" id="description" rows="2" value="{{ old('description') }}"></textarea>
        </div>
    </div>
    <div class="form-group row">                
        
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" id="save_cert_type_button" name="save_cert_type_button" value="SaveCertType" > Save</button>
            </div>
        </div>  
    </div>

</div>

<div class="row">
   
      
    <div class="col-xs-12 offset-md-4">
        <div class="row card">
            <div class="card-header card-sucess">
            
                <h4>Certicate Types </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> Delete </th>
                        <th> Certification Type </th>
                        <th>Does Expire</th>
                        <th>Description</th>
                        
                    </tr>     
                </thead> 
                            
                <tbody>
                    @foreach($CertTypeList as  $current_cert_type)
                    
                     <tr>
                            
                            <td>
                                <p>
                               
                                    <button type="submit" id="delete_cert_type_button" name="delete_cert_type_button"  class="delete-button" value="{{$current_cert_type->certification}}" > Delete</button>
                                </p>
                            </td>
                            
                            <td>
                                <p>{{$current_cert_type->certification}}</p>
                            </td>
                            <td>
                                @if($current_cert_type->expires==0)
                                    <p>No</p>
                                @else
                                    <p>Yes</p>  
                                @endif
                            </td>
                            <td>
                                <p>{{$current_cert_type->description}}</p>
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
    
         var answer = confirm("Are you sure you want to Delete this cert type?");
        return answer;
        
         if(!answer){
                 return false;
             }
    })// end of click button annonymous function
    
    }); //end of document.ready         
        
    

</script>
 @endsection             