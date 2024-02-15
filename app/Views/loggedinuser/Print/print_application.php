<?php

 use App\Models\HelperModel;
 $helperModel = new HelperModel();
                                        $fee = $helperModel->getFeeStructure($userDetails->courseid,$userDetails->admissiontypeid,$userDetails->batchid);
                                        $new = $fee[0]->fee;
                                        $var = (int)$new ;
                                        if($userDetails->nextid != 0){
                                        $fee1 = $helperModel->getNextFeeStructure($userDetails->nextid,$userDetails->admissiontypeid,$userDetails->batchid);
                                        $new1 = $fee1[0]->fee;
                                        $new2 = $fee1[0]->coursename;
                                        $var1 = (int)$new1 ;
                                        }else
                                        {
                                            $var1 = 0;
                                            $new2 = '';
                                        }
                                        $kit = $helperModel->getStudentKit($userDetails->courseid);
                                         if($userDetails->admissiontypeid == 3)
                                        {
                                         $studentkit = $kit[0]->studentkit_dayscholar;
                                        }else
                                        {
                                            $studentkit = $kit[0]->studentkit_resdential;
                                        }
 ?>
<html>
  
   <body style="font-family:sans-serif; font-size:14px; box-sizing:border-box; margin: 0;   padding: 0; ">
      <section class="form">
         <div class="container" style="max-width: 80%; margin:auto;">
           
              <?php 
               $PreviousClassesInfo = json_decode($userDetails->previous_class_information);
              
                            if ($PreviousClassesInfo != "") {
                                foreach ($PreviousClassesInfo as $classInfo) {
                                    $classInfo = $classInfo;
                                }
                            }
                            
                             $Address = json_decode($userDetails->address);
                            $permanentAddress = $Address->permanent;
               ?>
               
               <?php
               $board1 = '';
                                        foreach ($lookups['boardlookup'] as $board) :
                                       if($classInfo->board == $board->boardid)
                                       {
                                          $board1 =  $board->boardname;
                                       }
                                        endforeach;
                                        
                                         foreach ($lookups['stateslookup'] as $state) :
                                        
                                            if($permanentAddress->state == $state->state_id){ $state1 =  $state->state_name; }
                                        
                                        endforeach;
                                        
                                         foreach ($lookups['districtslookup'] as $district) :
                                            if ($district->state_id == $permanentAddress->state) :
                                        if($permanentAddress->district == $district->district_id){ $dist =  $district->district_name; }
                                        
                                            endif;
                                        endforeach;
                                        
                                        foreach ($EmployeeDetails as $reference) :
                                          if($userDetails->created_by == $reference->userid){ $reference1 = $reference->name; }
                                        endforeach;
                                        ?>
            <div class="fd" style="width: 100%; position:relative; border: 1px solid black;">
                <table style="border-collapse: collapse;">

<tr>

<td>
<img src="https://maidendropgroup.com/images/logo1.png" style="height:60px;">

</td>

<td style="
    border-left: 1px solid black;
    padding: 0px 30px;
">

<h4>Application Form</h4>
               <h4>Application  No:<?php echo $userDetails->application_ukey ?></h4>
</td>
<td style="
    width: 25%;border-left: 1px solid black;padding: 10px;
">
<img src="https://maidendropgroup.com/images/maidendrop.png" style="width:70%">

</td>
</tr>



