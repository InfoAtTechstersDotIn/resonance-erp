<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Refund Approval Form
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url('Forms/saveRefundApproval') ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_GET['userId'] ?>" />
                            
                            <?php
                             use App\Models\HelperModel;
                           $helperModel = new HelperModel();
                                             
                                                $promoted = $helperModel->studentcount($studentDetails[0]->userid,$_SESSION['activebatch']);
 $TotalValue=0;
                                            foreach ($feesDetails as $result) :
                                                if($studentDetails[0]->batchid==$result->batchid){
                                            $TotalValue = $TotalValue+$result->TotalValue; 
                                                }
                                            endforeach;
                                           // echo  $TotalValue.'.00';
                                            
                                             $TotalPaid=0;
                                            foreach ($feesDetails as $result1) :
                                                if($studentDetails[0]->batchid==$result1->batchid){
                                                    $TotalPaid = $result1->TotalPaid; 
                                                }
                                            endforeach;
                                            $myString =  $studentDetails[0]->applicationnumber ;
                                             if ($myString > 2300001){
                                                    $TotalPaid = $TotalPaid-2500;
                                                }
                                            
                                            elseif ($myString > 2200001 && $promoted==1) {
                                                $TotalPaid = $TotalPaid-2500;
                                               // echo  $TotalPaid.".00";
                                            }
                                           else{
                                                                                       // echo  $TotalPaid;
                                            }
                                             $RemainingAmount = $TotalValue - $TotalPaid.'.00';
                                             ?>
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td><b>Name of the student</b></td>
                                        <td><?php echo $studentDetails[0]->name ?></td>
                                        <td><b>Application Number</b></td>
                                        <td><?php echo $studentDetails[0]->applicationnumber ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Branch</b></td>
                                        <td><?php echo $studentDetails[0]->branchname ?></td>
                                        <td><b>Course</b></td>
                                        <td><?php echo $studentDetails[0]->coursename ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Section</b></td>
                                        <td><?php echo $studentDetails[0]->sectionname ?></td>
                                        <td><b>Type of admission</b></td>
                                        <td><?php echo $studentDetails[0]->admissiontypename ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Date of Reporting</b></td>
                                        <td><input type="date" name="reporting" id="reporting" required  onchange="changeDate();"/></td>
                                        <td><b>Date of Drop</b></td>
                                        <td><input type="date" name="drop" id="drop" required  onchange="changeDate();"/></td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Fee as per Application</b></td>
                                        <td><?php echo $TotalValue ?>.00</td>
                                        <td><b>Total Fee paid as on date</b></td>
                                        <td><?php echo $TotalPaid ?>.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Books received (No. of sets)</b></td>
                                        <td><input type="number" name="booksReceived" required /></td>
                                        <td><b>No. of days stayed in Hostel</b></td>
                                        <td><input type="number" name="daysStayedInHostel" id="daysStayedInHostel" required /></td>
                                    </tr>
                                    <tr>
                                        <td><b>Materials received<b></td>
                                        <td><input type="text" name="materialReceived" required /></td>
                                         <td><b>Reason for Refund</b></td>
                                        <td><input name="refundReason" required /></td>
                                    </tr>
                                     <tr>
                                        <td><b>Parent A/c Details (Bank) Name<b></td>
                                        <td><input type="text" name="bankname" required /></td>
                                         <td><b>Branch</b></td>
                                        <td><input name="branch" required /></td>
                                    </tr>
                                      <tr>
                                        <td><b>IFSC<b></td>
                                        <td><input type="text" name="ifsc" required /></td>
                                         <td><b>A/c No </b></td>
                                        <td><input name="acno" required /></td>
                                    </tr>
                                    <tr>
                                       
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Print Form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
      function changeDate() {
            var reporting = $('#reporting').val();
            var drop = $('#drop').val();
            
            if(reporting != "" && drop != "" )
            {
                
                date1 = new Date(reporting);
         date2 = new Date(drop);
                var time_difference = date2.getTime() - date1.getTime();

         //calculate days difference by dividing total milliseconds in a day
         var days_difference = time_difference / (1000 * 60 * 60 * 24);
         $('#daysStayedInHostel').val(days_difference);
            }
      }
</script>