<?php
//  createa a footer object. Allows the creation of a webpage footer
//  Allows the retreival of the footer
namespace App\Http\Controllers;
use App\Http\Controllers\WebpageController;

use App\HtmlSnippet;


class Footer extends Controller
{
    //string of top of html code
     
    
    var $WebpageList; // public accessible object
    var $header_html;
//construcutor
    public function Footer()
    {
        
    }
    
   /*Called during creation or editing of webpage. takes in all the website information for name, parents and children
    * generates navigation bar code for each element, and its children until done.  Starts at Home page
    * root pages or connected to home goes across the top of the screen. the remainder are menu elements 
    */ 
    public function generateFooter()
    {
        
        global $header_html, $WebpageList;
       $header_html= '<ul>';
        // retrieve all webpages with name, parents, children in a collection
        $WebpageList = WebpageController::displayWebpageFamily();
        $currentpage = $WebpageList->firstWhere('webpage_name','home');
        $this->assignNavBarHTML($currentpage);
        $header_html.='</ul>';
                //</div>
        // </div>';  // close the nav bar thml
        $HtmlSnippet=$this->displayHTMLSnippetByType('Footer');
        $HtmlSnippet->content=$header_html;
        $HtmlSnippet->save();
        
       
    }          
        // Function creates valid html code and appends the new html code to the string
// takes in a string of the html code. checks if the page is home - assigns the home html and appends the string
// If the page has children and parent of home, creates a new undordered list, assigns the page as the first item 
// if the page has children and parent is not home, creates a new undordered sub list, assigns the page as the first item
// if the page has no children, create a menu item
    public function assignNavBarHTML($currentpage){
    
        global $header_html, $WebpageList; 
        $page_name =  $currentpage->webpage_name;
        $page_url =url('/'.$page_name);
         // if the page is the home page, create home page nav bar item and cycle through childred
         if(strcmp($page_name, 'home')==0){
             $header_html.='<li>
                                <a href = "'.$page_url.'">Home
					
                                </a>
                            </li>';
            $children_list = collect(json_decode($currentpage->child_collection,true));
             foreach($children_list as $child){
                
                $this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child));
             
             }
						
           
         }
         // if current page has as parent of home
       else if(strcmp($currentpage->parent, 'home')==0){
             
           // if no children
             if(!$currentpage->child_collection){
                 $header_html.='<li>
                                    <a href = "'.$page_url.'">'.ucfirst($page_name).'
					
                                    </a>
                                </li>';
             }
             // if there are children, apply drop down menu with first item name of page
             else{
                    $header_html.= ucfirst($page_name).'<ul>
                                        <li>
                                            <a href = "'.$page_url.'">'.ucfirst($page_name).'
                                           </a>
                                        </li>';
              
                   $children_list = collect(json_decode($currentpage->child_collection,true));
                    foreach($children_list as $child){
            
                         $this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child));
             
                    }
                    $header_html.='     </ul>';
                         
 
                  
             }
             
         }
        // if page is parent which is not home
         else{
             // if no children
             if(!$currentpage->child_collection){
                 $header_html.='<li>
                                    <a href = "'.$page_url.'">'.ucfirst($page_name).'
                                   </a>
                                </li>';
             }
             // if there are children
             else{
                 $header_html.=ucfirst($page_name).'<ul>
                                    <li>
                                        <a href="'.$page_url.'">'.ucfirst($page_name).'
                                        </a>
                                    </li>';
                $children_list = collect(json_decode($currentpage->child_collection,true));
                 foreach($children_list as $child){
            
                         $this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child));
             
                    }
                 
                 $header_html.='</ul>';
                                    
             }
        }
    
    }
    // takes in a type and returns the HTMLSnippet details    
    public static function displayHTMLSnippetByType($type)
    {
        
           
        $HtmlSnippet = HTMLSnippet::where('type',$type)
                                   ->first(); 
        if(!$HtmlSnippet){
            $HtmlSnippet = new HtmlSnippet();
            $HtmlSnippet->type= 'Footer';
        }       
    
               
        return $HtmlSnippet;
    }  
    
    //accesses the HtmlSnippet database and retreives the string of the footer
    public static function retrieveFooter(){
        $HtmlSnippet = HTMLSnippet::where('type','Footer')
                                   ->first(); 
        
        if(!$HtmlSnippet)
        {
            return "";
        }
        return $HtmlSnippet->content;
    }
    
}
