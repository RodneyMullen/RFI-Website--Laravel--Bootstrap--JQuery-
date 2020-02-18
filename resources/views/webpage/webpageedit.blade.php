<?php
//webpage edit calls a given webpage listing and outputs the content to the form for editing


use App\Http\Controllers\WebpageController;
use Illuminate\Support\Collection;


$WebpageList = $WebpageList; // displays collection of webpage
$WebpageContent = $WebpageContent; // displays webpage content
// retreive the list of children from the database
$children_list = collect(json_decode($WebpageContent->child_collection,true));
 if(!isset($message)){
    $message ="";
 }
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Webpage Edit</title>
@endsection
@section('content')
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }} {[$page}}</div>
@endif
@if(strcmp($message,"")!=0)
    <p class="card text-black bg-warning mb-3 text-center">  {{$message }} </p> 
@endif
 <form action="{{route('webpageEdit')}}" method="POST" id="editform" name="editform">
                    {{ csrf_field() }}
<div class="form-group row">
                           <label for="webpagename" class="col-md-4 col-form-label text-md-right">Webpage Name</label>

                            <div class="col-md-6">
                                <input id="webpagename" type="text" class="form-control{{ $errors->has('webpagename') ? ' is-invalid' : '' }}" name="webpagename" value="{{ old('webpagename') ? old('webpagename'):$WebpageContent->webpage_name}}" required autofocus>
                            </div>
                          </div>

      <div class="form-group row">
                            <label for="webpagetitle" class="col-md-4 col-form-label text-md-right">Webpage Title</label>

                            <div class="col-md-6">
                                <input id="webpagetitle" type="text" class="form-control" name="webpagetitle" value="{{ old('webpagetitle') ? old('webpagetitle'): $WebpageContent->webpage_title}}">
                            </div>
                            </div>
   <div class="form-group row">                        
     <label for="content" class="col-md-4 col-form-label text-md-right">Website Content</label>

     <div class="col-md-12">
             <textarea name="content" class="summernote"> {{ old('content') ? old('content'): $WebpageContent->content}}</textarea>
    </div>
 </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Page Details</div>

                <div class="card-body">
                   
                          
                            
                             <div class="form-group row">
                            <label for="parent" class="col-md-4 col-form-label text-md-right">Parent Page</label>

                            <div class="col-md-6">
                                <select id="parent" name="parent">
                                    <!-- Enter access to database to list Parents -->
                                   @if(strcmp($WebpageContent->webpage_name,"home")==0)
                                   <option selected> - </option>
                                   @else
                                    
                                        @if(!old('parent'))
                                            @foreach($WebpageList as $currentpage)
                                            
                                                                        
                                                @if(strcmp($currentpage->webpage_name, $WebpageContent->parent)==0)
                                                    <option selected>{{$currentpage->webpage_name}} </option>
                                                @elseif(strcmp($WebpageContent->webpage_name , $currentpage->webpage_name)!=0)
                                                    <option> {{$currentpage->webpage_name}} </option>
                                                @endif
                                            @endforeach
                                        @else
                                   
                                            @foreach($WebpageList as $currentpage)
                                                @if(strcmp(old('parent'),$currentpage->webpage_name)==0)
                                                    <option selected>  {{$currentpage->webpage_name}} </option>
                                                @elseif(strcmp($WebpageContent->webpage_name , $currentpage->webpage_name)!=0)
                                                    <option> {{$currentpage->webpage_name}} </option>
                                                @endif
                                            @endforeach
                                        @endif
                                   @endif
                                </select>
                                    
                            </div>
                             </div>
                            
                           
                            <div class="form-group row">
                                <label for="seowords" class="col-md-4 col-form-label text-md-right">SEO Words</label>

                                <div class="col-md-6">
                                    <textarea name="seowords" class="form-control" value="{{ old('seowords') ? old('seowords'): $WebpageContent->seo_words}}"></textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Page Description</label>

                                <div class="col-md-6">
                                    <textarea name="description" class="form-control" value="{{ old('description') ? old('description'): $WebpageContent->description}}"></textarea>
                                    
                                </div>
                            </div>
                            @if(!$children_list->isEmpty())
                            
                                <div class="form-group row" id="children-list-area">
                                    <label for="children" class="col-md-4 col-form-label text-md-right">Webpage Children</label>
                                    
                                       <div class="col-md-6">
                                            <ol id="children" name="children">
                                                    
                                                @foreach($children_list as $child)
                                                   <li id="{{$child}}" value="{{$child}}"><p class="well">{{$child}}</p> </li>
                                                  
                                                @endforeach
                                            </ol>
                                       </div>
                                </div>
                            @endif
                               <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" id="editpage" name="editpage" value="{{$WebpageContent->webpage_name}}">
                                     <input type="hidden" id="pageid" name="pageid" value="{{$WebpageContent->id}}">
                                     <input id="children_list" name="children_list" type = "hidden">
                                    <button type="submit" id="button" name="button" value="Publish" > Publish</button>
                                    <button type="submit" id="button" name="button" value="SaveAsDraft">Save as Draft</button>
                                    <button type="submit" id="button" name="button" value="Delete">Delete</button>
                                </div>
                            </div>     
                      </div>
                     
               </div>
            
            </div>
        </div>

               
 </form>                        
 <div class="modal fade" id="move-children-modal" tabindex="-1" role="dialog" aria-labelledby="fadeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="noFadeLabel">Cannot Delete Webpage</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <div class="modal-body">
                <p>Please move children pages from this page.  Cannot delete a page while there are children connected</p>
            </div>
        </div>        
    </div>
 </div>    


        
        
      
        
 
<script>

 



$(document).ready(function() {
    $('.summernote').summernote();
    
    // createing the sortable list for extras
			   



    $('.summernote').summernote({
        popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ]
        },
        lang: 'en-US', // Change to your chosen language
        imageAttributes:{
            icon:'<i class="note-icon-pencil"/>',
            removeEmpty:false, // true = remove attributes | false = leave empty if present
            disableUpload: false // true = don't display Upload Options | Display Upload Options
        }
        
        
    });



    $('#children').sortable({
   
            opacity : 0.5,
            placeholder : 'ui-state-highlight',
            cursor: 'pointer',
            axis: 'y'
            
    }); // end of set children sortable
   
  

});
// when button is clicked check if it is the delete or submit or save button
$('button').click(function(){
    
    if($(this).val()=="Delete"){
        
        return deleteButton();
    }
    else
    {
       return submitAndSaveButton();
    }
 
}); // end of button click

// if submit or save button clicked , retrieve the list of children and apply to a hidden
// input called children_list for the form submission
function submitAndSaveButton(){
       var selection;
        var inputs = $.map($('ol li'), function(e,i) { 
               selection=$(e).text();
               return selection.trim();
       
        });
        
    $('#children_list').val(inputs);
    
} // end of submit and save button function
    
// if delete button is pressed send on to the form otherwise intercept the form submission
// if there are children attached
function deleteButton(){
   
// confirm if user wishes to delete the page
    if($('#children').length){
  
        showMoveChildrenModal();
       // alert("Please move children pages from this page.  Cannot delete a page while there are children connected");   
        // intercepts the submission of the form
          return false;
    }
    else{
     
        var answer = confirm("Are you sure you want to Delete this page?");
        return answer;
        
        if(!answer){
            // intercepts the submission of the form
            return false;
         }
         
         
    }
        
    
} // end of delete button click


function showMoveChildrenModal() {
    $('#move-children-modal').modal('show');
  }
  



</script>



@endsection

