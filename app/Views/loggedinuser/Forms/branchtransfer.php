<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Branch Transfer Form
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        use App\Models\HelperModel;
                           $helperModel = new HelperModel();
                                             
                                                $promoted = $helperModel->studentcount($studentDetails[0]->userid,$_GET['batchid']);
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
                                            $myString =  $StudentDetail->applicationnumber ;
                                            
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
                                             $RemainingAmount=0;
                                            foreach ($feesDetails as $result1) :
                                                if($_GET['batchid']==$result1->batchid){
                                            $RemainingAmount = $RemainingAmount+$result1->RemainingAmount; 
                                                }
                                            endforeach;
                                            
                                            
                                            ?>
                        <form action="<?php echo base_url('Forms/savebranchtransfer') ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $_GET['userId'] ?>" />
                             <?php
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
                                        <td><b>Date of Transfer</b></td>
                                        <td><input type="date" name="transfer" id="transfer" required  onchange="changeDate();"/></td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Fee as per Application</b></td>
                                        <td><?php echo $TotalValue ?>.00</td>
                                        <td><b>Total Fee paid as on date</b></td>
                                        <td><?php echo $TotalPaid ?>.00</td>
                                    </tr>
                                    <tr>
                                         <td><b>Select Admission Type</b></td>
                                        <td><select style="width: 100%;" class="select2 form-control mb" name="admissionid" required>
                              <option value="">Select </option>
                               <option value="Day scholar">Day scholar</option>
                                <option value="Residential">Residential</option>
                              </select>
                              </td>
                                        <td><b>Select Destination Branch</b></td>
                                        <td><select style="width: 100%;" class="select2 form-control mb" name="branchid" required>
                              <option value="">Select Branch</option>
                              <?php
                              foreach ($branches as $branch) :
                              ?>
                                 <option value="<?php echo $branch->branchname; ?>"><?php echo $branch->branchname; ?></option>
                              <?php
                              endforeach;
                              ?>
                           </select>
                           </td>
                          
                                    </tr>
                                    <tr>
                                        <td><b>Inventory received</b></td>
                                        <td>
                                            <input type="text" name="inventory" required />
                                        </td>
                                        <td><b>No. of days stayed in Hostel</b></td>
                                        <td><input name="daysStayedInHostel" id="daysStayedInHostel" required /></td>
                                    </tr>
                                    
                                    <tr>
                                       
                                        <td><b>Fee</b></td>
                                        <td><input name="fee" required /></td>
                                         <td><b>Reason for Tranfer</b></td>
                                        <td><input name="transferReason" required /></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Submit</button>
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
            var transfer = $('#transfer').val();
            
            if(reporting != "" && transfer != "" )
            {
                
                date1 = new Date(reporting);
         date2 = new Date(transfer);
                var time_difference = date2.getTime() - date1.getTime();

         //calculate days difference by dividing total milliseconds in a day
         var days_difference = time_difference / (1000 * 60 * 60 * 24);
         $('#daysStayedInHostel').val(days_difference);
            }
      }
</script>