

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Transfer Certificate
                </h2>
                <?php
                use App\Models\UsersModel;
                 use App\Models\HelperModel;
                $usersModel = new UsersModel(); 
                //print_r($studentDetails);
                //echo $studentDetails[0]->applicationnumber;
                $student_tc_Details = $usersModel->get_tc_details($studentDetails[0]->applicationnumber);
                if(empty($student_tc_Details))
                {
                    echo 'No details found of the students for that batch';
                    exit();
                }
                                $TotalValue=0;
                                            foreach ($feesDetails as $result) :
                                                if($_GET['batchid']==$result->batchid){
                                                    
                                            $TotalValue = $TotalValue+$result->TotalValue; 
                                                }
                                            endforeach;
                                          //  echo  $TotalValue.'.00';
                                            $TotalPaid=0;
                                            foreach ($feesDetails as $result1) :
                                                if($_GET['batchid']==$result1->batchid){
                                                    $TotalPaid = $result1->TotalPaid; 
                                                }
                                            endforeach;
                                            $myString =  $studentDetails[0]->applicationnumber ;
                                             $helperModel = new HelperModel();
                                             
                                                $promoted = $helperModel->studentcount($result1->userid,$_GET['batchid']);
                                                
                                               $promoted1 = $helperModel->studentbatchcount($result1->userid);
                                               if($promoted1==0)
                                               {
                                                    $TotalPaid = $TotalPaid-2500;
                                               }else
                                               {
                                            if ($myString > 2300001){
                                                    $TotalPaid = $TotalPaid-2500;
                                                }
                                            elseif ($myString > 220001 && $promoted==1) {
                                                $TotalPaid = $TotalPaid-2500;
                                               // echo  $TotalPaid.".00";
                                            }else{
                                                
                                                //echo  $TotalPaid;
                                            }
                                               }
                                             $RemainingAmount=0;
                                            foreach ($feesDetails as $result1) :
                                                if($_GET['batchid']==$result1->batchid){
                                            $RemainingAmount = $RemainingAmount+$result1->RemainingAmount; 
                                                }
                                            endforeach;
                                             
                                           // echo $TotalValue - $TotalPaid.'.00';
                if (($TotalPaid >= $TotalValue && $Laundry > 0 && $studentDetails[0]->admissiontypename == "Residential") ||
                    ($TotalPaid >= $TotalValue  && $studentDetails[0]->admissiontypename != "Residential")
                ) :
                ?>
                    <a class="btn btn-success PrintD" onclick="printDiv('div',<?php echo $_SESSION['userdetails']->userid;?>,<?php echo $studentDetails[0]->userid;?>,'<?php echo $studentDetails[0]->applicationnumber;?>')">Print</a>

                    <div class="row">
                        <div class="col-md-12" id="div" style="visibility: ;">
                            <div class="scale">
                       
                       <div class="row" style="
    display: flex;
    justify-content: center;
    align-items: center;
