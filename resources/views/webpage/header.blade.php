<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Webpage\Header;

$Header = new Header();
$header_content=$Header->retrieveHeader(); 
echo $header_content;

    
  
	