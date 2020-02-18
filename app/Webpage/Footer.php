<?php
//  createa a footer object. Allows the creation of a webpage footer
//  Allows the retreival of the footer
namespace App\Webpage;


use App\Webpage\HtmlSnippet;


class Footer
{
    //string of top of html code
     
    
    public $WebpageList; // public accessible object
    
//construcutor
    public function Footer()
    {
        
    }
    
   /*Called during creation or editing of webpage. takes in all the website information for name, parents and children
    * generates navigation bar code for each element, and its children until done.  Starts at Home page
    * root pages or connected to home goes across the top of the screen. the remainder are menu elements 
    */ 
    public function generateFooter($WebpageList)
    {
        
      
       $footer_html= '<ul>';
        // retrieve all webpages with name, parents, children in a collection
        $this->WebpageList = $WebpageList;
        $currentpage = $WebpageList->firstWhere('webpage_name','home');
        $footer_html=$this->assignNavBarHTML($currentpage,$footer_html);
        $footer_html.='</ul>';
        
                //</div>
        // </div>';  // close the nav bar thml
        $HtmlSnippet=$this->displayHTMLSnippetByType('Footer');
        $HtmlSnippet->content=$footer_html;
        $HtmlSnippet->save();
        
        
       
    }          
        // Function creates valid html code and appends the new html code to the string
// takes in a string of the html code. checks if the page is home - assigns the home html and appends the string
// If the page has children and parent of home, creates a new undordered list, assigns the page as the first item 
// if the page has children and parent is not home, creates a new undordered sub list, assigns the page as the first item
// if the page has no children, create a menu item
    public function assignNavBarHTML($currentpage,$footer_html){
    
        
        
        $WebpageList = $this->WebpageList;
        $page_name =  $currentpage->webpage_name;
        $page_url =url('/'.$page_name);
         // if the page is the home page, create home page nav bar item and cycle through childred
         if(strcmp($page_name, 'home')==0){
             $footer_html.='<li>
                                <a href = "'.$page_url.'">Home
					
                                </a>
                            </li>';
            $children_list = collect(json_decode($currentpage->child_collection,true));
             foreach($children_list as $child){
                
                $footer_html=$this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child),$footer_html);
             
             }
						
           
         }
         // if current page has as parent of home
       else if(strcmp($currentpage->parent, 'home')==0){
             
           // if no children
             if(!$currentpage->child_collection){
                 $footer_html.='<li>
                                    <a href = "'.$page_url.'">'.ucfirst($page_name).'
					
                                    </a>
                                </li>';
             }
             // if there are children, apply drop down menu with first item name of page
             else{
                    $footer_html.= ucfirst($page_name).'<ul>
                                        <li>
                                            <a href = "'.$page_url.'">'.ucfirst($page_name).'
                                           </a>
                                        </li>';
              
                   $children_list = collect(json_decode($currentpage->child_collection,true));
                    foreach($children_list as $child){
            
                         $this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child),$footer_html);
             
                    }
                    $footer_html.='     </ul>';
                         
 
                  
             }
             
         }
        // if page is parent which is not home
         else{
             // if no children
             if(!$currentpage->child_collection){
                 $footer_html.='<li>
                                    <a href = "'.$page_url.'">'.ucfirst($page_name).'
                                   </a>
                                </li>';
             }
             // if there are children
             else{
                 $footer_html.=ucfirst($page_name).'<ul>
                                    <li>
                                        <a href="'.$page_url.'">'.ucfirst($page_name).'
                                        </a>
                                    </li>';
                $children_list = collect(json_decode($currentpage->child_collection,true));
                 foreach($children_list as $child){
            
                         $this->assignNavBarHTML($WebpageList->firstWhere('webpage_name',$child),$footer_html);
             
                    }
                 
                 $footer_html.='</ul>';
                                    
             }
        }
        return $footer_html;
    }
    // takes in a type and returns the HTMLSnippet details    
    private function displayHTMLSnippetByType($type)
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
    public function retrieveFooter(){
        $HtmlSnippet = HTMLSnippet::where('type','Footer')
                                   ->first(); 
        
        if(!$HtmlSnippet)
        {
            return "";
        }
        return $HtmlSnippet->content;
    }
    
}
