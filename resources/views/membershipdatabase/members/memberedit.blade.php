<?php

/* 
 * Page to generate a form to create a webpage
 */
use App\Http\Controllers\MembershipController;
use Carbon\Carbon;  // used for current date

//$Member_result = MembershipController::displayMemberById($page); // retrieves the next membership number value





// assign from passed variables
$county_list_array= $county_list_array;
$gender_array= $gender_array;
$profile_array = $profile_array;
$default_country = $default_country;
$Member_result = $Member_result;
$member_list_result = $member_list_result;//retrieves the list of members 
$member_county=$Member_result->county; // retrieves the current county of the member to be edited
$member_gender= $Member_result->gender;
//retrieves current referee result
//$Referee_result= MembershipController::retreiveReferee($Member_result->membership_no);
$Referee_result=$Referee_result;
if($Referee_result){
    $referee_referer=$Referee_result->referrer; // retieves the current referrer if available
}

$newDateOfBirth=Carbon::createFromFormat('Y-m-d', $Member_result->date_of_birth)->format('d/m/Y');



$member_profile=$Member_result->profile; // retreives the current profile 




if(!isset($message)){
    $message ="";
}
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Edit Member </title>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-8">
        <div class="wrapper">
            <h1>Edit Member Number</h1>
            
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
 <form action="{{route('membershipPersist')}}" method="POST">
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
        <label for="address_line_one" class="col-md-4 col-form-label text-md-right">Address Line one</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" name="address_line_one" id="address_line_one" rows="2" >{{ old('address_line_one') ? old('address_line_one') : $Member_result->address_line_one }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="address_line_two" class="col-md-4 col-form-label text-md-right">Address Line two</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="address_line_two" name="address_line_two" rows="2" >{{ old('address_line_two') ? old('address_line_two'): $Member_result->address_line_two }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="address_line_three" class="col-md-4 col-form-label text-md-right">Address Line Three</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="address_line_three" name="address_line_three" rows="2">{{ old('address_line_three') ? old('address_line_three'): $Member_result->address_line_three }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="county" class="col-md-4 col-form-label text-md-right">County</label>                 
         <div class="col-md-6">
             <select class="mdb-select md-form" id="county" name="county">
                <option value="" disabled selected>Choose County</option>
                @foreach($county_list_array as $current_county)
                    <!--if an old value is not returned
                    -->
                    @if(old('county'))
                        <!-- check if the selected value is the same as the old value, if it is assign 
                            the selected property
                        -->
                        @if(strcmp(old('county'),$current_county)==0)
                            <option value="{{$current_county}}" selected> {{$current_county}}</option>
                        @else
                            <option value="{{$current_county}}"> {{$current_county}}</option>
                        @endif
                        
                    @else
                        <!-- check if the selected valued is the same as the current county, if it is assign 
                            the selected property
                        -->
                        
                        @if(strcmp($member_county,$current_county)==0)
                            <option value="{{$current_county}}" selected> {{$current_county}}</option>
                        @else
                            <option value="{{$current_county}}"> {{$current_county}}</option>
                        @endif
                    @endif
                @endforeach
                    
               
            </select>
         </div>
                  
    </div>                
                    
    
                    
    <div class="form-group row">
        <label for="postcode" class="col-md-4 col-form-label text-md-right">Postcode</label>

        <div class="col-md-6">
            <input id="postcode" type="text" class="form-control" name="postcode" value="{{ old('postcode') ? old('postcode'): $Member_result->post_code }}">
        </div>
    </div>
     <div class="form-group row">
        <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>

        <div class="col-md-6">
            <input id="country" type="text" class="form-control" name="country" value="{{ old('country') ? old('country'):$Member_result->address_country}}">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

        <div class="col-md-6">
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') ? old('email'):$Member_result->email }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="mobile_number" class="col-md-4 col-form-label text-md-right">Mobile Number</label>

        <div class="col-md-6">
            <input id="mobile_number" type="text" class="form-control" name="mobile_number" value="{{ old('mobile_number') ? old('mobile_number'):$Member_result->mobile }}">
        </div>
    </div>               
    <div class="form-group row">
        <label for="home_number" class="col-md-4 col-form-label text-md-right">Home Number</label>

        <div class="col-md-6">
            <input id="home_number" type="text" class="form-control" name="home_number" value="{{ old('home_number') ? old('home_number'):$Member_result->home_phone }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="work_number" class="col-md-4 col-form-label text-md-right">Work Number</label>

        <div class="col-md-6">
            <input id="work_number" type="text" class="form-control" name="work_number" value="{{ old('work_number')? old('work_number'):$Member_result->work_phone }}">
        </div>
    </div> 
    <div class="form-group row">
        <label for="occupation" class="col-md-4 col-form-label text-md-right">Occupation</label>

        <div class="col-md-6">
            <input id="occupation" type="text" class="form-control" name="occupation" value="{{ old('occupation')? old('occupation'):$Member_result->occupation }}">
        </div>
    </div> 
    <div class="form-group row">
        <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>                 
         <div class="col-md-6">
             <select class="mdb-select md-form" id="gender" name="gender">
                <option value="" disabled selected>Choose your option</option>
                @foreach($gender_array as $current_gender)
                    <!--if an old value is not returned
                    -->
                    @if(old('county'))
                        <!-- check if the selected value is the same as the old value, if it is assign 
                            the selected property
                        -->
                        @if(strcmp(old('gender'),$current_gender)==0)
                            <option value="{{$current_gender}}" selected> {{$current_gender}}</option>
                        @else
                            <option value="{{$current_gender}}"> {{$current_gender}}</option>
                        @endif
                    @else
                    
                        <!-- check if the selected value is the same as the current county, if it is assign 
                            the selected property
                        -->
                        @if(strcmp($member_gender,$current_gender)==0)
                            <option value="{{$current_gender}}" selected> {{$current_gender}}</option>
                        @else
                            <option value="{{$current_gender}}"> {{$current_gender}}</option>
                        @endif
                        
                    @endif
                @endforeach
                
  
            </select>
         </div>
        
   
            
                  
    </div>           
    <div class="form-group row">
        <label for="skills" class="col-md-4 col-form-label text-md-right">Skills</label>

        <div class="col-md-6">
            
            <textarea class="form-control rounded-0" id="skills" name="skills" rows="5">{{ old('skills') ? old('skills'):$Member_result->skills  }}</textarea>
        </div>
    </div>               
    <div class="form-group row">
        <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Date of Birth</label>
        <div class="col-md-6">  
            <div class="input-group date" id="date_of_birth" data-target-input="nearest">
                <input type="text" id="date_of_birth"  name="date_of_birth" class="form-control datetimepicker-input" data-target="#date_of_birth" value="{{old('date_of_birth')? old('date_of_birth'): $newDateOfBirth }}"/>
                <div class="input-group-append" data-target="#date_of_birth" data-toggle="datetimepicker" >
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
                    
                    <!-- If there is an old version of is_administrator, put as checked
             -->
                    @if(old('profile'))
                         @if(strcmp(old('profile'),$current_profile)==0)
                            <option value="{{$current_profile}}" selected> {{$current_profile}}</option>
                        @else
                            <option value="{{$current_profile}}"> {{$current_profile}}</option>
                        @endif
                    @else
                         @if(strcmp($member_profile,$current_profile)==0)
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
            
            <textarea class="form-control rounded-0" id="notes" name="notes" rows="10">{{ old('notes')?old('notes'):$Member_result->notes }}</textarea>
        </div>
    </div>            
       
    <!-- Referee will be used to edit member
    -->
    <div class="form-group row referee-form">
        <label for="referee" class="col-md-4 col-form-label text-md-right">Referee</label>                 
         <div class="col-md-6">
             <select class="mdb-select md-form" id='referee' name='referee'>
                <option value="">Choose a Referee</option>
                @foreach($member_list_result as $current_member)
                    
                    @if(old('referee'))
                        @if(strcmp(old('referee'), $current_member->membership_no)==0)
                           <option value="{{$current_member->membership_no}}" selected>{{$current_member->name}} {{$current_member->surname}}, {{$current_member->membership_no}}</option> 
                           
                        @else
                           <option value="{{$current_member->membership_no}}">{{$current_member->name}} {{$current_member->surname}}, {{$current_member->membership_no}}</option>
                        @endif
                    @elseif(!$Referee_result)
                             <option value="{{$current_member->membership_no}}">{{$current_member->name}} {{$current_member->surname}}, {{$current_member->membership_no}}</option>
                        
                        
                    @else
                        @if(strcmp($referee_referer, $current_member->membership_no)==0)
                           <option value="{{$current_member->membership_no}}" selected>{{$current_member->name}} {{$current_member->surname}}, {{$current_member->membership_no}}</option>
                        @else
                           <option value="{{$current_member->membership_no}}">{{$current_member->name}} {{$current_member->surname}}, {{$current_member->membership_no}}</option>
                       @endif
                       
                        
                    @endif
                @endforeach
                       
                       
                        
  
            </select>
         </div>
                  
    </div>
    <input type="hidden" id="submission_type" name="submission_type" value="edit_member">
     <div class="form-group row">
        <div class="col-md-2 offset-md-4">
            <button type="submit" id="button" name="button" value="Save" > Save</button>
        </div>
            <div class="col-md-2 offset-md-2">
            <button type="submit" id="button" name="button" value="Delete" > Delete Member</button>
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
            
    $('button').click(function(){
    
        if($(this).val()=="Delete"){
        
            return deleteButton();
        }
        else
        {
            return true;
        }
 
    })// end of click button annonymous function
    
    function deleteButton(){
       var answer = confirm("Are you sure you want to Delete this member?");
        return answer;
        
         if(!answer){
                 return false;
             }
        
     
         
    }//end of deleteBooutoon fucition
        
    





});
</script>
@endsection