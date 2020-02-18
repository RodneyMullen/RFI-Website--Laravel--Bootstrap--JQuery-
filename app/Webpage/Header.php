<?php
//  createa a header object. Allows the creation of a webpage header and navigation bar
//  Allows the retreival of the header
namespace App\Webpage;
use Illuminate\Http\Request;
use App\Webpage\HtmlSnippet;


class Header
{
    //string of top of html code
     
    
    public $WebpageList; // public accessible object
    
//construcutor
    public function Header()
    {
        
    }
    
   /*Called during creation or editing of webpage. takes in all the website information for name, parents and children
    * generates navigation bar code for each element, and its children until done.  Starts at Home page
    * root pages or connected to home goes across the top of the screen. the remainder are menu elements 
    */ 
    public function generateHeader($WebpageList)
    {
        
       
       $header_html=
		//'<nav class = "navbar navbar-expand-sm navbar-rfi navbar-dark">
                       //     <a class = "navbar-brand" href = "#">
			//	<img src="storage/img/RFI-logo-v2.png" width="50" height="50">
                       //    </a>
                          
                           ' <button class = "navbar-toggler" type = "button" data-toggle = "collapse" 
                                data-target = "#navbarNavDropdown" aria-controls = "navbarNavDropdown" 
                                aria-expanded = "false" aria-label = "Toggle navigation">
                                   <span class="navbar-toggler-icon"></span>
                            </button>
            
                            <div class = "collapse navbar-collapse" id = "navbarNavDropdown">
				<ul class = "navbar-nav">';
        // retrieve all webpages with name, parents, children in a collection
        
        $this->WebpageList = $WebpageList;
        $currentpage = $WebpageList->firstWhere('webpage_name','home');
        
        $header_html=$this->assignNavBarHTML($currentpage,$header_html);
        $header_html.='         </ul>
                             </div>
                         </nav>';
                //</div>
        // </div>';  // close the nav bar thml
        $HtmlSnippet=$this->displayHTMLSnippetByType('Header');
        $HtmlSnippet->content=$header_html;
        $HtmlSnippet->save();
        
       
    }          
        // Function creates valid nav bar html code and appends the new html code to the string
// takes in a string of the html code. checks if the page is home - assigns the home html and appends the string
// If the page has children and parent of home, creates a dropdown menu, assigns the page as the first item 
// if the page has children and parent is not home, creates a dropdown submenu, assigns the page as the first item
// if the page has no children, create a menu item
    public function assignNavBarHTML($currentpage,$header_html){
    
        
        $WebpageList = $this->WebpageList;
           
       
        $page_name =  $currentpage->webpage_name;
        $page_url =url('/'.$page_name);
         // if the page is the home page, create home page nav bar item and cycle through childred
         if(strcmp($page_name, 'home')==0){
             $header_html.='<li class = "nav-item active">
                                <a class = "nav-link" href = "'.$page_url.'">Home
					<span class = "sr-only">(current)</span>
                                </a>
                            </li>';
            $children_list = collect(json_decode($currentpage->child_collection,true));
             foreach($children_list as $child){
                
                $header_html=$this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child),$header_html);
             
             }
						
           
         }
         // if current page has as parent of home
       else if(strcmp($currentpage->parent, 'home')==0){
             
           // if no children
             if(!$currentpage->child_collection){
                 $header_html.='<li class = "nav-item">
                                    <a class = "nav-link" href = "'.$page_url.'">'.ucfirst($page_name).'
					<span class = "sr-only">(current)</span>
                                    </a>
                                </li>';
             }
             // if there are children, apply drop down menu with first item name of page
             else{
                    $header_html.='<li class = "nav-item dropdown">
					<a class = "nav-link dropdown-toggle" href = "'.$page_url.'" 
                                        id = "navbarDropdownMenuLink" role = "button" data-toggle = "dropdown" 
                                        aria-haspopup = "true" aria-expanded = "false">'.ucfirst($page_name).'
                                        </a>
                                        
                                        <ul class = "dropdown-menu" aria-labelledby = "navbarDropdownMenuLink">
                                           <li> 
                                                <a class = "dropdown-item" href = "'.$page_url.'">'.ucfirst($page_name).''
                            . '                 </a>'
                            . '            </li>';
              
                   $children_list = collect(json_decode($currentpage->child_collection,true));
                    foreach($children_list as $child){
            
                         $header_html=$this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child),$header_html);
             
                    }
                    $header_html.='     </ul>
                                    </li>';
                         
 
                  
             }
             
         }
        // if page is parent which is not home
         else{
             // if no children
             if(!$currentpage->child_collection){
                 $header_html.='<li>
                                    <a class = "dropdown-item" href = "'.$page_url.'">'.ucfirst($page_name).'
                                   </a>
                                </li>';
             }
             // if there are children
             else{
                 $header_html.='<li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="'.$page_url.'">'.ucfirst($page_name).'
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="'.$page_url.'">'.ucfirst($page_name).'
                                            </a>
                                        </li>';
                $children_list = collect(json_decode($currentpage->child_collection,true));
                 foreach($children_list as $child){
            
                         $header_html=$this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child),$header_html);
             
                    }
                 
                 $header_html.='    </ul>
                                </li>';
                                    
             }
        }
        return $header_html;
    
    }
    // takes in a type and returns the HTMLSnippet details    
    private function displayHTMLSnippetByType($type)
    {
        
           
        $HtmlSnippet = HTMLSnippet::where('type',$type)
                                   ->first(); 
        if(!$HtmlSnippet){
            $HtmlSnippet = new HtmlSnippet();
            $HtmlSnippet->type= 'Header';
        }       
    
               
        return $HtmlSnippet;
    }  
    
    //accesses the HtmlSnippet database and retreives the string of the header
    public function retrieveHeader(){
        $HtmlSnippet = HTMLSnippet::where('type','Header')
                                   ->first(); 
        
        if(!$HtmlSnippet)
        {
            return "";
        }
        return $HtmlSnippet->content;
    }
    
}