</table>
               <table style="    border-collapse: collapse;
                  width: 100%;">
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;"><b> Course Name </b></td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->coursename ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;"><b>Admission Type</b></td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->admissiontypename ?></td>
                  </tr>
                  <tr>
                     
                     
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;"><b> Campus Name </b></td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->branchname ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;"><b> </b></td>
                     <td style="padding: 4px 10px;border: 1px solid black"></td>
                  </tr>
                 
               </table>
               <table class="tabl2" style="    border-collapse: collapse;
                  width: 100%;">
                  <tr class="bg" style="position: relative; height:30px; background-color: #bedff7; border: 1px solid black;">
                     
                     <th style="position: absolute; left:40%; font-size:18px; padding:5px 0px;">Basic Details</th>
                     <th></th>
                     <th></th>
                     <th></th>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black; font-weight: bold;">Student Name<?php if($userDetails->discountgiven !=null || $userDetails->discountgiven !="")
                     {
                         ?>
                         <sup>*</sup>
                         <?php
                     }
                     ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->name ?>
                     
                     </td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;" >Date of Birth</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->dateofbirth ?></td>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Father/Guardian Name </td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->fathername ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Mothers  Name</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->mothername ?></td>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;"> Gender</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->gendername ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Aadhar Number</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->studentaadhaar ?></td>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Mobile Number</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->mobile1 ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Email Adress</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->email ?></td>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">School/College</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $classInfo->school ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Board</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php print_r($board1) ?></td>
                  </tr>
                  <tr class="bg" style="position: relative; height:30px; background-color: #bedff7; border: 1px solid black;">
                     
                     <th style="position: absolute; left:40%; font-size:18px; padding:5px 0px;"> Address </th>
                     <th></th>
                     <th></th>
                     <th></th>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">State</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php print_r( $state1);?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">District</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php print_r($dist);?></td>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">City</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $permanentAddress->city_town ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">pincode</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $permanentAddress->pin ?></td>
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Address Line 1</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $permanentAddress->door_street ?></td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Address Line 2</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php echo $permanentAddress->village_mandal ?>,<?php echo $permanentAddress->landmark ?></td>
                  </tr>
                  
                  <tr class="bg" style="position: relative; height:30px; background-color: #bedff7; border: 1px solid black;">
                    
                     <th style="position: absolute; left:40%; font-size:18px; padding:5px 0px;">
                        Fee Details
                     </th>
                      <th></th>
                     <th></th>
                     <th></th>
                  </tr>
                  <tr>
                      <?php  
                       ?>
                                                    <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;"><?php echo $userDetails->coursename ?></td>
                                                    <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->tuition_discount ?></td>
                                                     <?php if($var1 !=0){ ?>
                                                    <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;"><?php echo $new2;?></td>
                                                    <td style="padding: 4px 10px;border: 1px solid black"><?php echo $userDetails->tuition_discount1 ?></td>
                                                    <?php }else
                                                    {
                                                        ?>
                                                        <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">-</td>
                                                    <td style="padding: 4px 10px;border: 1px solid black">-</td>
                                                        <?php
                                                    }?>
                                               
                  </tr>
                  <tr>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">-</td>
                     <td style="padding: 4px 10px;border: 1px solid black">-</td>
                     <td style="padding: 4px 10px;border: 1px solid black;font-weight: bold;">Admissions Team</td>
                     <td style="padding: 4px 10px;border: 1px solid black"><?php print_r($reference1);?></td>
                  </tr>
               </table>
               <h5 ><b><sup>*</sup><span style="background-color: #bedff7;font-size:16px;">Note:</span></b>
                 Above Mentioned course fee does not include Miscellaneous Charges Which Is Rs.<?php echo $studentkit;?>/- (Student Kit). This Fee Need to be paid Separately to the stores department at the time of Reporting to avail Student Kit(JEE/NEET material, IPE material, NCERT material, Uniform, Bag, Water Bottle, IDcard, Online Portal access, Dhobi(Hostel)).</h5>
            </div>
         </div>
         </div>
         <br>
         <br>
         <br>
           <br>
         <br>
         <br>
         
           <br>
       
         <div class="terms" style="max-width: 80%; margin:auto; border:1px solid black; border-top:none; ">
            <h3 style="background-color: #bedff7;  text-align:center; padding:5px; border:1px solid black; font-size:18px;margin:0px;">Terms and Conditions</h3>
            <div class="terms_in" style="padding:0px 10px;">
               <p style="padding: 5px;  font-weight:700;margin:0px;"><b>Undertaking by the student:</b></p>
               <p style="line-height: 1.2;margin:0px;">I hereby solemnly pledge to adhere to the rules and regulations set forth by the college. I shall uphold the discipline and values of this institution and wholeheartedly embrace its anti-ragging policies. In the event of any misconduct on my part, I shall not challenge any actions taken by the management authorities of this institution, including but not limited to my expulsion.
                <br> I acknowledge the directive from the management regarding the prohibition of electronic devices such as mobile phones, watches, and video games. I am aware that should I choose not to enroll for any reason, the admission fee will not be subject to refund.
               </p>
               
               <p style="float: right; font-weight:700;padding:5px;margin:0px;">Signature of the student</p>
               <br>
               <p style="padding: 5px;  font-weight:700;margin:0px;">Undertaking by the parent:</p>
               <p style="line-height: 1.2;margin:0px;">I acknowledge that the reservation fee paid is non-refundable under any circumstances. The cancellation of admission or the settlement of accounts will be carried out in accordance with the conditions outlined by the management. 
<br>In the event that my ward or visitor engages in misconduct or creates disturbances within the campus, the concerned individual may face rustication or be transferred to other branches, as per the policies established by the institution. It is understood that the institution bears no responsibility for my ward's behavior outside the campus. 
<br>Furthermore, students are not permitted to leave the college premises during scheduled college hours. In case of any urgent situations, parents are required to seek approval from the respective campus.

               </p>
               <ul style="padding: 15px 30px;">
                   <li>
                       Fee paid for my ward will not be transferred to another student's name in any case. If I want to shift my ward from your institution to other before completion of two years course, I shall payback the concession given at the time of admission.
                   </li>
                   <li>Fee structure and concession may vary from branch to branch. The course fee does not include transport.</b></li>
               <li>Allotment of campus and section is at the sole discretion of the management. The management reserves the right to shift the students from one campus to another campus.</li>
               <li>Fee concession, if offered will be valid for that academic year only. Any other taxes will be collected separately, where ever applicable.</li>
               
               <li>Permission can be given to my ward, if he/she wishes to go out from the campus on any urgency or   during the common outing.</li>
               <li>Reservation Fee of Rs.12500/- is Non Refundable. Rs.10000/- from Reservation fee will be adjusted towards Tuition Fee.</li>
               <li>I know that the fee paid towards admission is not refundable in any case. Cancellation of admission or settlement of accounts is as per College instructions. No Refund for cancelation of after 30th June 2024.</li>
               <li>Fee can be paid in three Installments, 1st term will be 50% at the time of Reporting, 25% By 10th AUG 2025 and Remaining 25% before 10th Dec 2025.</li>
              
                   <p style="padding: 5px; float:right;  font-weight:700; padding-top: 10px;"> Signature of the Parent </p>
               <p style="padding: 5px; float:left;  font-weight:700; padding-top: 10px;"> Signature of the Principal </p>
                
                
                
                </ul>
            
               <br>
            </div>
         </div>
      </section>
   </body>
</html>

<style type="text/css" media="print">
    .page
    {
     -webkit-transform: rotate(-90deg); 
     -moz-transform:rotate(-90deg);
     filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }
</style>