<?php

/* 
 * Creates an instance of MembershipType
 */

namespace App\MembershipDatabase\Membership;

use App\MembershipDatabase\Membership\Membership_type; // DB model for Membership_type
use Illuminate\Http\Request;
use Carbon\Carbon;

class MembershipType{
    
    /*
     * Constructor
     */
    function __construct(){}
    
    // outputs all the required membership types
   public function retrieveMembershipTypes(){
       
       $Membership_type_result = Membership_type::select('membership_type', 'description','id')
               ->orderBy('membership_type', 'asc') 
               ->get();
         
         return $Membership_type_result;
   }
    
   // takes in a arequest from create membership type, adds type and description to the database
   public function createMembershipType(Request $request){
        try{
            
            
        
        // check if cert type already exists.  if not returh cert already exits message
                $membership_type_result=$this->retrieveMembershipType($request->membership_type);
                if($membership_type_result){
            
                    $message="Membership type already exists, please choose another name";
            
                }
                else{
            
                    $message=$this->UpdateMembershipType($request);
                }
            
                return $message;   
            } catch (Exception $ex) {
                return back()->withError($ex->getMessage())->withInput();
            }
       
   }
   
   // takes in a membership type and checks the database if exists
   private function retrieveMembershipType($membership_type){
       
        $Membership_type = Membership_type::where('membership_type',$membership_type)
                                ->first();
        
        return $Membership_type;
   }
   
   // takes in a requsst of membership type fields and creates a new membership type instance
   private function UpdateMembershipType(Request $request){
        
       $message = "Could not create a new Membership Type: ";
       $Membership_type = new Membership_type();
       if($request->membership_type){
            $Membership_type->membership_type = $request->membership_type;
       }
       else{
            $message.=" Membership type is missing.";
       }
       
       if($request->description){
            $Membership_type->description = $request->description;
       }
       
       $Membership_type->created_at=Carbon::now();   
       $Membership_type->updated_at=Carbon::now();
        
       if(strcmp($message, "Could not create a new Membership Type: ")==0){
           
           $Membership_type->save();
           $message = "Membership Type created";
       }
       
       return $message;
   }
   
    // takes in a request , deletes membership type and returns message
   public function deleteMembershipType($membership_type_id){
       
       
       $Membership_type_result = $this->retrieveMembershipTypeByID($membership_type_id);
       $Membership_type_result->delete();
                 
       
       $message = "Membership type Deleted";
       return $message;
   }
   
    // takes in a membership type id and and checks the database if exists
   private function retrieveMembershipTypeByID($membership_type_id){
       
        $Membership_type = Membership_type::where('id',$membership_type_id)
                                ->first();
        
        return $Membership_type;
   }
}