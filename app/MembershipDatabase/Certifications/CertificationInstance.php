<?php

/* 
 * Creates an instance of a Certification
 */

namespace App\MembershipDatabase\Certifications;


use Illuminate\Http\Request;
use Carbon\Carbon;  // used for current date
use App\MembershipDatabase\Certifications\Certification; // DB Model for Certification

class CertificationInstance{
    
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
     * contructor with 1 argument, assigns to member no
     * @param type $page
     */
    public function __construct1($page){
        
        $this->member_no = $page;
        
    }
    
    /*
     * outputs the member no of the object
     */
    public function getMemberNo(){
        
      return $this->member_no; 
    }
    
    // Retreives list of all certifications for a member
    public function retreiveCertbyMember(){
        
        $member_no = $this->member_no;
        $MemberCertificates = Certification::where('member',$member_no)
                                ->get();
        
        return $MemberCertificates;
        
        
    }
    
    // takes in a request and creates a new instance of certification
    public function createCertification(Request $request){
        
        try{
            
            $Certificate = new Certification();
            $message = "Cert could not be added";
            if($request->membership_no){
                
                $Certificate->member =$request->membership_no;
            }
            else{
                $message.=" Member number was missing";
            
            }
        
            if($request->cert_type){
                $Certificate->certificate =$request->cert_type;
            }
            else{
                $message.=" Cert type was missing";
            
            }
        
         
            $Certificate->teacher =$request->teacher;
            $Certificate->number_of_days_of_training =$request->no_days;
        
            if($request->date_of_cert){
               
                $newDate= Carbon::createFromFormat('d/m/Y', $request->date_of_cert);
                $Certificate->date_of_cert =$newDate;
                
            }
            else{
                $message.=" date of cert was missing";
            
            }
            
            // if date expires is required either add to database or output error message
            
            if(strcmp($request->is_date_expired, 'yes')==0){
                if($request->date_expires){
                   
                    $newDate= Carbon::createFromFormat('d/m/Y', $request->date_expires);
                    $Certificate->date_expires =$newDate;
                }
                else{
                    $message.=" expired date of cert was missing";
            
                }
                
                
            }
            
            
        
           
        
            $Certificate->created_at=Carbon::now();   
            $Certificate->updated_at=Carbon::now();
       
            if(strcmp($message,"Cert could not be added")==0){
                $Certificate->save();
                $message="Cert was saved";
           
            }
            return $message;
        }
        catch (Exception $ex) {
             return back()->withError($ex->getMessage())->withInput();
            //$message=withError($ex->getMessage())->withInput();
            //return $message;

        }
    }
    
    // delete certicate , takes in an id which is teh ID of the cert
    public function deleteCert($id){
        $Cert_result=$this->retreiveCertbyID($id);
        $Cert_result->delete();
        $message="Cert type has been deleted";
        return $message;
        
        
    }
    
    // Retreives cert by id
    private function retreiveCertbyID($id){
        
        $MemberCertificates = Certification::where('id',$id)
                                ->first();
        
        return $MemberCertificates;
        
        
    }
    
     // Takes in cert_name. Searches if the member has the given cert. 
    // returns true or false
    // used for checking certs without needing expiry date
    public function searchForCert($cert_name){
        $member_no = $this->member_no;
        $cert_result = Certification::where([['member',$member_no],['certificate', $cert_name]])
                                            ->first();
        
        if($cert_result){
            return "Certified";
            
        }
        else{
            
            return "Not Certified";
        }
        
    }
    
    // Takes in a cert name. searches for cert with date. Checks if with in date
    // if expired returns a string expired
    // if due to expire within a month, retur straing due to expire
    // if not expired returns a string not expired
    public function IsCertExpired($cert_name){
        
        $member_no=$this->member_no;
        $cert_result = Certification::where([['member',$member_no],['certificate', $cert_name]])
                                            ->get();
        
        // if there are no results
        if(!$cert_result){
            
            return "expired";
        }
            
        
        
        $todays_date = Carbon::now();
        $one_month_from_now= Carbon::now()->addMonths(1);
        $expired = "expired";
        
        
        foreach($cert_result as $current_cert){
            $date_expires = Carbon::parse($current_cert->date_expires);
            $start_date = Carbon::parse($current_cert->date_of_cert);
            //option 1 is cert date less then today - expired          
            if($todays_date->greaterThan($date_expires) ){
                
                $expired = "expired";
                
                
            }
            //option 2 is todays date greater then or equal to cert start date and is todays date less then cert end date - not expired
            else if($todays_date->greaterThanOrEqualTo($start_date) && $todays_date->lessThanOrEqualTo($date_expires) ){
                
                //option 3  and is one month from now greater then cert end date - due to expire
                if($one_month_from_now->greaterThanOrEqualTo($date_expires)){
                    $expired = "due to expire";
                }
                else{
                    $expired = "not expired";
                }
            }
            else{
                
                $expired = "expired";
                
                
            }
            
            
        }
        return $expired;
    }
    
    
    
}


