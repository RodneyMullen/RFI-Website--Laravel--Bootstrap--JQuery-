<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MembershipDatabase\Members\Membership_type;
use Carbon\Carbon;

use App\MembershipDatabase\Members\MemberInstance;
use App\MembershipDatabase\Dashboards\MemberList;
use App\MembershipDatabase\Membership\MembershipType;
use App\MembershipDatabase\Membership\RFIMembership;
use App\MembershipDatabase\Certifications\CertificationInstance;
use App\MembershipDatabase\PractitionerInsurance\PractitionerInsurance;


class MembershipController extends Controller
{
    
    public $Member;  // global accessible Member instance
    public $Referee; // global accessible Refree instance
    public $MemberInstance; // global accessibale MemberInstance instance
    
   
   const DEFAULT_COUNTRY = 'Ireland';  // default country for create member form
    
   //list of counties for create and edit member form   
   const DEFAULT_LIST = array('Antrim','Armagh','Carlow','Cavan','Clare', 'Cork', 'Derry', 'Donegal', 'Down', 'Dublin', 'Fermanagh', 'Galway', 'Kerry', 'Kildare', 'Kilkenny', 'Laois', 'Leitrim', 'Limerick', 'Longford', 'Louth', 'Mayo', 'Meath', 'Monaghan', 'Offaly', 'Roscommon', 'Sligo', 'Tipperary', 'Tyrone','Waterford', 'Westmeath', 'Wexford', 'Wicklow'); 
   
   // gender selection for create and edit member form
   const GENDER = array("Female", "Male", "Prefer not to say");
    
   //profiles selection for users
    const PROFILES = array('Administrator', 'User');
   // constructor
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * creates new instance of memberInstance. , Retrieves next member number
     * send next number and form constants to the membercreate view
     */
    public function retreiveAddNewMemberForm(){
        
        $default_country=self::DEFAULT_COUNTRY;
        $county_list_array = self::DEFAULT_LIST;
        $gender_array = self::GENDER;
        $profile_array = self::PROFILES;
       
        $MemberInstance = new MemberInstance();
        $this->MemberInstance = $MemberInstance;
        $max_value = $MemberInstance->retrieveNextMembershipNo();
       // $create_member_form_variables = collect([['default_country'=>$default_country],['default_administrator'=>$default_administrator] , ['$max_value'=>$max_value]]);
        return view('membershipdatabase.members.membercreate',compact('default_country', 'county_list_array', 'gender_array', 'profile_array','max_value'));
        
        
        
    }
    
    /**
     * Retreives the constants requried for  Edit member form
     * this includes inforamtion on the member
     */
    public function retrieveEditMemberForm(Request $request){
        
        $default_country=self::DEFAULT_COUNTRY;
        $county_list_array = self::DEFAULT_LIST;
        $gender_array = self::GENDER;
        $profile_array = self::PROFILES;
        
        // find the member id from the page request
        $route_split = explode("/",$request->path());
        $page = $route_split[1];
        
        $MemberInstance = new MemberInstance($page);
        $this->MemberInstance = $MemberInstance;
        $Member_result = $MemberInstance->displayMemberById();
        
        $Referee_result =  $MemberInstance->retreiveReferee($Member_result->membership_no);
        $this->Referee = $Referee_result;
        
        $member_list_result = $this->retreiveMembersList();
        
        return view('membershipdatabase.members.memberedit',compact('default_country', 'county_list_array', 'gender_array', 'profile_array','Member_result','Referee_result','member_list_result'));
    }
    
    /**
     * Takes in a create member request form a form and sends to MemberInstance to create
     * @param Request $request
     */
    public function memberCreateRoute(Request $request){
        
        
        $MemberInstance = new MemberInstance();
        $this->MemberInstance=$MemberInstance;
            
            
         // check if member does not already exist
        if(!$MemberInstance->checkForMemberId($request->membership_no)){
            $message=$MemberInstance->createMember($request);
            
        }
        else{
                
            $message="Member already exists";
                
        }
        
       
        $member_list_result=$this->retreiveMembersList();
       
        return view('membershipdatabase.dashboards.viewmembers', compact('member_list_result','message'));
        
    }
    
    
    /**
     * Takes in a request and routes to either edit or delete
     * @param Request $request
     */
    public function editMemberRoute(Request $request){
        
        $member_no = $request->membership_no;
        
        $MemberInstance = new MemberInstance($member_no);
        $this->MemberInstance = $MemberInstance;
        $message ="Issue occured, please try again";
         
        if(strcmp($request->button, "Delete")==0){
        
            $message = $MemberInstance->deleteMember();
             $member_list_result= $this->retreiveMembersList();
             return view('membershipdatabase.dashboards.viewmembers', compact('member_list_result','message'));
            
        }
        
        elseif(strcmp($request->submission_type, "edit_member")==0){
            
            $message=$MemberInstance->editMember($request);
            if(strcmp($message,"Member was edited")!=0)
            {
                
                return view('membershipdatabase.members.memberedit', compact('message'));
                 
            }
            else{
                
               $member_list_result= $this->retreiveMembersList();
                return view('membershipdatabase.dashboards.viewmembers', compact('member_list_result','message'));
            }
                
                    
                
            
            
        }
        
        
    }
    
