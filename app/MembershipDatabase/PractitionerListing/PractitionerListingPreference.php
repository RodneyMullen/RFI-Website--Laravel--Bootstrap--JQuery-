<?php

/* 
 * Creates instace of a practitionerlisting prefernence
 * use as listing prefrences for practitioners
 */

namespace App\MembershipDatabase\PractitionerListing;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MembershipDatabase\PractitionerListing\Practitioner_listing_preference; // Model DB for Practitioner Listing



class PractitionerListingPreference{
    
    // Constructor
    function __contstruct(){}
    
   // takes in a member no and retreives the list of pracitioner listing preferences
   public function retrievePractitionerListingPreferences(){
       
        $Practitioner_listing_preference_result = Practitioner_listing_preference::select('listing_preference', 'description','id')
               ->orderBy('listing_preference', 'asc') 
               ->get();
        
        return $Practitioner_listing_preference_result;
   }
   
    /**takes in a request to create a new practitioner listing preference
    * Checks each item in the request and creates a new instance in the database
    * returns message if succesful or not
    */
   
   public function updatePractitionerListingPreference(Request $request){
       
        
       $message = "Could not create a new Practitioner Listing Preference: ";
       try{
           
          $Practitioner_listing_preference = new Practitioner_listing_preference();
            if($request->listing_preference){
                $Practitioner_listing_preference->listing_preference = $request->listing_preference;
            }
            else{
                $message.=" Listing preference is missing.";
            }
       
            if($request->description){
                $Practitioner_listing_preference->description = $request->description;
            }
       
       
       
       
       
            $Practitioner_listing_preference->created_at=Carbon::now();   
            $Practitioner_listing_preference->updated_at=Carbon::now();
        
            if(strcmp($message, "Could not create a new Practitioner Listing Preference: ")==0){
           
                $Practitioner_listing_preference->save();
                $message = "New Practitioner Listing Preference created";
            }
       
            return $message;
       } catch (Exception $ex) {
            $message = "issue occured, could not process request";
            return $message;
       }
   }
   
   /**
    * Takes in ID and delete practitioner listing preference  from the database
    * @param type $id
    */
   public function deletePractitionerListingPreference($preference_id){
       
       $Practitioner_listing_preference_result = $this->retrievePractitionerListingPreferenceByID($preference_id);
       $Practitioner_listing_preference_result->delete();
                 
       
       $message = "Practitioner Listing Preference Deleted";
       return $message;
   }
       
    // takes in a practitioner listing preference id and and checks the database if exists
   private function retrievePractitionerListingPreferenceByID($preference_id){
       
        $Practitioner_listing_preference_result = Practitioner_listing_preference::where('id',$preference_id)
                                ->first();
        
        return $Practitioner_listing_preference_result;
   }
}
