<html>
<head>
   
</head>
<body style="font-size:12px">
    <div class="ts-main-content">
        <div class="content-wrapper">
            <div class="container-fluid">
 <?php foreach($forms as $form){
     ?>
                                <p><?php echo $form->branchname.'-'.$form->gatepassid;?><span style="float:right">Student Copy</span></p>
                                <p style='font-size:10px;'>Branch Name : <?php
                                        echo $form->branchname; ?> </p>
                                        <p style='font-size:10px;'>Date : <?php
                                        echo date('Y-m-d') ?> </p>
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="140" height="50" /></p>
                                <h5 style="text-align: center;"><strong><u>STUDENT OUT PASS</u></strong></h5>
                                <table style="width: 100%;margin: 0;font-size:12px;">
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Application Number</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $form->applicationnumber; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Student Name</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $form->name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Section</span></td>
                                        <td ><span style="width: 50%;"><?php echo $form->sectionname; ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Mobile</span></td>
                                        <td ><span style="width: 50%;"><?php  echo $form->mobile1;?></span></td>
                                    </tr>
                                    
                                     <tr>
                                          <td></td>
                                        <td ><span style="width: 50%;">From Date</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "FromDate")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">To Date</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Todate")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Days</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Days")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                     <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Hours</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Hours")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                         <td></td>
                                        <td ><span style="width: 50%;">Purpose</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Purpose")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    <tr>
                                         <td></td>
                                        <td ><span style="width: 50%;">Accompanied By</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "gardian")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                         <td></td>
                                        <td ><span style="width: 50%;">Created By</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                       
                                            echo $form->CreatedBy;

                                        ?></span></td>
                                    </tr>
                                </table>
                                
                                  <br />
                                 
                                 <br />
                                  <br />
                                <p style='font-size:10px;'>Sign of the Student
                                <span style="margin-left:100px;">Sign of the Parent</span>
                                <span style="margin-left:160px;">Sign of the Vice-Principal</span>
                                    <span style="float:right">Sign of the Principal</span>
                                </p>
                            </div>
                          <br />
                             <br />
                            <hr>
                            <div class="scale">
                                 <br />
                                  <br />
                                 <p><?php echo $form->branchname.'-'.$form->gatepassid;?><span style="float:right">Security Copy</span></p>
                                 <p style='font-size:10px;'>Branch Name : <?php
                                        echo $form->branchname; ?> </p>
                                        <p style='font-size:10px;'>Date : <?php
                                        echo date('Y-m-d') ?> </p>
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="140" height="50" /></p>
                               
                                <h5 style="text-align: center;"><strong><u>STUDENT OUT PASS</u></strong></h5>
                                <table style="width: 100%;margin: 0;font-size:12px;">
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Application Number</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $form->applicationnumber; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Student Name</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $form->name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Section</span></td>
                                        <td ><span style="width: 50%;"><?php echo $form->sectionname; ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Mobile</span></td>
                                        <td ><span style="width: 50%;"><?php  echo $form->mobile1;?></span></td>
                                    </tr>
                                    
                                     <tr>
                                          <td></td>
                                        <td ><span style="width: 50%;">From Date</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "FromDate")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">To Date</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Todate")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Days</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Days")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                     <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Hours</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Hours")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                         <td></td>
                                        <td ><span style="width: 50%;">Purpose</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Purpose")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                     <tr>
                                         <td></td>
                                        <td ><span style="width: 50%;">Accompanied By</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "gardian")
                                            echo $row;
                                        }
                                        ?></span></td>
                                    </tr>
                                    <tr>
                                         <td></td>
                                        <td ><span style="width: 50%;">Created By</span></td>
                                        <td ><span style="width: 50%;"><?php 
                                       
                                            echo $form->CreatedBy;

                                        ?></span></td>
                                    </tr>
                                </table>
                                
                                  <br />
                                  
                                 <br />
                                   <br />
                               <p style='font-size:10px;'>Sign of the Student
                                <span style="margin-left:100px;">Sign of the Parent</span>
                                <span style="margin-left:160px;">Sign of the Vice-Principal</span>
                                    <span style="float:right">Sign of the Principal</span>
                                </p>
                          
                            <br />
                        <?php } ?>
                        </div>
                        </div>
                        </div>
                        </body>
                        </html>