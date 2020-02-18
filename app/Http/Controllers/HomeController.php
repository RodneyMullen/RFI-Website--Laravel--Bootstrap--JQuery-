<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\DashboardController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //$routename=Route::currentRouteName();
        $routename=$request->path();
        
        switch($routename){
            
            
            case 'webpagecreate'; return view(Route::currentRouteName());break;
            case 'webpageadmin'; return view(Route::currentRouteName());break;
                       
            
            
            
            //case 'practitionerlisting'; return PractitionerController:: ;break;
           // Default; $this->$route_split = explode("/",$routename);
                    $site = $route_split[0];
                    $page = $route_split[1];pageNameRequest($request, $routename);break;
            Default; 
                    
                    switch($site){
                        case 'webpageedit'; return view($site, compact('page')); break;
                       
                        case 'practitionerlisting'; return PractitionerController::checkPractitionerListingrRequest($page); break;
                        Default:return view('invalidpage'); break;
                        
                    }
               
                    
        }
        
     
    }
  
}
