<?php

/* 
 * Class instance for Certification Type
 */

namespace App\MembershipDatabase\Certifications;

use Illuminate\Http\Request;
use App\MembershipDatabase\Certifications\Cert_type;
use Carbon\Carbon;  // used for current date


class CertificationType{
    
    
    function __constructor(){}
    
    
    // checks the cert type database if already exists
    public function retrieveCertType($cert_name){
        
        $Cert_type_result = Cert_type::where('certification',$cert_name)
                                   ->first();  
     
            return $Cert_type_result;
      
        
    }
    
    // returns a resultset of the cert types
    public function retrieveCertTypes(){
        
         $Cert_type_result = Cert_type::select('certification', 'expires', 'description')
               ->orderBy('certification', 'asc') 
               ->get();
         
         return $Cert_type_result;
    }
    
    public function createCertType(Request $request){
        
        try{
        $message = "Could not create the new Cert Type";
        
        // check if cert type already exists.  if not returh cert already exits message
        $Cert_result=$this->retrieveCertType($request->cert_name);
        if($Cert_result){
            
            $message="Cert already exists, please choose another name";
            
        }
        else{
            
            $message=$this->UpdateCertType($request);
            
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
    public function UpdateCertType(Request $request){
        
        $Cert_type = new Cert_type();
        $message = "Cert Type could not be created.";
        
        if($request->cert_name){
            $Cert_type->certification = $request->cert_name;
            
        }
        else{
            $message =" Cert type was missing";
        }
        
        
        // set cert expires to 1 if expires or 0 if does not
        if($request->does_expire==1){
             $Cert_type->expires=1;
        }
        else{
            $Cert_type->expires=0;
            
        }
       $Cert_type->description = $request->description;
       $Cert_type->created_at=Carbon::now();   
       $Cert_type->updated_at=Carbon::now();
       
       if(strcmp($message,"Cert Type could not be created.")==0){
           $Cert_type->save();
           
           $message = "Cert Type has been added";
       }
       
       return $message;
    }
    
    /**
     * Takes in a cert name, retrieves it and deletes it from the database
     * @param type $certname
     * @return string
     */
    public function deleteCertType($certname){
        $Cert_result=$this->retrieveCertType($certname);
        $Cert_result->delete();
        $message="Cert type has been deleted";
        return $message;
        
        
    }
    
}