<?php

/* 
 * Class to create instance of a Member list and to output the results
 */

namespace App\MembershipDatabase\Dashboards;

use App\MembershipDatabase\Members\Member; // Member DB table

class MemberList{
    
    
    function __construct(){
    }
    

    /**
     * Accesses the member database and returns all records
     * @return type
     * 
     */
    public function displayMemberListing(){
       
       
       $Member_result = Member::select('membership_no', 'name', 'surname', 'notes')
               ->orderBy('name', 'asc') 
               ->get();
       
        return $Member_result;
    }
        
    
        
}

