<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Rfi_membership;
use App\Referee;
use App\Membership_type;
use Carbon\Carbon;
use DateTime;

class MembershipController extends Controller
{
    
    var $Member;  // global accessible Member instance
    var $Referee; // global accessible Refree instance
   // constructor
    public function MembershipContoller(){}
    
    // queries the datbase and outputs the next membership number available
    public static function retrieveNextMembershipNo(){
        
        $max_value = Member::max('membership_no');
        if(!$max_value){
            $max_value=1;
        }
        else{
            $max_value++;
            
        }
        return $max_value;
    }
    
    // takes ina  request and finds out if it is edit or create
    public function membershipRoute(Request $request)
    {
        // if submission is from a create member request, check that member Id does not exist return with error
        if(strcmp($request->submission_type, "create_member")==0){
            
            // check if member does not already exist
            if(!$this->checkForMemberId($request->membership_no)){
                $message=$this->createMember($request);
                if(strcmp($message,"Member was created")!=0)
                {
                    return $message;
                }
                
                
            }
            else{
                
                $message="Member already exists";
                return $message;
            }
            
            
        }
        elseif(strcmp($request->button, "Delete")==0){
        
            $message=$this->deleteMember($request);
            return $message;
            
        }
        
        elseif(strcmp($request->submission_type, "edit_member")==0){
            
            $message=$this->editMember($request);
            if(strcmp($message,"Member was edited")!=0)
                {
                    return $message;
                }
            
            
        }
        
       return view('viewmembers',compact('message'));
        
    }
    
    //taked in a request from membershiptype blade and routes to add or delete membership type
    public function membershipTypeRoute(Request $request){
        
        if ($request->save_membership_type_button){
            $message=$this->createMembershiptype($request);
            
        }
        else{
            
            $message=$this->deleteMembershipType($request->delete_membership_type_button);
        }
        
        return view('membershiptypes',compact('message'));
        
    }
    
    //takes in a request from member create and adds to the database.  return message of status
    public function createMember(Request $request){
    
        global $Member;
    try{
            $message = "Member was not created, something went wrong:";
            $Member = new Member();
            // membership number is required
            $message=$this->updateDatabase($request, $message);       
            
            
            // if the message has not changed, no errors appeared. Results can be saved to the member table
            if(strcmp($message, "Member was not created, something went wrong:")==0)
            {
                $Member->save();
                $message="New Member created";
                return view('viewmembers',compact('message'));
            }
            else{
                
                return view('membercreate',compact('message'));
            }
            
               
            
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
        global $Member, $Referee;
        
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
    
    //takes i a request and send to update the database information and the referee database information
    // returns message if not not successful
    private function editMember(Request $request){
        global $Member, $Referee;
           
            
            
        try{
            $message = "Member was not edited, something went wrong:";
            // retreive the member by the ID of the record
            $Member = $this->displayMemberById($request->membership_no);
            // membership number is required
            $message=$this->updateDatabase($request, $message);  
            
            $Referee= $this->retreiveReferee($request->membership_no);
            
            // the referee request was blank but there was an old record
            // record will need to be deleted
            
            // check if referer has been intialised
            if(strcmp($request->referee,"")!=0){
                // retreive the Referee by the membership number
               
                
                // If referee is not found, create a new referee
                if(!$Referee){
                    $Referee = new Referee();
                
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
                $message="Member edited";
                return view('viewmembers',compact('message'));
            }
            else{
                
                return view('memberedit',compact('message'));
            }
            
               
            
        }  
        catch (Exception $ex) {
             return back()->withError($ex->getMessage())->withInput();
            //$message=withError($ex->getMessage())->withInput();
            //return $message;

        }
    }
    
    // takes in a request and updates the Referee database and replies with message if succesful or not
    private function updateReferee(Request $request){
        global $Referee;
        
        
        

        // do not need to check if these attributes are present as they are alreacy checke previously
        $Referee->member = $request->membership_no;
        $Referee->referrer = $request->referee;
        $Referee->created_at=Carbon::now();   
        $Referee->updated_at=Carbon::now();
            
    }
    
    // searches the member table and looks from member id.  If present returns true
   public static function checkForMemberId($member_id){
       
       $Member = Member::where('membership_no',$member_id)
                                   ->first();    
       return $Member;
       
   }
   
   public static function displayMemberListing(){
       
       
       $Member_result = Member::select('membership_no', 'name', 'surname', 'notes')
               ->orderBy('name', 'asc') 
               ->get();
       
        return $Member_result;
   }
   
   public static function displayMemberById($id){
       
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
   
   // takes in a request , deletes member and returns message
   private function deleteMember(Request $request){
       
       
       $Member_result = $this->displayMemberById($request->membership_no);
       $Member_result->delete();
       $Referee = $this->retreiveReferee($request->membership_no);
       if($Referee){
          $Referee->delete(); 
       }
           
       
       $message = "Member Deleted";
       return $message;
   }
   
   // takes in a arequest from create membership type, adds type and description to the database
   private function createMembershipType(Request $request){
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
   private function deleteMembershipType($membership_type_id){
       
       
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
   
   // outputs all the required membership types
   public static function retrieveMembershipTypes(){
       
       $Membership_type_result = Membership_type::select('membership_type', 'description','id')
               ->orderBy('membership_type', 'asc') 
               ->get();
         
         return $Membership_type_result;
   }
   
   // Takes in a request from RFI Membership form
   // send to update RFI membership if a new membership
   // send to delete RFI Membership if to delete membership
   public function routeRFIMembership(Request $request){
       
       // create membership
       if($request->create_rfi_membership_button){
           $message=$this->updateRFIMembership($request);
           
           
       }
       // delete membership
       else if($request->delete_rfi_membership_button){
           
           $message=$this->deleteRFIMembership($request->delete_rfi_membership_button);
       }
       $page=$request->membership_no;
            $feedback = array("message"=> $message, "member"=>$page );
            // addcertifications will need to return a message and the member/page number to reference
            return view('addrfimembership',compact('feedback'));
       
       
       
   }
   
   
   
   /**takes in a request to create a new RFI membership
    * Checks each item in the request and creates a new instance in the database
    * returns message if succesful or not
    */
   
   private function updateRFIMembership(Request $request){
       
        
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
           // $date = DateTime::createFromFormat('d/m/Y',$request->start_date);
            //$newDate =$date->format("Y-m-d");
            
            $Rfi_membership->start_of_membership = $newDate;
        }
        else{
            $message.=" Start Date is missing.";
        }
        
        if($request->end_date){
            $date = DateTime::createFromFormat('d/m/Y',$request->end_date);
            $newDate =$date->format("Y-m-d");
            
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
   private function deleteRFIMembership($membership_no){
       
       $Rfi_membership_result = $this->retrieveRfiMembershipByMember($membership_no);
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
   // takes in a member no and retreives the list of memberhships
   public static function retrieveRfiMembershipByMember($member_no){
       
        $Rfi_membership_result = Rfi_membership::where('member',$member_no)
                                ->get();
        
        return $Rfi_membership_result;
   }
}
