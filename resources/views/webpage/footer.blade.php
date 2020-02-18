<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Webpage\Footer;
$Footer = new Footer();
$footer_content=$Footer->retrieveFooter();


?>
<div class="row footer-rfi">
    <div class="col-md-6">
        <H3> Contact us </H3>
        
        <p>
            <h5 clasee="text-bold">Membership Enquiries & Applications:</h5>

membership@reikifederationireland.com
        <br />    Membership Secretary:
       <br />     Reiki Federation Ireland,
<br />Unit 6
<br />Greenogue Business Plaza
<br />Rathcoole
<br />Co Dublin, Ireland
<br />Phone: 087 9819366
        </p>
        <br/>
        <p>
        <h5 clasee="text-bold"> Press Related Enquiries:</h5>


publicrelations@reikifederationireland.com


        </p>
        <br />
        <p>
            <h5 clasee="text-bold"> General Enquiries:</h5>
            info@reikifederationireland.com
       </p>
    <br />
        <p>
            <h5 clasee="text-bold"> RFI Chairperson:</h5>
            
            chair@reikifederationireland.com
       </p>
 

 </div>
    
      <div class="col-md-6">
          <h2> Site Map </h2>
     <?php     
          echo $footer_content;
          ?>
        <br/>
        <H2>Connect With us</H2>
          <a class="btn btn-social btn-facebook">

            <i class="fab fa-facebook-f"></i>

            Facebook

            </a>

  </div>
    
    
</div>
<div class="row">
		<div class="col-md-12">
			<footer>
				<p>&copy; Copyright 2019 Reiki Federation of Ireland</p>
			</footer>
		</div>
	</div>
</div>

</html>                            