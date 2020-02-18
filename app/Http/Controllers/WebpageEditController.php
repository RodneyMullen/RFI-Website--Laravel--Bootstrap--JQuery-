<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Webpage\WebpageInstance;

class WebpageEditController extends Controller
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
     * retreives a list of webpages and returns the webpage admin
     */
    public function webpageDashboard(){
        
        $WebpageInstance = new WebpageInstance();
        
        $WebpageList = $WebpageInstance->displayWebpageListing();
        
        return view('webpage.webpageadmin', compact('WebpageList'));
        
    }
    
    /**
     * retries list of webpages list and sends to the webpagecreate view
     */
    public function webpageCreateForm(){
        $WebpageInstance = new WebpageInstance();
        
        $WebpageList = $WebpageInstance->displayWebpageListing();
        
        return view('webpage.webpagecreate', compact('WebpageList'));
        
    }
    
    /**
     * Takes in a request to create a new webpage, and sends to Webpage Instance
     * Returns to the webpage admin dashboard view
     * @param Request $request
     */
    public function createWebpage(Request $request){
        
        $WebpageInstance = new WebpageInstance($request->webpagename);
        
           $message=$WebpageInstance->store($request);
        $WebpageList = $WebpageInstance->displayWebpageListing();
        
        return view('webpage.webpageadmin',compact('message','WebpageList'));
        
    }
    
   
    
    /**
     * Retrieve WebpageList and webpage content
     * sends contents to webpageedit view
     * @param Request $request
     */
    public function webpageEditForm(Request $request){
        
        
        $route_split = explode("/",$request->path());
        $page = $route_split[1];
        
        $WebpageInstance = new WebpageInstance($page);
        $WebpageList = $WebpageInstance->displayWebpageListing();
             
        $WebpageContent = $WebpageInstance->displayWebpageByName($page);
        
        return view('webpage.webpageedit',compact('WebpageList','WebpageContent'));
        
    }
    
    /*
     * Takes in a request and saves the content of the current webpage
     */
    
    public function editWebpage(Request $request){
         
        $WebpageInstance = new WebpageInstance($request->webpagename);
        if($request->button =="Delete")
        {
            $message=$WebpageInstance->delete($request);
            
        }
        else
        {
           $message=$WebpageInstance->store($request);
        }
        $WebpageList = $WebpageInstance->displayWebpageListing();
        return view('webpage.webpageadmin',compact('message','WebpageList'));
        
    }
    
}
