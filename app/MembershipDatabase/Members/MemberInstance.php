<?php

/* 
 * Creates a MemberInstance object represenitng a member
 */

namespace App\MembershipDatabase\Members;

use App\MembershipDatabase\Members\Member; // Member DB
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\MembershipDatabase\Members\Referee; // Referee DB


class MemberInstance{
    
    public $member_no;
    
    public $Member;   // Instance of Member DB
    public $Referee;
    
    
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
    
    function accessMemberID(){
        
        
        return $this->member_no;
    }
    
    
    // queries the datbase and outputs the next membership number available
    public function retrieveNextMembershipNo(){
        
        $max_value = Member::max('membership_no');
        if(!$max_value){
            $max_value=1;
        }
        else{
            $max_value++;
            
        }
        return $max_value;
    }
    
    // searches the member table and looks from member id.  If present returns true
     public function checkForMemberId(){
       
         $member_id=$this->member_no;
       $Member = Member::where('membership_no',$member_id)
                                   ->first();    
       return $Member;
       
   }
   
  //takes in a request from member create and adds to the database.  return message of status
    public function createMember(Request $request){
    
        
        try{
            $message = "Member was not created, something went wrong:";
            $Member = new Member();
            $this->Member = $Member;
            // membership number is required
            $message=$this->updateDatabase($request, $message);       
             
            
            // if the message has not changed, no errors appeared. Results can be saved to the member table
            if(strcmp($message, "Member was not created, something went wrong:")==0)
            {
                $Member->save();
                $message="New Member created";
                
            }
            
            return $message;
            
               
            
        }  
        catch (Exception $ex) {
             return back()->withError($ex->getMessage())->withInput();
            //$message=withError($ex->getMessage())->withInput();
            //return $message;

        }
        
    }
    
    // Takes in a request, Member and $message, assigns the required items and returns message
    private function updateDatabase(Request $request, $message)
    {
        $Member = $this->Member;
        
        
        if($request->membership_no){
                $Member->membership_no = $request->membership_no;
            }
            else{
                $message.=" Membership number was missing.";
            }
            
            
            // first name is required
            if($request->member_first_name){
                $Member->name = $request->member_first_name;
            }
            else{
                $message.=" First name was missing.";
            }
            
            // first name is required
            if($request->member_surname){
                $Member->surname = $request->member_surname;
            }
            else{
                $message.=" Surname was missing.";
            }
            
            // first line of address is required
            if($request->address_line_one){
                $Member->address_line_one = $request->address_line_one;
            }
            else{
                $message.=" First line of the address was missing.";
            }
            
            // second line of the address is not required
            if($request->address_line_two){
                $Member->address_line_two = $request->address_line_two;
            }
            
            // third line of the address is not required
            if($request->address_line_three){
                $Member->address_line_three = $request->address_line_three;
            }
            
            // county is required
            if($request->county){
                $Member->county = $request->county;
            }
            else{
                $message.=" County was missing.";
            }
            
            // county is required
            if($request->country){
                $Member->address_country = $request->country;
            }
            else{
                $message.=" Country was missing.";
            }
            
            // postcode is not required
            if($request->postcode){
                $Member->post_code = $request->postcode;
            }
            
            // email is not required
            if($request->email){
                $Member->email = $request->email;
            }
            
            // mobile number is not required
            if($request->mobile_number){
                $Member->mobile = $request->mobile_number;
            }
            
             // home phone number is not required
            if($request->home_number){
                $Member->home_phone = $request->home_number;
            }
            
            // work phone number is not required
            if($request->work_number){
                $Member->work_phone = $request->work_number;
            }
            
             // occupation is not required
            if($request->occupation){
                $Member->occupation = $request->occupation;
            }
            
            // gender is required
            if($request->gender){
                $Member->gender = $request->gender;
            }
            else{
                $message.=" Gender was missing.";
            }
            
            // skills is not required
            if($request->skills){
                $Member->skills = $request->skills;
            }
            
            // date of birth is required
            if($request->date_of_birth){
                $newDate= Carbon::createFromFormat('d/m/Y', $request->date_of_birth);
               // $date = DateTime::createFromFormat('d/m/Y',$request->date_of_birth);
               // $newDate =$date->format("Y-m-d");
            
            
                $Member->date_of_birth = $newDate;
            }
            else{
                $message.=" Date of birth was missing.";
            }
           
           if(isset($request->profile)){
               $Member->profile= $request->profile;
           }
           
           
           
           // notes are not required
            if($request->notes){
                $Member->notes = $request->notes;
            }
            
            
            $Member->created_at=Carbon::now();   
            $Member->updated_at=Carbon::now();
            
         return $message;
    }
    
    /**
     * Takes in a member number and returns member details
     * @param type $member_no
     */
    public function displayMemberById(){
       
       $id = $this->member_no;
       $Member_result = Member::where('membership_no',$id)
                                   ->first(); 
       return $Member_result;
       
   }
   
   // retreievss a list of members and numbers to select a referee 
   public static function retreiveReferee($member_no){
       $Referee_result = Referee::where('member',$member_no)
                                   ->first();
       return $Referee_result;
       
   }
   
   //takes i a request and send to update the database information and the referee database information
    // returns message if not not successful
    public function editMember(Request $request){
        
           
           $member_no = $this->member_no;
           
           
           
        try{
            $message = "Member was not edited, something went wrong:";
            // retreive the member by the ID of the record
            $Member = $this->displayMemberById($member_no);
            $this->Member= $Member;
            // membership number is required
            $message=$this->updateDatabase($request, $message);  
            
            $Referee= $this->retreiveReferee($member_no);
            $this->Referee = $Referee;
            // the referee request was blank but there was an old record
            // record will need to be deleted
            
            // check if referer has been intialised
            if(strcmp($request->referee,"")!=0){
                // retreive the Referee by the membership number
               
                
                // If referee is not found, create a new referee
                if(!$Referee){
                    $Referee = new Referee();
                    $this->Referee = $Referee;
                
                }
            
                $this->updateReferee($request);   
             }
            // if the message has not changed, no errors appeared. Results can be saved to the member table
            if(strcmp($message, "Member was not edited, something went wrong:")==0)
            {
                
                $Member->save();
                if(strcmp($request->referee,"")==0 && $Referee){
                
                    $Referee->delete();
                }   
                else if($Referee){
                    $Referee->save();
                }
                $message="Member was edited";
                
            }
            return $message;
            
               
            
        }  
        catch (Exception $ex) {
             return back()->withError($ex->getMessage())->withInput();
            //$message=withError($ex->getMessage())->withInput();
            //return $message;

        }
    }
    
     // takes in a request and updates the Referee database and replies with message if succesful or not
    private function updateReferee(Request $request){
        $Referee = $this->Referee;
        
        
        

        // do not need to check if these attributes are present as they are alreacy checke previously
        $Referee->member = $request->membership_no;
        $Referee->referrer = $request->referee;
        $Referee->created_at=Carbon::now();   
        $Referee->updated_at=Carbon::now();
            
    }
    
    // takes in a request , deletes member and returns message
   public function deleteMember(){
       $member_no=$this->member_no;
       
       
       $Member = $this->displayMemberById($member_no);
       $this->Member = $Member;
       $Member->delete();
       $Referee = $this->retreiveReferee($member_no);
       $this->Referee = $Referee;
       if($Referee){
          $Referee->delete(); 
       }
           
       
       $message = "Member Deleted";
       return $message;
   }
    
}