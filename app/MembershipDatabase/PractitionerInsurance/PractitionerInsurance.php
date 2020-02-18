<?php

/* 
 * Creates an insrance of Practitioner Insurance
 */

namespace App\MembershipDatabase\PractitionerInsurance;

use App\MembershipDatabase\PractitionerInsurance\Practitioner_insurance; // DB moderl of Practitionerinsurance
use App\MembershipDatabase\PractitionerInsurance\InsuranceProvider;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PractitionerInsurance{
    
    
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
    
     // returns a resultset of the Practitioner Insurances based on practitiioner
    public function retrievePractitionerInsurances(){
        
         $member_id = $this->member_no;
         $Practitioner_insurance_result = Practitioner_insurance::select('id','insurance_type','insurance_provider_name', 'start_date','end_date' )
               ->where('member','=',$member_id)
               ->orderBy('start_date', 'desc') 
               ->get();
         
         return $Practitioner_insurance_result;
    }
    
    // create new practitionerinsurance
    public function createPractitionerInsurance(Request $request, $Member_result){
        
        try{
        $message = "Could not create the new Practitioner Insurance";
        
        
            
        $message=$this->UpdatePractitionerInsurance($request, $Member_result);
            
        
        return $message;
        }
        catch (Exception $ex) {
             return back()->withError($ex->getMessage())->withInput();
            //$message=withError($ex->getMessage())->withInput();
            //return $message;

        }
        
    }
    
   
    
    // takes in a request and collection of memberresult form Member DB and created a new practitioner insurance and assignes values
    private function UpdatePractitionerInsurance(Request $request, $Member_result){
        
        $Practitioner_insurance = new Practitioner_insurance();
        $message = "Practitioner Insurance Provider could not be created.";
        $is_new_provider=false; // used to the end message if a new provider was added
        
        if($request->membership_no){
                       
            //if member exists
            if($Member_result){
                $Practitioner_insurance->member = $request->membership_no;           
            }
            else{
                $message.=" Member does not exist";
            }
            
        }
        else{
            $message.=" Member is missing";
        }
        
        if($request->insurance_type){
            $Practitioner_insurance->insurance_type = $request->insurance_type;
            
        }
        else{
            $message.=" Insurance type is missing";
            
        }
        
        // if using the provider list, set the provider based on the drop down menu
        if(strcmp($request->is_insurance_provider_list, "yes")==0)
        {
            if($request->provider_list){
                $Practitioner_insurance->insurance_provider_name = $request->provider_list;
                
            }
            else{
                
                $message.="Insurance Provider is missing";
            }
        }
        // else using created Insurance provider
        else{
            
            if($request->insurance_provider_name){
                $InsuranceProvider = new InsuranceProvider();
                
                $insurance_provider_message = $InsuranceProvider->createInsuranceProvider($request);
                if(strcmp($insurance_provider_message,"Insurance Provider has been added")!=0){
                    $message.= $insurance_provider_message;
                    
                }
                else{
                    $Practitioner_insurance->insurance_provider_name=$request->insurance_provider_name;
                    $is_new_provider = true;
                }
                
            }
            else{
                $message.="Insurance Provider name is missing";
            }
        }
        
        if($request->start_date){
            
           // $newDate=Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
            $newDate= Carbon::createFromFormat('d/m/Y', $request->start_date);
            
             $Practitioner_insurance->start_date =$newDate;
             
           
            
        }
        else{
            
            $message.="Start date is missing";
        }
        
        if($request->end_date){
            
           
            $newDate=Carbon::createFromFormat('d/m/Y', $request->end_date);
            $Practitioner_insurance->end_date =$newDate;
            
            
        }
        else{
            
            $message.="End date is missing";
        }
        
       
                
       $Practitioner_insurance->created_at=Carbon::now();   
       $Practitioner_insurance->updated_at=Carbon::now();
       
       if(Strcmp($message,"Practitioner Insurance Provider could not be created.")==0){
           $Practitioner_insurance->save();
           if($is_new_provider){
               
               $message = " Pratitioner Insurance and new Insurance Provider have been added";
           }
           else{
               $message = " Practitioner Insurance has been added";
           }
               
           
           
       }
       
       return $message;
    }
    
     // deletes record of insurance provider based on insurance provider name
    public function deletePractitionerInsurance($practitioner_insurance_id){
        $Practitioner_insurance_result=$this->retrieveOnePractitionerInsurance($practitioner_insurance_id);
        $Practitioner_insurance_result->delete();
        $message="Practitioner Insurance has been deleted";
        return $message;
        
        
    }
    
     // checks the insurance provider database if already exists
    private function retrieveOnePractitionerInsurance($practitioner_insurance_id){
        
         $Practitioner_insurance_result = Practitioner_insurance::where('id',$practitioner_insurance_id)
                                   ->first();  
     
            return $Practitioner_insurance_result;
      
        
    }
    
    // Returns a collection of certs which are not expired or due to expire
    
    //option 1 is todays date greater then or equal to cert start date and is todays date less then cert end date - add to array as not expired
    //option 2 is todays date greater then or equal to cert start date and is todays date less then cert end date and is one month from now greater then cert end date -  add to array of due to expire
    ////option 3 is cert end date less then today i.e. expired - do nothing
    //return collection
    public function SearchCertExpiry(){
        
        $member_no = $this->member_no;
        $cert_result = Practitioner_insurance::where('member',$member_no)
                                            ->get();
       
        // used to track any insurance cert type which is not expired 
        $insurace_certs_in_date_collection = collect([]);
        // if there are no results
        if(!$cert_result){
            
            return $insurace_certs_in_date_collection;
        }
            
        
        
        $todays_date = Carbon::now();
        $one_month_from_now= Carbon::now()->addMonths(1);
        
        
        
        foreach($cert_result as $current_cert){
            
            //option 1 is todays date greater then or equal to cert start date and is todays date less then cert end date - not expired
            if($todays_date->greaterThanOrEqualTo($current_cert->date_of_cert) && $todays_date->lessThanOrEqualTo($current_cert->end_date)){
                
                //option 2  and is one month from now greater then cert end date - due to expire
                if($one_month_from_now->greaterThanOrEqualTo($current_cert->end_date)){
                    
                    $insurace_certs_in_date_collection->put($current_cert->insurance_type,'due to expire');
                }
                //option 1 result
                else{
                    $insurace_certs_in_date_collection->put($current_cert->insurance_type,'not expired');
                }
            }
            
            
            
        }
        return $insurace_certs_in_date_collection;
    }
    
    
    
}