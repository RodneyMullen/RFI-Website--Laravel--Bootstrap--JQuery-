<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MembershipDatabase\PractitionerListing\Practitioner_listing_preference;
use App\MembershipDatabase\PractitionerListing\Practitioner_listing;
use App\MembershipDatabase\PractitionerListing\PractitionerListingPreference;
use App\MembershipDatabase\PractitionerListing\PractitionerListing;
use App\MembershipDatabase\Dashboards\MemberList;

use App\MembershipDatabase\Members\MemberInstance;
use Carbon\Carbon;

class PractitionerController extends Controller
{
   // constructor
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    /*
     * retreives the practitioner listings available and sends to the practitionerlistingpreference view
     */
    public function practitionerListingPreferenceForm(){
        $PractitionerListingPreference = new PractitionerListingPreference();
        
        $practitioner_listing_preference_results = $PractitionerListingPreference->retrievePractitionerListingPreferences();  // retrieves list of practitioner listing preferences

        return view('membershipdatabase.practitionerlisting.practitionerlistingpreference', compact('practitioner_listing_preference_results'));
    }
    
    // Takes in a request from add practitioner listing preference
   // send to update practitioner listng preference if a new preference
   // send to delete practitioner listng preference if to delete preference
   public function routePractitionerListingPreference(Request $request){
       
      $PractitionerListingPreference = new PractitionerListingPreference();
       // create practitioner lising
       if($request->save_practitioner_listing_preference_button){
           $message=$PractitionerListingPreference->updatePractitionerListingPreference($request);
           
           
       }
       // delete practitioner lising
       elseif($request->delete_preference_button){
           
           $message=$PractitionerListingPreference->deletePractitionerListingPreference($request->delete_preference_button);
           
       }
       
       
        $practitioner_listing_preference_results = $PractitionerListingPreference->retrievePractitionerListingPreferences();  // retrieves list of practitioner listing preferences

        return view('membershipdatabase.practitionerlisting.practitionerlistingpreference', compact('practitioner_listing_preference_results','message'));
    
       
       
       
   }
   
   
   public function practitionerListingForm(Request $request){
       $route_split = explode("/",$request->path());
       $page = $route_split[1];
       
       $Practitioner_listing_result = Practitioner_listing::where('member', $page)
                                        ->first();
       
       $MemberInstance = new MemberInstance($page);
       $Member_result = $MemberInstance->displayMemberById(); // retrieves the next membership number value
       
       $PractitionerListingPreference = new PractitionerListingPreference();
       $Preferences_result = $PractitionerListingPreference->retrievePractitionerListingPreferences(); // retrieves list of preferences avaialble

       
       if($Practitioner_listing_result){
           $PractitionerListing = new PractitionerListing($page);
           $Listing_result = $PractitionerListing->retrievePractitionerListingByMember(); // retrieves the next membership number value
           return view('membershipdatabase.practitionerlisting.editpractitionerlisting',compact('page', 'Member_result','Preferences_result','Listing_result'));
       }
       else
       {
           return view('membershipdatabase.practitionerlisting.addpractitionerlisting',compact('page', 'Member_result','Preferences_result'));
       }
       
       
   }
  
   
  
   
   /**
    * takes in a request from a add practitioner listing form
    * routes to save/edit data or delete date
    * returns a message of completion 
    */
   public function practitionerListingRoute(Request $request){
       $page=$request->membership_no;
       $PractitionerListing = new PractitionerListing($page);
       if(strcmp($request->save_practitioner_listing,"Create")==0){
           
           $Practitioner_listing = new Practitioner_listing();
           $message = $PractitionerListing->updatePractitionerListing($request, $Practitioner_listing);
           
       }
       elseif(strcmp($request->save_practitioner_listing,"Save")==0){
           
          $Practitioner_listing= $PractitionerListing->retrievePractitionerListingByID($request->practitioner_listing_id);
          if(!$Practitioner_listing){
              $message="Practitioner listing does not exist, please try again";
          }
          else{
              $message = $PractitionerListing->updatePractitionerListing($request, $Practitioner_listing);
          }
         
       }
       elseif(strcmp($request->delete_practitioner_listing, "Delete")==0){
           $message=$PractitionerListing->deletePractitionerListing($request->practitioner_listing_id);
            $MemberList = new MemberList();
            $member_list_result = $MemberList->displayMemberListing();
        
        return view('membershipdatabase.dashboards.viewmembers', compact('member_list_result','message'));
       }
       else{
           $message="Unexpected error occured, please try again";
       }
       
       $MemberInstance = new MemberInstance($page);
       $Member_result = $MemberInstance->displayMemberById(); // retrieves the next membership number value
       
       $PractitionerListingPreference = new PractitionerListingPreference();
       $Preferences_result = $PractitionerListingPreference->retrievePractitionerListingPreferences(); // retrieves list of preferences avaialble
       $Listing_result = $PractitionerListing->retrievePractitionerListingByMember(); // retrieves the next membership number value
       
       return view('membershipdatabase.practitionerlisting.editpractitionerlisting',compact('page', 'Member_result','Preferences_result','Listing_result','message'));
       
      
   }
   
  
   
  
        
        
 
}
