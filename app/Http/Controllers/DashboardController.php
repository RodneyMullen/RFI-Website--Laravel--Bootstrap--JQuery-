<?php

/**
 * Used to route and requests for the Membership Dashboard or list requests
 */

namespace App\Http\Controllers;



use Illuminate\Http\Request;
//use App\MembershipDatabase\Dashboards\MembershipDashboard;
use App\MembershipDatabase\Dashboards\MembershipDashboard;
use App\MembershipDatabase\Dashboards\MemberList;


class DashboardController extends Controller
{
    
    /**
     * Constructor, routes through middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Creates a new instance of MembershipDashboard and returns view.
     * to be edited
     */
    public function retreiveMembershipDashboard(){
        
        $MembershipDashboard = new MembershipDashboard();
        return view('membershipdatabase.dashboards.memberdashboard');
        
        
    }
    
    /**
     * Creates a new instance of Memberlist, retreieves the list of members and sends
     * to the viewmembers view
     */
    public static function retrieveMemberList(){
       
        $MemberList = new MemberList();
        $member_list_result = $MemberList->displayMemberListing();
        
        return view('membershipdatabase.dashboards.viewmembers', compact('member_list_result'));
        
    }
        
    
}
