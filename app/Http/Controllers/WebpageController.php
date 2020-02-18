<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Webpage\WebpageInstance;
use App\Webpage\Header;
use App\Webpage\Footer;

use Carbon\Carbon;



class WebpageController extends Controller
{
       
   
     
    
    /**
     * takes in a page name and returns its webpage details from the database
     *
     * @param  \App\Webpage  $webpage
     * @return \Illuminate\Http\Response
     */
    public function show($pagename)
    {
        $WebpageInstance = new WebpageInstance($pagename);
        
        $Webpage = $WebpageInstance->retreivePage();
        
        
        
         if($Webpage)
         {
             return view('webpage.index',compact('Webpage'));
         }
         else
         {
             return view('webpage.invalidpage',compact('Webpage'));
         }
             
    }
    /**
     * Creates a new instance of home webpage and retrieves the content
     * @return type
     */
   public function showHome()
   {
       $WebpageInstance = new WebpageInstance('home');
       $Webpage = $WebpageInstance->retreivePage();
       $Header = new Header();
        $header_content=$Header->retrieveHeader(); 
        $Footer = new Footer();
        $footer_content=Footer::retrieveFooter();
       if(!$Webpage){
            
            return view('webpage.invalidpage',compact('Webpage','header_content','footer_content'));
        } 
        else{
            return view('webpage.index',compact('Webpage','header_content','footer_content'));
        }
       
   }
   
}
