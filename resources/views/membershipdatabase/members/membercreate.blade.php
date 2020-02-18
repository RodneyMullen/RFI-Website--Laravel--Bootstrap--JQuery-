<?php

/* 
 * Page to generate a form to create a webpage
 */
use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Log;

// assign from passed variables
$county_list_array= $county_list_array;
$gender_array= $gender_array;
$profile_array = $profile_array;
$default_country = $default_country;
Log::notice("In create view");
if(!isset($message)){
    $message ="";
}
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Create new Member </title>
@endsection
@section('content')
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
   
 <form action="{{route('memberPersist')}}" method="POST">
                    {{ csrf_field() }}
    <div class="form-group row">
        <label for="membership_no" class="col-md-4 col-form-label text-md-right">Membership Number</label>

        <div class="col-md-6">
            <input id="membership_no" type="text" class="form-control" name="membership_no" value="{{ old('membership_no') ? old('membership_no'):$max_value}}" required autofocus>
        </div>
    </div>

    <div class="form-group row">
        <label for="member_first_name" class="col-md-4 col-form-label text-md-right">First Name</label>

        <div class="col-md-6">
            <input id="member_first_name" type="text" class="form-control" name="member_first_name" value="{{ old('member_first_name') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="member_surname" class="col-md-4 col-form-label text-md-right">Surname</label>

        <div class="col-md-6">
            <input id="member_surname" type="text" class="form-control" name="member_surname" value="{{ old('member_surname') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="address_line_one" class="col-md-4 col-form-label text-md-right">Address Line one</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" name="address_line_one" id="address_line_one" rows="2" value="{{ old('address_line_one') }}"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="address_line_two" class="col-md-4 col-form-label text-md-right">Address Line two</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="address_line_two" name="address_line_two" rows="2" value="{{ old('address_line_two') }}"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="address_line_three" class="col-md-4 col-form-label text-md-right">Address Line Three</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="address_line_three" name="address_line_three" rows="2" value="{{ old('address_line_three') }}"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="county" class="col-md-4 col-form-label text-md-right">County</label>                 
         <div class="col-md-6">
                      
             <select class="mdb-select md-form" id="county" name="county">
                <option value="" disabled selected>Choose County</option>
                 @foreach($county_list_array as $current_county)
                    <!-- check if the selected value is the same as the old value, if it is assign 
                            the selected property
                        -->
                        
                        @if(strcmp(old('county'),$current_county)==0)
                            <option value="{{$current_county}}" selected> {{$current_county}}</option>
                        @else
                            <option value="{{$current_county}}"> {{$current_county}}</option>
                        @endif
                    
                @endforeach
                
            </select>
         </div>
                  
    </div>                
                    
    
                    
    <div class="form-group row">
        <label for="postcode" class="col-md-4 col-form-label text-md-right">Postcode</label>

        <div class="col-md-6">
            <input id="postcode" type="text" class="form-control" name="postcode" value="{{ old('postcode') }}">
        </div>
    </div>
     <div class="form-group row">
        <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

        <div class="col-md-6">
            <input id="country" type="text" class="form-control" name="country" value="{{ old('country') ? old('country'):$default_country}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

        <div class="col-md-6">
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="mobile_number" class="col-md-4 col-form-label text-md-right">Mobile Number</label>

        <div class="col-md-6">
            <input id="mobile_number" type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') }}">
        </div>
    </div>               
    <div class="form-group row">
        <label for="home_number" class="col-md-4 col-form-label text-md-right">Home Number</label>

        <div class="col-md-6">
            <input id="home_number" type="text" class="form-control" name="home_number" value="{{ old('home_number') }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="work_number" class="col-md-4 col-form-label text-md-right">Work Number</label>

        <div class="col-md-6">
            <input id="work_number" type="text" class="form-control" name="work_number" value="{{ old('work_number') }}">
        </div>
    </div> 
    <div class="form-group row">
        <label for="occupation" class="col-md-4 col-form-label text-md-right">Occupation</label>

        <div class="col-md-6">
            <input id="occupation" type="text" class="form-control" name="occupation" value="{{ old('occupation') }}">
        </div>
    </div> 
    <div class="form-group row">
        <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>                 
         <div class="col-md-6">
             <select class="mdb-select md-form" id="gender" name="gender">
                <option value="" disabled selected>Choose your option</option>
                @foreach($gender_array as $current_gender)
                    <!-- check if the selected value is the same as the old value, if it is assign 
                            the selected property
                        -->
                        @if(strcmp(old('gender'),$current_gender)==0)
                            <option value="{{$current_gender}}" selected> {{$current_gender}}</option>
                        @else
                            <option value="{{$current_gender}}"> {{$current_gender}}</option>
                        @endif
                    
                @endforeach
  
            </select>
         </div>
        
   
            
                  
    </div>           
    <div class="form-group row">
        <label for="skills" class="col-md-4 col-form-label text-md-right">Skills</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="skills" name="skills" rows="5" value="{{ old('skills') }}"></textarea>
        </div>
    </div>               
    <div class="form-group row">
        <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Date of Birth</label>
        <div class="col-md-6">  
            <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                <input type="text" id="date_of_birth"  name="date_of_birth" class="form-control datetimepicker-input" data-target="#date_of_birth"/>
                <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker" value="{{old('date_of_birth')}}">
                        <div class="input-group-text"><i class="fa fa-calendar"> Click Here</i></div>
                </div>
            </div>
        </div>
     </div>   
      
                    
    <div class="form-group row">
        <label for="profile" class="col-md-4 col-form-label text-md-right">Profile</label>                 
         <div class="col-md-6">
             <select class="mdb-select md-form" id="profile" name="profile">
                <option value="" disabled selected>Choose Profile</option>
                 @foreach($profile_array as $current_profile)
                    <!-- check if the selected value is the same as the old value, if it is assign 
                            the selected property
                        -->
                        @if(strcmp(old('profile'),$current_profile)==0)
                            <option value="{{$current_profile}}" selected> {{$current_profile}}</option>
                        @else
                            @if(strcmp($current_profile, "User")==0)
                                <option value="{{$current_profile}}" selected> {{$current_profile}}</option>
                            @else
                                <option value="{{$current_profile}}"> {{$current_profile}}</option>
                            @endif
                        @endif
                    
                @endforeach
                
            </select>
         </div>
                  
    </div>
    <div class="form-group row">
        <label for="notes" class="col-md-4 col-form-label text-md-right">Notes</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="notes" name="notes" rows="10" value="{{ old('notes') }}"></textarea>
        </div>
    </div>            
       
                      
    </div>
    <input type="hidden" id="submission_type" name="submission_type" value="create_member">
     <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" id="button" name="button" value="Save" > Save</button>
        </div>
    </div>                 
                    
 </form>                        
</p>           

    

  
<script>

 



$(document).ready(function() {
    $('.summernote').summernote();
			   



    $('.summernote').summernote({
        popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
              ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
            
        },
        lang: 'en-US', // Change to your chosen language
        imageAttributes:{
            icon:'<i class="note-icon-pencil"/>',
            removeEmpty:false, // true = remove attributes | false = leave empty if present
            disableUpload: false // true = don't display Upload Options | Display Upload Options
        }
    });
    
     $(function () {
                $('#date_of_birth').datetimepicker({
                 
                 format: 'D/M/YYYY'
                });
            });

});
</script>
@endsection