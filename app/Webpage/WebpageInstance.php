<?php

/* 
 * Creates a Webpage Instance
 */

namespace App\Webpage;

use App\Webpage\Webpage;
use App\Webpage\Header;
use App\Webpage\Footer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WebpageInstance{
    
    public $webpage_name;
    /**
     * Constructor, reviews the functiono name and number of arguments,
     * if more then one passed on the the required argument, in this case 1
     */
    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
        
    }
    
    
    /**
     * constructer allowing one argunent
     * @param type $member_no
     */
    public function __construct1($id){
        
        
        $this->webpage_name = $id;
        
        
    }
    
    /**
     * Accesses the page name from the instance and returns the Webpage content
     * @return type
     */
    public function retreivePage()
   {
       $page = $this->webpage_name;
       $Webpage = Webpage::where('webpage_name',$page)
                                   ->first();
       
       return $Webpage;
       
       
   }
   
    //outputs a collection of webpages available for admin view
    public function displayWebpageListing()
    {
        $Webpageresult = Webpage::select('webpage_name', 'status', 'parent', 'created_at', 'updated_at')
               ->orderBy('webpage_name', 'asc') 
               ->get();
        
      
      
       return $Webpageresult;
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * Passed in details from the Webpage Create View.  
     * Places each item in the required format and crates a database entry in 
     */
    public function store(Request $request)
    {
        // send the request to the summernoteController to update the content in the summernote
        // database
       
        $webpagename = $this->webpage_name;
       $message = "Webpage has been created";
        try{
                $webname_slug = str_slug($webpagename,"-");
                $Webpage = $this->displayWebPageById($request->pageid);
                
               
                
                // return message and form if the page already exists and not editpage request
               
                // store from editpage request
                if(!isset($request->editpage))
                {
                   
                    // return message and form if the page already exists and not editpage request
                    $CheckWebpage=$this->displayWebPageByName($webname_slug);
                    if($CheckWebpage){
                       // return back()->withError("Page already Exists")->withInput();
                        return "Page already exists";
                    }
                    else{
                        
                        $Webpage = new Webpage();
                    }
                }
               $parentassigned= false;
                // check if any edits need to be performed on the parent and there is a parent available
                 if($request->editpage && strcmp($Webpage->parent, "-")!=0){
                     $message = "Webpage has been edited";
                 
                     // home page as no parent to edit
                     if(strcmp($Webpage->webpage_name, 'home')!=0){
                         $parentassigned= $this->editParent($Webpage, $request,$webname_slug);
                     }
                    
                    
                    // if children were added as part of the edit page
                   if(isset($request->children_list)){
                       // $children_collect = collect($request->children_list);
                        $children_collect = collect(explode(',',$request->children_list));
                        // cycle through the list of children and remove punctuation
                        // this removed an issue which included a " in the child
                        foreach($children_collect as $child){
                            $child = trim(preg_replace('#[[:punct:]]#','', $child));
                        }
                       // $text = preg_replace("/(?![.=$'€%-])\p{P}/u", "", $text);
                        $Webpage->child_collection = json_encode($children_collect);
                        //$this->assignChildren($request->children,$Webpage );
                    }
                }
                else{
                    
                    $Webpage->created_at=Carbon::now();
                }
                
                
                $Webpage->webpage_name = $webname_slug;
                // set webpage title to name if title is not set
                if(!$request->webpagetitle)
                {
                    $Webpage->webpage_title= $webname_slug;
                }
                else
                {
                    $Webpage->webpage_title= $request->webpagetitle;
                }
                
                
                $Webpage->seo_words= $request->seowords;
                $Webpage->description= $request->description;
                

                
                
                $Webpage->content = $this->prepareContent($request->content);
                // add website extras
                if($request->save_as_draft_button){
                    $Webpage->status = 0;
                }
                else{
                    $Webpage->status = 1;
                }
               
                //set created date if a new page request
                      
               
              
                   // if the webpage is home or save as draft then seet parent as - 
                 if(strcmp($webname_slug,"home")==0){
                    $Webpage->parent= "-";
                    $parentassigned=true;
                } 
                
                if(strcmp($request->button,"SaveAsDraft")==0){
                    // if webpage previously had a parent and now set to save as draft
                    if($Webpage->parent){
                        $ParentWebpage = $this->displayWebPageByName($Webpage->parent);
                        $parentcollection= collect(json_decode($ParentWebpage->child_collection, true));
                        $this->forgetChild($parentcollection,$ParentWebpage, $Webpage->webpage_name);
                    }
                    $Webpage->parent= "-";
                    $parentassigned=true;
                }
                
                // if the parent has not been assigned yet through edit page
                else if(!$parentassigned){
                    
                    
                    $Webpage->parent= $request->parent;
                
                    $ParentWebpage = $this->displayWebPageByName($request->parent);
                    // $ParentWeb = $ParentWebpage->first();
                    if(!$ParentWebpage->child_collection){
                        $parentchildren = Collection::make([]);
                    }
                    else{
                      
                       $parentchildren= collect(json_decode($ParentWebpage->child_collection, true));
                       
                        
                    }
                    
                    $parentchildren->push($webname_slug);
                    $ParentWebpage->child_collection=$parentchildren;
                    $ParentWebpage->save();
                      
                } // takes into account Home page which will have no parent
                // all other top level pages will be children to Home
                
                // if the webpage is Home, no parent will be recorded except for "-"
                // if save as draft do not add to parent childred
                
             
                
                $Webpage->updated_at=Carbon::now();   
                $Webpage->save();
                //Header::generateHeader();// generate the header html
                $Header = new Header();
                $Header->generateHeader($this->displayWebpageFamily());
                $Footer = new Footer();
                $Footer->generateFooter($this->displayWebpageFamily());
                
                
        }
        catch (Exception $ex) {
                return back()->withError($ex->getMessage())->withInput();

        }
         return $message;
       
    }
    
     // takes in a id and ouputs the webpage with summernote content
    public function displayWebPageByID($pageid)
    {
        
           
        $Webpage = Webpage::where('id',$pageid)
                                   ->first(); 
               
    
               
        return $Webpage;
    }
    
    // takes in a loction and ouputs the webpage with summernote content
    public function displayWebPageByName($pagename)
    {
        
         
        $Webpage = Webpage::where('webpage_name',$pagename)
                                   ->first();    
               
        return $Webpage;
    }
    
    /** takes in a webpage . request,new webpage name and the Parent webpage details. 
     *First checks if the new parent is different from the old parent.  
     *If it is, it adjusts the old parents children by removing the old page
    *Secondly checks if the new webpage is the same as the old webpage
     * it if is not then replaces the name of the old webpage in the parent
     * colletion with that of the new one. this ensures there are no dubplicate
     * entries or old child entries int he parent
     */ 
     
    private function editParent(Webpage $Webpage,Request $request,$webname_slug){
        
        
        $ParentWebpage = $this->displayWebPageByName($Webpage->parent);
        $parentcollection= collect(json_decode($ParentWebpage->child_collection, true));
        $parentassigned = false;   // used to distinguish later if the parent
        //has been assigned
        
        // if the new parent is not the same as the old parent, remove the child from
        // the old parent
        if(strcmp($Webpage->parent, $request->parent)!=0){
             
             
             $this->forgetChild($parentcollection,$ParentWebpage, $Webpage->webpage_name);
        }
        
        // check if the old webpage name is different from the new webpage name
        // replace the old webpage name with the new one
        if(strcmp($Webpage->webpage_name,$webname_slug )!=0  && strcmp($Webpage->parent, $request->parent)==0){
            $parentcollection->replace([$Webpage->webpage_name => $webname_slug]);
            $parentassigned = true;
            $ParentWebpage->updated_at=Carbon::now();
        }
        // else if the webpage name is the same and parent of request and paretn pages are the same, set
        // parent assigned to true
        else if(strcmp($Webpage->parent, $request->parent)==0){
            $parentassigned = true;
        }
        $ParentWebpage->child_collection = $parentcollection;
        $ParentWebpage->save();
        
        return $parentassigned;
        
    }
    
    /**
     * Removes child from a parent list
     * @param \App\Webpage\Collection $parentcollection
     * @param Webpage $ParentWebpage
     * @param type $webpage_name
     */
    private function forgetChild(Collection $parentcollection, Webpage $ParentWebpage, $webpage_name)
    {
        $parentcollection->forget($parentcollection->search($webpage_name));
        $ParentWebpage->child_collection=$parentcollection;
        $ParentWebpage->updated_at=Carbon::now();
        $ParentWebpage->save();
        
    }
    
     //outputs a collection of webpages available with names, parents and children where pages are status of 1
    // which is published page
    private function displayWebpageFamily()
    {
        $Webpageresult = Webpage::select('webpage_name', 'status', 'parent', 'child_collection')
                ->where('status', 1)
               ->orderBy('webpage_name', 'asc') 
               ->get();
        
      
      
       return $Webpageresult;
        
    }
    // takes in request content from a form and outputs the detail for the database entry of the
    //summernote content. changes to allow for adding images and saves images to the local
    // file system
   private function prepareContent($detail)
   {
        
        $dom = new \domdocument();
        if($detail=="")
        {
            $detail="<p></p>";
        }
        libxml_use_internal_errors(true); // removes html error checking. summernote does not do the best html generation
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getelementsbytagname('img');
 
        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach($images as $k => $img){
            $data = $img->getattribute('src');
 
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
 
            $data = base64_decode($data);
            $image_name= time().$k.'.png';
            $path = public_path() .'/'. $image_name;
 
            file_put_contents($path, $data);
 
            $img->removeattribute('src');
            $img->setattribute('src', $image_name);
        }
         $detail = $dom->savehtml();
        return $detail;
   }
   
   /**
     * takes in a request. provides the webpage.  retreives the parent and deletes
     * the page from the parent and deletes the page from the database. returns a 
     * webpage deleted to the administration page
     */
    public function delete(Request $request)
    {
        $Webpage = $this->displayWebPageById($request->pageid);
        
        // get parent and remove webpage from list of children
        $ParentWebpage = $this->displayWebPageByName($Webpage->parent);
        $parentcollection= collect(json_decode($ParentWebpage->child_collection, true));
        $this->forgetChild($parentcollection,$ParentWebpage, $Webpage->webpage_name);
        $Webpage->delete();
        $Header = new Header();
        $Header->generateHeader($this->displayWebpageFamily());
        $Footer = new Footer();
        $Footer->generateFooter($this->displayWebpageFamily());
        $message = "Webpage Deleted";
        return $message;
        
    }
}