">
                           
                           <div class="col-md-4">
                                <img src="<?php echo base_url('images/logo.png') ?>" style="float:right" width="80" height="80"/>
                               
                           </div>
                            <div class="col-md-8">
                                     <!--<p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>-->
                                <p style="text-align: right;"><STRONG>ORIGINAL</STRONG></p>
                                 <h2 style="text-align: center;"><u>RESONANCE JUNIOR COLLEGE</u></h2>
                                <h5 style="text-align: center;"><strong><u>(Recg.by Govt., of TS, <?php echo $student_tc_Details[0]->rc_no;?> , College Code: <?php echo $student_tc_Details[0]->college_code;?>)</u></strong></h5>
                                <h5 style="text-align: center;"><strong><u> <?php echo $student_tc_Details[0]->address;?></u></strong></h5>
                                <h4 style="text-align: center;"><strong><u> TRANSFER CERTIFICATE </u></strong></h4>
                               
                               
                           </div>
                           
                           </div>
                                 <table style="width: 100%;margin: 0;">
                          
                                    <tr >
                                        <th>
                                        T.C No : &nbsp;&nbsp;&nbsp;<?php echo $student_tc_Details[0]->tc_no;?> / <?php echo $student_tc_Details[0]->year;?> 
                                        </th> 
                                        <th  > : &nbsp;&nbsp;&nbsp;Adm. No: &nbsp;&nbsp;&nbsp;<?php echo $student_tc_Details[0]->admission_no;?> / <?php echo $student_tc_Details[0]->admission_year;?>
                                        </th>    
                                    </tr>
                                    <tr >
                                        <td ><span style="width: 50%;">1. Name of the College <br> &nbsp;&nbsp;&nbsp;(Place and District)</span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php echo $student_tc_Details[0]->college_code;?>– RESONANCE JR.COLLEGE <br> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $student_tc_Details[0]->place;?> – <?php echo $student_tc_Details[0]->district;?>.                </span></td>
                                        <br>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">2. Name of the Pupil</span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php echo $student_tc_Details[0]->name; ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">3. Name of the Father</span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php echo $student_tc_Details[0]->fathername; ?></span></td>
                                    </tr>
                                   
                                    <tr>
                                        <td ><span style="width: 50%;">4. Name of the Mother</span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp; <?php echo $student_tc_Details[0]->mothername; ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">5. Nationality and Religion</span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp; <?php  echo $student_tc_Details[0]->nationality;?></span></td>
                                    </tr>
                                   
                                    <tr>
                                        <td ><span style="width: 70%;">6. Whether the Candidate belongs to SCs or </br> &nbsp;&nbsp;&nbsp; STs or EBC or Minority specified in T.S.E, <br>  &nbsp;&nbsp;&nbsp; if so,the particulars there of
                                        </span></td>
                                        <td ><span style="width: 30%;"> : &nbsp;&nbsp;&nbsp;<?php  echo $student_tc_Details[0]->caste; if($student_tc_Details[0]->subcaste !='' || $student_tc_Details[0]->subcaste==NULL){ echo ' '.$student_tc_Details[0]->subcaste; } ?></span></td>
                                    </tr>
                                   
                                    <tr>
                                        <td ><span style="width: 50%;">7. Date of Birth (in words) as per College 
                                        <br> &nbsp;&nbsp;&nbsp; 
                                        Records
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        
                                        $UNIX_DATE = ($student_tc_Details[0]->dob);
                                            echo $UNIX_DATE;
                                         ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">8. a)Class in which the pupil was reading at 
                                                                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; the time of leaving (in words)            

                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->class;?></span></td>
                                    </tr>
                                    <tr>
                                        <td ><span style="width: 50%;">&nbsp;&nbsp;&nbsp; b) First Language Under Part I           

                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->first_language;?></span></td>
                                    </tr>
                                    <tr>
                                        <td ><span style="width: 50%;">&nbsp;&nbsp;&nbsp; c) Second Language Under Part II           

                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->second_language;?></span></td>
                                    </tr>
                                    <tr>
                                        <td ><span style="width: 50%;">&nbsp;&nbsp;&nbsp; d) Optionals Under Part III           

                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->optionals;?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">9. Mother Tongue / Medium of Instruction
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->mother_tounge;?> / <?php 
                                        echo $student_tc_Details[0]->medium;?> </span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">10. Date of Admission to 1st/2nd Year 
                                        <BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Intermediate
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                     //  $UNIX_DATE = ($student_tc_Details[0]->admission_date - 25569) * 86400;
                                         //   echo gmdate("d-m-Y", $UNIX_DATE);
                                         echo $student_tc_Details[0]->admission_date;
                                         ?></span></td>
                                         
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">11. Class and year in which the pupil was first<br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;admitted into the Intermediate Course<br>
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(1st year or 2nd year)

                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->class_joined;?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">12. Whether Qualified to study II year Class of
                                        <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Intermediate Course? (In case of students<br>
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Completing 1st year class
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->qualified;
                                       ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">13. Whether the pupil has been declared 
                                        <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; eligible by the Board of Intermediate 
                                        <br> 
                                        
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Education for University Course of Study
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->eligible;
                                       ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">14. a) Whether the pupil was in receipt of any
                                        <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;scholarship? (Nature of the scholarship <br>
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;to be Specified)
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->scholarship;
                                       ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">&nbsp;&nbsp;&nbsp;&nbsp;  b) Whether the pupil was in receipt of any
                                        <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;concession (Nature of concession to be
                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        specified
                                       
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->concession;
                                       ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">15. Personal Marks of Identification	<BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; I) 
                                        <br>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; II)
                                       
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;AS PER PREVIOUS SCHOOL RECORDS <br> : &nbsp;&nbsp;&nbsp;AS PER PREVIOUS SCHOOL RECORDS</span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">16. Date on which the pupil has actually<BR>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Left the College:
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                      //  $UNIX_DATE = ($student_tc_Details[0]->date_left - 25569) * 86400;
                                          //  echo gmdate("d-m-Y", $UNIX_DATE);
                                             echo $student_tc_Details[0]->date_left;
                                       ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td ><span style="width: 50%;">17. Date of Transfer Certificate
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                      //  $UNIX_DATE = ($student_tc_Details[0]->tc_date - 25569) * 86400;
                                          //  echo gmdate("d-m-Y", $UNIX_DATE);
                                            echo date("d-m-Y");
                                       ?></span></td>
                                    </tr>
                                   
                                    <tr>
                                        <td ><span style="width: 50%;">18. Conduct
                                        </span></td>
                                        <td ><span style="width: 50%;"> : &nbsp;&nbsp;&nbsp;<?php 
                                        echo $student_tc_Details[0]->conduct;
                                       ?></span></td>
                                    </tr>
                                    


                                </table>
                                
                                <br />
                                 <br />
                                 <br />
                                 <br />
                                 <br />
                                 <br />
                                 <br />
                                <p>
                                    <span style="float:left">Generated By : <?php echo $_SESSION['userdetails']->name;?></span>
                                    <span style="float:right">PRINCIPAL</span>
                                </p>
                            </div>
                            <style>
                                @media print {
                                    .scale {
                                        font-size: 15px;
                                    }
                                }
                            </style>
                        </div>
                    </div>
                    <script>
                        function printDiv(divName,userid,studentid,applicationnumber) {
                             $('.PrintD').hide();
                             $.ajax({
            type: "POST",
            url: "<?php echo base_url('forms/updatetclog') ?>",
            data: {
                userid: userid,
                studentid:studentid,
                applicationnumber: applicationnumber,
               
            },
            success: (data) => {
            }
        });
                            var printContents = document.getElementById(divName).innerHTML;
                            var originalContents = document.body.innerHTML;

                            document.body.innerHTML = printContents;
                            
                           setTimeout(printscreen, 500, originalContents);
                           
                        }
                       

function printscreen(originalContents) {
   window.print();
   document.body.innerHTML = originalContents;
}

                    </script>

                <?php
                else :
                ?>
                    Cannot generate No Due Certificate because the student haven't paid full fees.<br /><br />
                    <b>Total Fees</b>: <?php echo $TotalValue.'.00'; ?><br />
                    <b>Fees Paid</b>: <?php echo $TotalPaid; ?><br />
                    <b>Remaining Fees</b>: <?php echo $TotalValue - $TotalPaid.'.00'; ?><br />
                    <b>TRANSPORT FEE IPE - 2023</b>: <?php echo $Laundry ?><br />
                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</div>