<?php

/* 
 * Creates an instance of RFI Membership
 */

namespace App\MembershipDatabase\Membership;

use App\MembershipDatabase\Membership\Rfi_membership;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RFIMembership{
    
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
     * constructoer allowing one argunent
     * @param type $member_no
     */
    public function __construct1($id){
        
        
        $this->member_no = $id;
        
        
    }
    
     // takes in a member no and retreives the list of memberhships
    public function retrieveRfiMembershipByMember(){
       
        $member_no = $this->member_no;
        $Rfi_membership_result = Rfi_membership::where('member',$member_no)
                                ->get();
        
        return $Rfi_membership_result;
   }
   
   /**takes in a request to create a new RFI membership
    * Checks each item in the request and creates a new instance in the database
    * returns message if succesful or not
    */
   
   public function updateRFIMembership(Request $request){
       
        
       $message = "Could not create a new RFI Membership: ";
       
       
       $Rfi_membership = new Rfi_membership();
       if($request->membership_no){
            $Rfi_membership->member = $request->membership_no;
       }
       else{
            $message.=" Member number is missing.";
       }
       
       if($request->membership_type){
            $Rfi_membership->membership_type = $request->membership_type;
       }
       else{
            $message.=" Membership type is missing.";
       }
       
       if($request->notes){
            $Rfi_membership->notes = $request->notes;
       }
       
       if($request->start_date){
           $newDate= Carbon::createFromFormat('d/m/Y', $request->start_date);
                     
            $Rfi_membership->start_of_membership = $newDate;
        }
        else{
            $message.=" Start Date is missing.";
        }
        
        if($request->end_date){
            
            $newDate=Carbon::createFromFormat('d/m/Y', $request->end_date);
                      
            
            $Rfi_membership->end_of_membership = $newDate;
        }
        else{
            $message.=" End Date is missing.";
        }
       
       
       $Rfi_membership->created_at=Carbon::now();   
       $Rfi_membership->updated_at=Carbon::now();
        
       if(strcmp($message, "Could not create a new RFI Membership: ")==0){
           
           $Rfi_membership->save();
           $message = "New Membership created";
       }
       
       return $message;
       
   }
   
   /**
    * Takes in memebrship ID and delets from the database
    * @param type $membership_id
    */
   public function deleteRFIMembership($id){
       
       $Rfi_membership_result = $this->retrieveRfiMembershipByID($id);
       $Rfi_membership_result->delete();
                 
       
       $message = "RFI Membership Deleted";
       return $message;
   }
       
    // takes in a membership type id and and checks the database if exists
   private function retrieveRfiMembershipByID($membership_id){
       
        $Rfi_membership = Rfi_membership::where('id',$membership_id)
                                ->first();
        
        return $Rfi_membership;
   }
    
}

