<?php

/* 
 * reates an instance of PractitionerListing
 */

namespace App\MembershipDatabase\PractitionerListing;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MembershipDatabase\PractitionerListing\Practitioner_listing; // Model DB for Practitioner Listing


class PractitionerListing{
    
    public $member_no;
    /**
     * Constructor, reviews the functiono name and number of arguments,
     * if more then one passed on the the required argument, in this case 1
     */
    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
        
    }
    
    
    /**
     * constructer allowing one argunent
     * @param type $member_no
     */
    public function __construct1($id){
        
        
        $this->member_no = $id;
        
        
    }
    
     /**
    * Takes in a request for create practitioner listing and updates database
    * returns message of completion
    * @param Request $request Practitioner_listing $Practitioner_listing
    */
   public function updatePractitionerListing(Request $request, Practitioner_listing $Practitioner_listing){
       
      
       try{
           $message = "Could not save Pratictioner listing: ";
           
           if($request->membership_no){
               $Practitioner_listing->member = $request->membership_no;
               
           }
           else{
               
               $message.="Member number was missing. ";
           }
           
           if($request->listing_name){
               $Practitioner_listing->listing_name = $request->listing_name;
               
           }
           else{
               
               $message.="Listing name was missing. ";
           }
           
           if($request->listing_preference){
               $Practitioner_listing->listing_preference = $request->listing_preference;
               
           }
           else{
               
               $message.="Listing Preference was missing. ";
           }
           
           if($request->appear_on_website){
               $Practitioner_listing->appear_on_website = $request->appear_on_website;
               
           }
           else{
               
               $message.="Appear on website setting was missing. ";
           }
           
           if($request->phone){
               $Practitioner_listing->phone = $request->phone;
               
           }
           
           if($request->mobile){
               $Practitioner_listing->mobile = $request->mobile;
               
           }
          
           if($request->email){
               $Practitioner_listing->email = $request->email;
               
           }
           
           if($request->listing_website){
               $Practitioner_listing->listing_website = $request->listing_website;
               
           }
           
           if($request->is_exempt){
               $Practitioner_listing->is_exempt = $request->is_exempt;
               
           }
           else{
               
               $message.="Exemption setting was missing. ";
           }  
           
           if($request->listing_notes){
               $Practitioner_listing->listing_notes = $request->listing_notes;
               
           }
           
           $Practitioner_listing->created_at=Carbon::now();   
           $Practitioner_listing->updated_at=Carbon::now();
            
           if(strcmp($message,"Could not save Pratictioner listing: " )==0){
               $Practitioner_listing->save();
               $message ="Practitioner Listing saved";
           }
           return $message;
           
       } catch (Exception $ex) {
           $message = "issue occured, could not process request";
           return $message;
       }
   }  
   
   /**
    * takes in a listing Id number and searches practitioner listing database
    * for result, returns result
    */
    public function retrievePractitionerListingById($listing_id){
           
        $Practitioner_listing = Practitioner_listing::where('id', $listing_id)
                                        ->first();
        
        return $Practitioner_listing;
        
    }
    
    public function retrievePractitionerListingByMember(){
        $member_id = $this->member_no;
        $Practitioner_listing = Practitioner_listing::where('member', $member_id)
                                        ->first();
        
        return $Practitioner_listing;
        
    }
   
   /**
    * Takes in a request to delete a practitioner listing
    * finds the listings and delete is
    * @param type $listing_id
    */ 
   public function deletePractitionerListing($listing_id){
       
       $Practitioner_listing = $this->retrievePractitionerListingById($listing_id);
       if(!$Practitioner_listing){
           $message = "Practitioner listing does not exist";
           
       }
       else{
           
           $Practitioner_listing->delete();
           $message="Practitioner listing has been deleted";
       }
       return $message;
       
       
   }
    
    
}
