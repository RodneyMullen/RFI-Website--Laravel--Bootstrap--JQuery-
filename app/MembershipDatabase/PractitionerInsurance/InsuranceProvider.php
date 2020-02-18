<?php

/* 
 * Creates an instance of Insurance Provider
 */

namespace App\MembershipDatabase\PractitionerInsurance;

use App\MembershipDatabase\PractitionerInsurance\Insurance_provider;  // DB Model of Insurance Provider
use Illuminate\Http\Request;
use Carbon\Carbon;


class InsuranceProvider{
    
    /**
     * Constructor
     */
    function __construct(){
        
    }
    
    // returns a resultset of the Insurance Providers 
    public function retrieveInsuranceProviders(){
        
         $Insurance_providers_result = Insurance_provider::select('insurance_provider_name')
               ->orderBy('insurance_provider_name', 'asc') 
               ->get();
         
         return $Insurance_providers_result;
    }
    
    
    public function createInsuranceProvider(Request $request){
        
        try{
        $message = "Could not create the new Insurance Provider";
        
        // check if cert type already exists.  if not returh cert already exits message
        $Insurance_provider_result=$this->retrieveInsuranceProvider($request->insurancce_provider_name);
        if($Insurance_provider_result){
            
            $message="Insurance provider already exists, please choose another name";
            
        }
        else{
            
            $message=$this->UpdateInsuranceProvider($request);
            
        }
        return $message;
        }
        catch (Exception $ex) {
             return back()->withError($ex->getMessage())->withInput();
            //$message=withError($ex->getMessage())->withInput();
            //return $message;

        }
        
    }
    
    // checks the insurance provider database if already exists
    public function retrieveInsuranceProvider($insurance_provider_name){
        
        $Insurance_provider_result = Insurance_provider::where('insurance_provider_name',$insurance_provider_name)
                                   ->first();  
     
            return $Insurance_provider_result;
      
        
    }
    
    // takes in a request and created a new insurance provider and assignes values
    public function UpdateInsuranceProvider(Request $request){
        
        $Insurance_provider = new Insurance_provider();
        $message = "Insurance Provider could not be created.";
        
        if($request->insurance_provider_name){
            $Insurance_provider->insurance_provider_name = $request->insurance_provider_name;
        }
        else{
            $message =" Insurance provider name was missing";
        }
        
        
        
       $Insurance_provider->description = $request->insurance_provider_description;
       $Insurance_provider->created_at=Carbon::now();   
       $Insurance_provider->updated_at=Carbon::now();
       
       if(Strcmp($message,"Insurance Provider could not be created.")==0){
           $Insurance_provider->save();
           $message = "Insurance Provider has been added";
       }
       
       return $message;
    }
    
    
    // deletes record of insurance provider based on insurance provider name
    public function deleteInsuranceProvider($insurance_provider){
        $Insurance_provider_result=$this->retrieveInsuranceProvider($insurance_provider);
        $Insurance_provider_result->delete();
        $message="Insurance provider has been deleted";
        return $message;
        
        
    }
    
}