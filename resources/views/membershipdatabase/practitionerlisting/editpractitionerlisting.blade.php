<?php

/* 
 * Page to generate a form to create a webpage
 */
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\MembershipController;
use Carbon\Carbon;  // used for current date


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
$Member_result = $Member_result; // retrieves the next membership number value
$Listing_result = $Listing_result; // retrieves the next membership number value
$Preferences_result = $Preferences_result; // retrieves list of preferences avaialble


  

?>
@extends('layouts.masterpage')
  
@section('title')
<title>Edit Practitioner Listing  </title>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Edit Practitioner Listing </h1>
            
           <!-- @if(isset($message)) -->
                
           <!-- @endif-->
        </div>
    </div>  
</div>

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(strcmp($message,"")!=0)
<p class="card text-black bg-warning mb-3 text-center">  {{$message }} </p> 
 @endif
<p>

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
                        <a class = "nav-link" href = "{{ route('viewmembers') }}">View Members
                             <span class = "sr-only">(current)</span>
                        </a>
                   </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
 <form action="{{route('practitionerListingPersist')}}" method="POST">
                    {{ csrf_field() }}
    <div class="form-group row">
        <label for="membership_no" class="col-md-4 col-form-label text-md-right">Membership Number</label>

        <div class="col-md-6">
            <input id="membership_no" type="text" class="form-control" name="membership_no" value="{{ old('membership_no') ? old('membership_no'):$Member_result->membership_no}}" required autofocus>
        </div>
    </div>

    <div class="form-group row">
        <label for="member_first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

        <div class="col-md-6">
            <input id="member_first_name" type="text" class="form-control" name="member_first_name" value="{{ old('member_first_name')? old('member_first_name'): $Member_result->name }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="member_surname" class="col-md-4 col-form-label text-md-right">Surname</label>

        <div class="col-md-6">
            <input id="member_surname" type="text" class="form-control" name="member_surname" value="{{ old('member_surname') ? old('member_surname'):$Member_result->surname }}">
        </div>
    </div>
                    
                    
    <div class="form-group row">
        <label for="listing_name" class="col-md-4 col-form-label text-md-right">Listing Name</label>

        <div class="col-md-6">
            <input id="listing_name" type="text" class="form-control" name="listing_name" value="{{ old('listing_name') ? old('listing_name'): $Listing_result->listing_name}}">
        </div>
    </div>
                    
                    
   
    <!-- listing Preferences
    -->
    <div class="form-group row referee-form">
        <label for="listing_preference" class="col-md-4 col-form-label text-md-right">Listing Preference</label>                 
         <div class="col-md-6">
             <select class="mdb-select md-form" id='listing_preference' name='listing_preference'>
                <option value="">Choose a Listing Preference</option>
                @foreach($Preferences_result as $current_preference)
                    
                    @if(old('listing_preference'))
                        @if(strcmp(old('listing_preference'), $current_preference->listing_preference)==0)
                           <option value="{{$current_preference->listing_preference}}" selected>{{$current_preference->listing_preference}}</option> 
                           
                        @else
                           <option value="{{$current_preference->listing_preference}}">{{$current_preference->listing_preference}}</option>
                        @endif
                    @else
                        @if(strcmp($Listing_result->listing_preference, $current_preference->listing_preference)==0)
                           <option value="{{$current_preference->listing_preference}}" selected>{{$current_preference->listing_preference}}</option>
                        @else
                           <option value="{{$current_preference->listing_preference}}">{{$current_preference->listing_preference}}</option>
                       @endif
                       
                        
                    @endif
                @endforeach            
            </select>
         </div>
                  
    </div>    
    
    <div class="form-group row offset-md-3">
        <div class="col-md-6">
            <h4>
                Appear on Website
            </h4>      
            @if(old('appear_on_website'))
                @if(strcmp(old('appear_on_website'),"yes")==0)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website1" valu="yes" checked>
                        <label class="form-check-label" for="appear_on_website1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website2" valu="no">
                        <label class="form-check-label" for="appear_on_website2"> 
                            No
                        </label>
                    </div>
                @else
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website1" valu="yes">
                        <label class="form-check-label" for="appear_on_website1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website2" valu="no" checked>
                        <label class="form-check-label" for="appear_on_website2"> 
                            No
                        </label>
                    </div>
                @endif
            @elseif($Listing_result->appear_on_website)
                @if(strcmp($Listing_result->appear_on_website, "yes")==0)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website1" valu="yes" checked>
                        <label class="form-check-label" for="appear_on_website1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website2" valu="no">
                        <label class="form-check-label" for="appear_on_website2"> 
                            No
                        </label>
                    </div>
                @else
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website1" valu="yes">
                        <label class="form-check-label" for="appear_on_website1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website2" valu="no" checked>
                        <label class="form-check-label" for="appear_on_website2"> 
                            No
                        </label>
                    </div>
                @endif
            @else
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website1" valu="yes">
                    <label class="form-check-label" for="appear_on_website1"> 
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="appear_on_website" id="appear_on_website2" valu="no" checked>
                    <label class="form-check-label" for="appear_on_website2"> 
                        No
                    </label>
                </div>
            @endif
        </div>
    </div>
    
    <div class="form-group row">
        <label for="phone" class="col-md-4 col-form-label text-md-right">Phone Number</label>

        <div class="col-md-6">
            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') ? old('phone'): $Listing_result->phone }}">
        </div>
    </div>
        
    <div class="form-group row">
        <label for="mobile" class="col-md-4 col-form-label text-md-right">Mobile Number</label>

        <div class="col-md-6">
            <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') ? old('mobile'): $Listing_result->mobile }}">
        </div>
    </div>
        
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

        <div class="col-md-6">
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') ? old('email'): $Listing_result->email }}">
        </div>
    </div>
        
    <div class="form-group row">
        <label for="listing_website" class="col-md-4 col-form-label text-md-right">Listing Website</label>

        <div class="col-md-6">
            <input id="listing_website" type="text" class="form-control" name="listing_website" value="{{ old('listing_website') ? old('listing_website'): $Listing_result->listing_website }}">
        </div>
    </div>
           
    <div class="form-group row offset-md-3">
        <div class="col-md-6">
            <h4>
                Exempt from Website listing rules
            </h4>     
            @if(old('is_exempt'))
                @if(strcmp(old('is_exempt'),"yes")==0)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt1" valu="yes" checked>
                        <label class="form-check-label" for="is_exempt1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt2" valu="no">
                        <label class="form-check-label" for="is_exempt2"> 
                            No
                        </label>
                    </div>
                @else
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt1" valu="yes">
                        <label class="form-check-label" for="is_exempt1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt2" valu="no" checked>
                        <label class="form-check-label" for="is_exempt2"> 
                            No
                        </label>
                    </div>
                @endif
            @elseif($Listing_result->is_exempt)
                @if(strcmp($Listing_result->is_exempt, "yes")==0)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt1" valu="yes" checked>
                        <label class="form-check-label" for="is_exempt1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt2" valu="no">
                        <label class="form-check-label" for="is_exempt2"> 
                            No
                        </label>
                    </div>
                @else
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt1" valu="yes">
                        <label class="form-check-label" for="is_exempt1"> 
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt2" valu="no" checked>
                        <label class="form-check-label" for="is_exempt2"> 
                            No
                        </label>
                    </div>
                @endif
            @else
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt1" valu="yes">
                    <label class="form-check-label" for="is_exempt1"> 
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_exempt" id="is_exempt2" valu="no" checked>
                    <label class="form-check-label" for="is_exempt2"> 
                        No
                    </label>
                </div>  
            @endif
        </div>        
    </div>
    <div class="form-group row">
        <label for="listing_notes" class="col-md-4 col-form-label text-md-right">Notes</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="listing_notes" name="listing_notes" rows="10">{{ old('listing_notes')?old('listing_notes'):$Listing_result->listing_notes }}</textarea>
        </div>
    </div>

    <input type="hidden" id="practitioner_listing_id" name="practitioner_listing_id" value="{{$Listing_result->id}}">
     <div class="form-group row">
        <div class="col-md-2 offset-md-4">
            @if($Listing_result)
                <button type="submit" id="save_practitioner_listing" name="save_practitioner_listing" value="Save" > Save</button>
            @else
                <button type="submit" id="save_practitioner_listing" name="save_practitioner_listing" value="Create" > Save</button>
            @endif
        </div>
        <div class="col-md-2 offset-md-2">
            <button type="submit" class="delete_practitioner_listing" id="delete_practitioner_listing" name="delete_practitioner_listing" value="Delete" > Delete Listing</button>
        </div>
    
    </div>  
         
 </form>                        
</p>           
<script>
    $(document).ready(function(){
        
      $('.delete_practitioner_listing').click(function(){
       var answer = confirm("Are you sure you want to Delete this member?");
        return answer;
        
         if(!answer){
                 return false;
             }
        
     
         
        });//end of deleteBooutoon fucition
    }); // end of document ready
</script>

  

@endsection