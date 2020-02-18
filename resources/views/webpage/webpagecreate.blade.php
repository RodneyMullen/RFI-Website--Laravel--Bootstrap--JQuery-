<?php

/* 
 * Page to generate a form to create a webpage
 */



$WebpageList = $WebpageList; //list of webpages
?>
@extends('layouts.masterpage')
  
@section('title')
<title>Web Administration</title>
@endsection
@section('content')
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
 <form action="{{route('webpagePersist')}}" method="POST">
                    {{ csrf_field() }}
<div class="form-group row">
                           <label for="webpagename" class="col-md-4 col-form-label text-md-right">Webpage Name</label>

                            <div class="col-md-6">
                                <input id="webpagename" type="text" class="form-control{{ $errors->has('webpagename') ? ' is-invalid' : '' }}" name="webpagename" value="{{ old('webpagename') }}" required autofocus>
                            </div>
                          </div>

      <div class="form-group row">
                            <label for="webpagetitle" class="col-md-4 col-form-label text-md-right">Webpage Title</label>

                            <div class="col-md-6">
                                <input id="webpagetitle" type="text" class="form-control" name="webpagetitle" value="{{ old('webpagetitle') }}">
                            </div>
                            </div>
   <div class="form-group row">                        
     <label for="content" class="col-md-4 col-form-label text-md-right">Website Content</label>

     <div class="col-md-12">
             <textarea name="content" class="summernote"> {{ old('content') }}</textarea>
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
                                   @if(!old('parent'))
                                        @foreach($WebpageList as $page)
                                            @if(strcmp($page->webpage_name, "Home")==0)
                                                <option selected>{{$page->webpage_name}} </option>
                                             @else
                                                <option> {{$page->webpage_name}} </option>
                                            @endif
                                        @endforeach
                                    @else
                                   
                                        @foreach($WebpageList as $page)
                                            @if(strcmp(old('parent'),$page->webpage_name)==0)
                                                <option selected>  {{$page->webpage_name}} </option>
                                            @else
                                                <option> {{$page->webpage_name}} </option>
                                            @endif
                                        @endforeach
                                   @endif
                                   
                                </select>
                                    
                            </div>
                             </div>
                            
                           
                            <div class="form-group row">
                                <label for="seowords" class="col-md-4 col-form-label text-md-right">SEO Words</label>

                                <div class="col-md-6">
                                    <textarea name="seowords" class="form-control" value="{{ old('seowords') }}"></textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">Page Description</label>

                                <div class="col-md-6">
                                    <textarea name="description" class="form-control" value="{{ old('description') }}"></textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="extras" class="col-md-4 col-form-label text-md-right">Extras</label>

                                <div class="col-md-6">
                                <select id="extras">
                                    <!-- Enter access to database to list Parents -->
                                    <option>  </option>
                                    </select>
                               <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="button" name="button" value="Publish" > Publish</button>
                                    <button type="submit" id="button" name="button" value="SaveAsDraft">Save as Draft</button>
                                </div>
                            </div>     
                            </div>
                             </div>
                    </div>
            
        </div>
    </div>

    </div>                
 </form>                        
                


        
        
      
        
    </form>



  
<script>

 



$(document).ready(function() {
    $('.summernote').summernote();
			   



    $('.summernote').summernote({
        popover: {
            image: [
                ['custom', ['imageAttributes']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
              ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ],
            
        },
        lang: 'en-US', // Change to your chosen language
        imageAttributes:{
            icon:'<i class="note-icon-pencil"/>',
            removeEmpty:false, // true = remove attributes | false = leave empty if present
            disableUpload: false // true = don't display Upload Options | Display Upload Options
        }
    });

});
</script>
@endsection