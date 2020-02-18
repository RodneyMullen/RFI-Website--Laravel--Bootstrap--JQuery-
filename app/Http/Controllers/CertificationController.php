<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MembershipDatabase\Certifications\Cert_type;
use App\MembershipDatabase\Certifications\Certification;
use Carbon\Carbon;  // used for current date
use App\MembershipDatabase\Certifications\CertificationType;
use App\MembershipDatabase\Certifications\CertificationInstance;
use App\MembershipDatabase\Members\MemberInstance;

class CertificationController extends Controller
{
    
    public $CertificationInstance;
    /**
     * Constructor, routes through middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * retrieves list of cert types
     * returns to view of the cert form with cert types
     */
    public function certTypeForm(){
        
        $CertificationType = new CertificationType();
        $CertTypeList = $CertificationType->retrieveCertTypes();
        
        return view('membershipdatabase.certifications.certtypes', compact('CertTypeList'));
        
        
    }
    
    /**
     * Takes in a a request and either edits or deletes cert type
     * @param Request $request
     */
    public function certTypeRoute(Request $request){
        
        $CertificationType = new CertificationType();
         // Create new cert type and returns messge to the same page
        if($request->save_cert_type_button){
            
            $message = $CertificationType->createCertType($request);
            
            
        }
        // delete cert
        else if($request->delete_cert_type_button){
            
            $message = $CertificationType->deleteCertType($request->delete_cert_type_button);
            
            
        }
        $CertTypeList = $CertificationType->retrieveCertTypes();
        return view('membershipdatabase.certifications.certtypes', compact('CertTypeList','message'));
    }
    
    
    /**
     * retreives list of cert types, member result and attached certs
     * returns a form to add or delete certs.
     */
    public function addCertificiationForm(Request $request){
        
         // find the member id from the page request
        $route_split = explode("/",$request->path());
        $page = $route_split[1];
        
        $CertificationInstance = new CertificationInstance($page);
        $this->CertificationInstance = $CertificationInstance;
        $MemberCertificates = $CertificationInstance->retreiveCertbyMember();
        
        $CertificationType = new CertificationType();
        $CertTypeList = $CertificationType->retrieveCertTypes(); 
        
        $MemberInstance = new MemberInstance($page);
        $Member_result =  $MemberInstance->displayMemberById();
        
        
        return view('membershipdatabase.certifications.addcertifications',compact('CertTypeList','Member_result','MemberCertificates','page'));
        
    }
    
    /**
     * Takes in a a request and routes to either add or delete a certification
     * @param Request $request
     * 
     */
    public function certificationRoute(Request $request){
        
        $message = "Error occured, please try again";
        $CertificationInstance = new CertificationInstance($request->membership_no);
        $page=$CertificationInstance->getMemberNo();
        if($request->create_cert_button){
            
            $message = $CertificationInstance->createCertification($request);
            
                       
        }
        //delete certifcate, delte certificaiton button is the id of the cert, not of the member
        else if($request->delete_certificate_button){
            
            $message = $CertificationInstance->deleteCert($request->delete_certificate_button);
        }
        
        $MemberCertificates = $CertificationInstance->retreiveCertbyMember();
        
        $CertificationType = new CertificationType();
        $CertTypeList = $CertificationType->retrieveCertTypes(); 
        
        $MemberInstance = new MemberInstance($page);
        $Member_result =  $MemberInstance->displayMemberById();;
        return view('membershipdatabase.certifications.addcertifications',compact('CertTypeList','Member_result','MemberCertificates','message','page'));
    }
        
        
    
    
   
    
   
}
