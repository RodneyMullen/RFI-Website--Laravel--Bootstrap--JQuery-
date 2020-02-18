<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AppMembershipDatabase\PractitionerInsurance\Insurance_type; //insurance type db model
use AppMembershipDatabase\PractitionerInsurance\Insurance_provider; //insurance provider db model
use App\MembershipDatabasezPractitionerInsurance\Practitioner_insurance; //Practitioner insurance db model
use App\Http\Controllers\MembershipController;  //access to membershipcontroller
use App\MembershipDatabase\PractitionerInsurance\InsuranceType;
use App\MembershipDatabase\PractitionerInsurance\InsuranceProvider;
use App\MembershipDatabase\PractitionerInsurance\PractitionerInsurance;
use App\MembershipDatabase\Members\MemberInstance;
use Carbon\Carbon;  // used for current date



class InsuranceController extends Controller
{
    // constructor
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /*
     * retrieves list of insurance types and outputs to the insurancetypes view
     */
    public function insuranceTypeForm(){
        
        $InsuranceType = new InsuranceType();
        $InsuranceTypeList = $InsuranceType->retrieveInsuranceTypes();  // retrieves list of cert types
        
        return view('membershipdatabase.practitionerinsurance.insurancetypes', compact('InsuranceTypeList'));
    }
    
   
    /**
     * Takes in a request and routes request to add or delete insurance type
     * @param Request $request
     */
    public function InsuranceTypeRoute(Request $request){
        
        $InsuranceType = new InsuranceType();
        // Create new insurance type and returns messge to the same page
        if($request->save_insurance_type_button){
            
            $message = $InsuranceType->createInsuranceType($request);
            
            
        }
        // delete insurance type
        else if($request->delete_insurance_type_button){
            
            $message = $InsuranceType->deleteInsuranceType($request->delete_insurance_type_button);
            
            
        }
        $InsuranceTypeList = $InsuranceType->retrieveInsuranceTypes();  // retrieves list of cert types
        return view('membershipdatabase.practitionerinsurance.insurancetypes', compact('InsuranceTypeList','message'));
    }
    
    /*
     * retrieves list of insurance providers and outputs to insuranceproviders view
     */
    public function insuranceProvidersForm(){
        
        $InsuranceProvider = new InsuranceProvider();
        $InsuranceProvider_list = $InsuranceProvider->retrieveInsuranceProviders();  // retrieves list of insurance providers
        
        return view('membershipdatabase.practitionerinsurance.insuranceproviders', compact('InsuranceProvider_list'));
    }
    
    /*
     * Takes in a request and routes to either add or delete Insurance Providers, return view to insuranceprovider
     */
    public function InsuranceProvidersRoute(Request $request){
        
        $InsuranceProvider = new InsuranceProvider();
          // save insurance provider
        if($request->save_insurance_provider_button){
            
            $message = $InsuranceProvider->createInsuranceProvider($request);
            
            
        }
        // delete insurance provider
        else if($request->delete_insurance_provider_button){
            
            $message = $InsuranceProvider->deleteInsuranceProvider($request->delete_insurance_provider_button);
            
            
        }
        $InsuranceProvider_list = $InsuranceProvider->retrieveInsuranceProviders();  // retrieves list of insurance providers
        
        return view('membershipdatabase.practitionerinsurance.insuranceproviders', compact('InsuranceProvider_list','message'));
        
    }
    
    /*
     * retrieves list of insurance types, member information, insurance providers and member practitioner insurance
     */
    public function addPractitionerInsuranceForm(Request $request){
        
         // find the member id from the page request
        $route_split = explode("/",$request->path());
        $page = $route_split[1];
        
        $PractitionerInsurance = new PractitionerInsurance($page);
        $PractitionerInsurance_list = $PractitionerInsurance->retrievePractitionerInsurances();  //retreives list of 
        // practitioner insurances
        
        $InsuranceType = new InsuranceType();
        $InsuranceTypeList = $InsuranceType->retrieveInsuranceTypes();  // retrieves list of insurance types
        $MemberInstance = new MemberInstance($page);
        $Member_result = $MemberInstance->displayMemberById();
        
        $InsuranceProvider = new InsuranceProvider();
        $InsuranceProviders_list = $InsuranceProvider->retrieveInsuranceProviders();  // retrieves list of insurance providers


        return view('membershipdatabase.practitionerinsurance.addpractitionerinsurance', compact('page','PractitionerInsurance_list','InsuranceTypeList','Member_result','InsuranceProviders_list'));
        
    }
    
    /*
     * Takes in a request and routes to add or delete pracitioner insurance
     */
    public function practitionerInsuranceRoute(Request $request){
        
        $page=$request->membership_no;
        $MemberInstance = new MemberInstance($page);
        $Member_result = $MemberInstance->displayMemberById();
        
        
        $PractitionerInsurance = new PractitionerInsurance($request->membership_no);
        $page=$request->membership_no;
        // create pracitioner insurance
        if($request->create_practitioner_insurance_button){
            
            $message = $PractitionerInsurance->createPractitionerInsurance($request, $Member_result);
            
                        
            
            
        }
        // create pracitioner insurance
        else if($request->delete_practitioner_insurance_button){
            
            $message = $PractitionerInsurance->deletePractitionerInsurance($request->delete_practitioner_insurance_button);
            
            
        }
        $PractitionerInsurance_list = $PractitionerInsurance->retrievePractitionerInsurances();  //retreives list of 
        // practitioner insurances
        
        $InsuranceType = new InsuranceType();
        $InsuranceTypeList = $InsuranceType->retrieveInsuranceTypes();  // retrieves list of insurance types
        $MemberInstance = new MemberInstance($page);
        $Member_result = $MemberInstance->displayMemberById();
        $InsuranceProvider = new InsuranceProvider();
        $InsuranceProviders_list = $InsuranceProvider->retrieveInsuranceProviders();  // retrieves list of insurance providers 
        
        
        
        return view('membershipdatabase.practitionerinsurance.addpractitionerinsurance', compact('page','PractitionerInsurance_list','InsuranceTypeList','Member_result','InsuranceProviders_list','message'));
        
    }
    
    
    
    
}