    /*
     * retreives the list of membership types and send to the membershiptypes form
     */
    public function addMembershipTypesForm(){
        
        $MembershipType = new MembershipType();
        
        $MembershipTypeList = $MembershipType->retrieveMembershipTypes();  // retrieves list of cert types
        
        return view('membershipdatabase.membership.membershiptypes', compact('MembershipTypeList'));
    }
    
    /**
     * retrieves the memmbers list for the view members dashboard
     * @param type $message
     * @return type
     */
    private function retreiveMembersList(){
        
        $MemberList = new MemberList();
        $member_list_result = $MemberList->displayMemberListing();
        
        return  $member_list_result;
      
    }
    
    
    
        
    //taked in a request from membershiptype blade and routes to add or delete membership type
    public function membershipTypeRoute(Request $request){
        
        $MembershipType = new MembershipType();
        if ($request->save_membership_type_button){
            $message=$MembershipType->createMembershiptype($request);
            
        }
        else{
            
            $message=$MembershipType->deleteMembershipType($request->delete_membership_type_button);
        }
        
        $MembershipTypeList = $MembershipType->retrieveMembershipTypes();  // retrieves list of cert types
        
        return view('membershipdatabase.membership.membershiptypes', compact('MembershipTypeList','message'));
        
    }
    
   
   
   
   
   /*
    * Takes in a request and retrieves the following
    * Member inforation, membershiptypes list, member certs. Checks on reiki level 1, reiki practitioner module
    * introduction to A&P, First Aid and Insurance certs.  Retreives RFI membership for the member 
    */
   public function addRFIMembershipForm(Request $request){
       
       $route_split = explode("/",$request->path());
       $page = $route_split[1];
       $RFIMembership = new RFIMembership($page);
       $MemberInstance = new MemberInstance($page);
       $Member_result =  $MemberInstance->displayMemberById();
       
       $MembershipType = new MembershipType();
       $Membership_types = $MembershipType->retrieveMembershipTypes();
        
       $CertificationInstance = new CertificationInstance($page);
       // retreive list of all member certificates frmo member number
       $MemberCertificates = $CertificationInstance->retreiveCertbyMember();

        // the following returns strings, expired, due to expired or not expired
        $is_reiki_level1_cert = $CertificationInstance->searchForCert("Reiki Level 1");
        $is_reiki_practitioner_cert = $CertificationInstance->searchForCert("Reiki Practictioner Module");
        $is_anp_cert = $CertificationInstance->searchForCert("Introduction to Anatomy & Physiology");
        $is_firsr_aid_cert = $CertificationInstance->IsCertExpired("First Aid");

        $PractitionerInsurance = new PractitionerInsurance($page);    
        // returns a collection of insurance types which are due to expired or not expired
        $insurance_cert_collection = $PractitionerInsurance->SearchCertExpiry();
       
        // returns a collection of all the rfi membership based on member id
        $Rfi_membership_results= $RFIMembership->retrieveRfiMembershipByMember();
        
        return view('membershipdatabase.membership.addrfimembership', compact('page','Member_result','Membership_types','MemberCertificates','is_reiki_level1_cert','is_reiki_practitioner_cert','is_anp_cert','is_firsr_aid_cert','insurance_cert_collection','Rfi_membership_results'));
       
   }
   
    
   
   // Takes in a request from RFI Membership form
   // send to update RFI membership if a new membership
   // send to delete RFI Membership if to delete membership
   public function routeRFIMembership(Request $request){
       
       $page = $request->membership_no;
       $RFIMembership = new RFIMembership($request->membership_no);
       // create membership
       if($request->create_rfi_membership_button){
           $message=$RFIMembership->updateRFIMembership($request);
           
           
       }
       // delete membership
       else if($request->delete_rfi_membership_button){
           
           $message=$RFIMembership->deleteRFIMembership($request->delete_rfi_membership_button);
       }
        $MemberInstance = new MemberInstance($page);
       $Member_result =  $MemberInstance->displayMemberById();
       
       $MembershipType = new MembershipType();
       $Membership_types = $MembershipType->retrieveMembershipTypes();
        
       $CertificationInstance = new CertificationInstance($page);
       // retreive list of all member certificates frmo member number
       $MemberCertificates = $CertificationInstance->retreiveCertbyMember();

        // the following returns strings, expired, due to expired or not expired
        $is_reiki_level1_cert = $CertificationInstance->searchForCert("Reiki Level 1");
        $is_reiki_practitioner_cert = $CertificationInstance->searchForCert("Reiki Practictioner Module");
        $is_anp_cert = $CertificationInstance->searchForCert("Introduction to Anatomy & Physiology");
        $is_firsr_aid_cert = $CertificationInstance->IsCertExpired("First Aid");

        $PractitionerInsurance = new PractitionerInsurance($page);    
        // returns a collection of insurance types which are due to expired or not expired
        $insurance_cert_collection = $PractitionerInsurance->SearchCertExpiry();
       
        // returns a collection of all the rfi membership based on member id
        $Rfi_membership_results= $RFIMembership->retrieveRfiMembershipByMember();
        return view('membershipdatabase.membership.addrfimembership', compact('page','Member_result','Membership_types','MemberCertificates','is_reiki_level1_cert','is_reiki_practitioner_cert','is_anp_cert','is_firsr_aid_cert','insurance_cert_collection','Rfi_membership_results','message'));
          
      
       
       
   }
   
   
   
   
  
}
