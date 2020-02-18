<?php

/* 
 * Blade view to list add or delete practitioner listings
 */



$practitioner_listing_preference_results = $practitioner_listing_preference_results;  // retrieves list of practitioner listing preferences

if(!isset($message)){
    $message ="";
}  
             
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Add Practitioner Listing Preference</title>
@endsection
@section('content')

<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Add Practitioner Listing Preference</h1>
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
<form action="{{route('practitionerListingPreferencePersist')}}" method="POST">
                    {{ csrf_field() }}    

    <div class="form-group row">
        <label for="listing_preference" class="col-md-6 col-form-label text-md-right">Listing Preference</label>

        <div class="col-md-6">
            <input id="listing_preference" type="text" class="form-control" name="listing_preference" value="{{ old('listing_preference') }}">
        </div>
    </div>
                 
                      
    <div class="form-group row">
        <label for="description" class="col-md-6 col-form-label text-md-right">Description</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" name="description" id="description" rows="2" value="{{ old('description') }}"></textarea>
        </div>
    </div>
    <div class="form-group row offset-md-4">                
    
        
            <div class="col-md-6">
                <button type="submit" id="save_membership_type_button" name="save_practitioner_listing_preference_button" value="SavePractitionerListingPreference" > Save</button>
            </div>
         
    </div>

</div>

<div class="row">
   
      
    <div class="col-xs-12 offset-md-4">
        <div class="row card">
            <div class="card-header card-sucess">
            
                <h4>Practitioner Listing Preferences </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th> Delete </th>
                        <th> Practitioner Listing Preferences </th>
                        <th>Description</th>
                        
                    </tr>     
                </thead> 
                            
                <tbody>
                    @foreach($practitioner_listing_preference_results as  $current_preference)
                    
                     <tr>
                            
                            <td>
                                <p>
                               
                                    <button type="submit" id="delete_preference_button" name="delete_preference_button"  class="delete-button" value="{{$current_preference->id}}" > Delete</button>
                                    
                                </p>
                            </td>
                            
                            <td>
                                <p>{{$current_preference->listing_preference}}</p>
                            </td>
                            
                            <td>
                                <p>{{$current_preference->description}}</p>
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
    
         var answer = confirm("Are you sure you want to Delete this membership type?");
        return answer;
        
         if(!answer){
                 return false;
             }
    })// end of click button annonymous function
    
    }); //end of document.ready         
        
    

</script>
 @endsection             