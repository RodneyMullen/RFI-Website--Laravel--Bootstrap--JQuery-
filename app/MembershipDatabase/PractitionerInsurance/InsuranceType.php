<?php

/* 
 * Creates an instance of Insurance Type
 */


namespace App\MembershipDatabase\PractitionerInsurance;

use App\MembershipDatabase\PractitionerInsurance\Insurance_type; // DB Model of Insurance_type
use Illuminate\Http\Request;
use Carbon\Carbon;


class InsuranceType{
    
    /**
     * constructor
     */
    function __construct(){}
    
    // checks the cert type database if already exists
    private function retrieveInsuranceType($insurance_type){
        
        $Insurance_type_result = Insurance_type::where('insurance_type',$insurance_type)
                                   ->first();  
     
            return $Insurance_type_result;
      
        
    }
    
     // returns a resultset of the insurance types
    public  function retrieveInsuranceTypes(){
        
         $Insurance_type_result = Insurance_type::select('insurance_type', 'description')
               ->orderBy('insurance_type', 'asc') 
               ->get();
         
         return $Insurance_type_result;
    }
    
    public function createInsuranceType(Request $request){
        
        try{
        $message = "Could not create the new Insurance Type";
        
        // check if cert type already exists.  if not returh cert already exits message
        $Insurance_result=$this->retrieveInsuranceType($request->insurance_type);
        if($Insurance_result){
            
            $message="Insurance type already exists, please choose another name";
            
        }
        else{
            
            $message=$this->UpdateInsuranceType($request);
            
        }
        return $message;
        }
        catch (Exception $ex) {
             return back()->withError($ex->getMessage())->withInput();
            //$message=withError($ex->getMessage())->withInput();
            //return $message;

        }
        
    }
    
    // takes in a request and created a new cert and assignes values
    private function UpdateInsuranceType(Request $request){
        
        $Insurance_type = new Insurance_type();
        $message = "Insurance Type could not be created.";
        
        if($request->insurance_type){
            $Insurance_type->insurance_type = $request->insurance_type;
        }
        else{
            $message =" Insurance type was missing";
        }
        
        
        
       $Insurance_type->description = $request->description;
       $Insurance_type->created_at=Carbon::now();   
       $Insurance_type->updated_at=Carbon::now();
       
       if(Strcmp($message,"Insurance Type could not be created.")==0){
           $Insurance_type->save();
           $message = "Insurance Type has been added";
       }
       
       return $message;
    }
    
    // deletes record of insurance type based on insurance type name
    public function deleteInsuranceType($insurance_type){
        
        $Insurance_result=$this->retrieveInsuranceType($insurance_type);
        $Insurance_result->delete();
        $message="Insurance type has been deleted";
        return $message;
        
        
    }
}

