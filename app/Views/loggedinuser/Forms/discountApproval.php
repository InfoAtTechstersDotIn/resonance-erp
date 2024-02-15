<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Discount Approval Form
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
                        <form action="<?php echo base_url('Forms/saveDiscountApproval') ?>" method='POST'>
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
                            <input type="hidden" name="user_id" value="<?php echo $_GET['userId'] ?>" />
                            <input type="hidden" name="batchid" value="<?php echo $_GET['batchid'] ?>" />
                            <input type="hidden" name="branchid" value="<?php echo $studentDetails[0]->branchid ?>" />
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
                                        <td><?php echo $studentDetails[0]->admissiontypename;?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Date of Joining</b></td>
                                        <td><?php 
                                        echo date_format(date_create($studentDetails[0]->admissiondate), 'd/m/Y') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Fee as per Application</b></td>
                                        <td><?php echo $TotalValue ?>.00</td>
                                        <td><b>Total Fee paid as on date</b></td>
                                        <td><?php echo $TotalPaid ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Discount Type</b></td>
                                        <td>
                                     <select name="discountid" class="form-control mb" required>
                                        <option value="">Select Discount Type</option>
                                        <?php
                                        foreach ($lookups['discountlookup'] as $otherFees) :
                                        ?>
                                           <option value="<?php echo $otherFees->id; ?>"><?php echo $otherFees->discountname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                     </select>
                                  </td>
                                   <td><b>Discount Amount</b></td>
                                        <td><input type='number' name="amount" id="amount"  max=<?php if( $studentDetails[0]->admissiontypeid ==1){ echo "10000"; }elseif( $studentDetails[0]->admissiontypeid ==3){ echo "5000"; }?> required /></td>
                                    </tr>
                                     <tr>
                                        <td><b>Select Invoice Id</b></td>
                                        <td>
                                     <select name="InvoiceId" class="form-control mb" required>
                                        <option value="">Invoice Id</option>
                                        <?php
                                        foreach ($feesDetails as $otherFees) :
                                            if($studentDetails[0]->batchid==$otherFees->batchid){
                                        ?>
                                           <option value="<?php echo $otherFees->invoiceid; ?>"><?php echo $otherFees->invoiceid; ?> => <?php echo $otherFees->TotalValue; ?></option>
                                        <?php
                                            }
                                        endforeach;
                                        ?>
                                     </select>
                                  </td>
                                   <td><b>Additional Details</b></td>
                                        <td><textarea name="additionaldetails" required rows="4" cols="50"></textarea></td>
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