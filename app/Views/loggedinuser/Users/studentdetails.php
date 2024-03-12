<?php

use App\Models\PaymentsModel;
use App\Models\WalletModel;
use App\Models\ReservationModel;
 use App\Models\HelperModel;
 use App\Models\UsersModel;
if ($quickStudent == 1) :
?>
   <div class="content-wrapper">
      <div class="container-fluid">
         <?php
         if(empty($StudentDetails))
         {
            $UsersModel = new UsersModel();
            $StudentDetail = $UsersModel->getStudentDetails($_GET['id'],$_SESSION['activebatch']);
            $orgDate = $StudentDetail[0]->dateofbirth; 
            $newDate = date("d-m-Y", strtotime($orgDate));  
            $orgDate1 = $StudentDetail[0]->admissiondate; 
            $newDate1 = date("d-m-Y", strtotime($orgDate1)); 
            $code = $_SESSION['college_code'];
            $code = explode(",",$code);
                                    
                                    
             ?>
            <form method="post" action="<?php echo base_url('users/insertQuickstudent') ?>">
               <div class="row">
                  <div class="col-md-12">
                     <h2 class="page-title">Student Details
                     </h2>
                     <div class="row">
                        <div class="col-md-12">
                           <label class="text-uppercase text-sm">Application Number</label>
                           <input type="text" class="form-control mb" value="<?php echo $StudentDetail[0]->applicationnumber ?>" disabled>
                           <input type="hidden" name="application_number" class="form-control mb" value="<?php echo $StudentDetail[0]->applicationnumber ?>" >
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Tc Number</label>
                           <input type="text" placeholder="Tc Number" id="tc_no" name="tc_no" class="form-control mb">
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Year</label>
                           <input type="text" placeholder="Year" id="year" name="year" class="form-control mb">
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Admission Number</label>
                           <input type="text" placeholder="Admission Number" id="admission_no" name="admission_no" class="form-control mb">
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Admission Year</label>
                           <input type="text" placeholder="Admission Year" id="admission_year" name="admission_year" class="form-control mb">
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">College Code
                          
                           </label>
                           <select id="college_code" name="college_code" style="width: 100%;" class="form-control" >
                               <option value="">Select code</option>
                                   <?php
                                   foreach ($code as $codes) :
                                  ?>
                                        <option value="<?php echo $codes; ?>"><?php echo $codes ?></option>
                                    <?php
                                    endforeach;
                                   ?>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">RC Number</label>
                           <input type="text" placeholder="Rc Number" id="rc_no" name="rc_no" class="form-control mb">
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Address</label>
                           <input type="text" placeholder="Address" id="address" name="address" class="form-control mb">
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Place</label>
                           <input type="text" placeholder="Place" id="place" name="place" class="form-control mb">
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">District</label>
                           <input type="text" placeholder="District" id="district" name="district" class="form-control mb">
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Student Name</label>
                           <input type="text" name='name' class="form-control mb" value="<?php echo $StudentDetail[0]->name ?>">
                        </div>
                      
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Father Name/ Guardian Name</label>
                           <input type="text" name='fathername' class="form-control mb" value="<?php echo $StudentDetail[0]->fathername ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Mother Name</label>
                           <input type="text" name='mothername' class="form-control mb" value="<?php echo $StudentDetail[0]->mothername ?>" >
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Date Of Birth</label>
                           <input type="text" name=dob class="form-control mb" value="<?php echo $newDate ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Nationality-Religion</label>
                           <input type="text" name='nationality' class="form-control mb" value="<?php echo $StudentDetail[0]->nationalityname.'-'.$StudentDetail[0]->religionname ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Caste</label>
                           <input type="text" placeholder="Caste" id="caste" name="caste" class="form-control mb"  required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Sub Caste</label>
                           <input type="text" placeholder="Sub Caste" id="subcaste" name="subcaste" class="form-control mb"  >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">First Language</label>
                           <input type="text" placeholder="Caste" id="firstlanguage" name="firstlanguage" class="form-control mb" required>
                        </div>
                         
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Second Language</label>
                           <input type="text" placeholder="Caste" id="secondlanguage" name="secondlanguage" class="form-control mb" required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Optionals</label>
                           <input type="text" placeholder="Caste" id="secondlanguage" name="optionals" class="form-control mb" required>
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Mother Tounge</label>
                           <input type="text" placeholder="Caste" id="mothertounge" name="mothertounge" class="form-control mb" required>
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Medium</label>
                           <input type="text" placeholder="Caste" id="medium" name="medium" class="form-control mb"  required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Eligible</label>
                           <input type="text" placeholder="eligible" id="eligible" name="eligible" class="form-control mb"  required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Class</label>
                           <input type="text" placeholder="Class" id="class" name="class" class="form-control mb" required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Admission Date</label>
                           <input type="text" class="form-control mb" name="admission_date" value="<?php echo $newDate1; ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Classed Joined</label>
                           <input type="text" name='class_joined' class="form-control mb"  >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Qualified</label>
                           <input type="text" name='qualified' class="form-control mb" value="YES" >
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Scholarship</label>
                           <input type="text" name='scholarship' class="form-control mb" value="YES" >
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Concession</label>
                           <input type="text" name='concession' class="form-control mb" value="NO" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Date Left</label>
                           <input type="text" name='date_left' class="form-control mb" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">TC Date</label>
                           <input type="text" name='tc_date' class="form-control mb" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Conduct</label>
                           <input type="text" name='conduct' class="form-control mb" value="SATISFACTORY">
                        </div>
                        
                        
                       
                        <div class="col-md-3">
                           <br />
                           <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         <?php
            
         }
         else
         {
         
         foreach ($StudentDetails as $StudentDetail) :
           
         ?>
            <form method="post" action="<?php echo base_url('users/updateQuickstudent') ?>">
               <div class="row">
                  <div class="col-md-12">
                     <h2 class="page-title">Student Details
                        <?php
                        if ($StudentDetail->applicationstatusname == "Dropped Out") {
                           echo "<span style='color:red'>Student Dropped Out<span>";
                        }
                        ?>
                     </h2>
                     <div class="row">
                        <div class="col-md-12">
                           <label class="text-uppercase text-sm">Application Number</label>
                           <input type="text" class="form-control mb" value="<?php echo $StudentDetail->application_number ?>" disabled>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">College Code</label>
                           <input type="text" placeholder="Board Code" id="college_code" name="college_code" class="form-control mb" value="<?php echo $StudentDetail->college_code ?>" disabled>
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Student Name</label>
                           <input type="text" name='name' class="form-control mb" value="<?php echo $StudentDetail->name ?>">
                        </div>
                      
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Father Name/ Guardian Name</label>
                           <input type="text" name='fathername' class="form-control mb" value="<?php echo $StudentDetail->fathername ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Mother Name</label>
                           <input type="text" name='mothername' class="form-control mb" value="<?php echo $StudentDetail->mothername ?>" >
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Date Of Birth</label>
                           <input type="text" name=dob class="form-control mb" value="<?php echo $StudentDetail->dob ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Nationality-Religion</label>
                           <input type="text" name='nationality' class="form-control mb" value="<?php echo $StudentDetail->nationality ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Caste</label>
                           <input type="text" placeholder="Caste" id="caste" name="caste" class="form-control mb" value="<?php echo $StudentDetail->caste ?>" required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Sub Caste</label>
                           <input type="text" placeholder="Sub Caste" id="subcaste" name="subcaste" class="form-control mb" value="<?php echo $StudentDetail->subcaste ?>" >
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">First Language</label>
                           <input type="text" placeholder="Caste" id="firstlanguage" name="firstlanguage" class="form-control mb" value="<?php echo $StudentDetail->first_language ?>" required>
                        </div>
                         
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Second Language</label>
                           <input type="text" placeholder="Caste" id="secondlanguage" name="secondlanguage" class="form-control mb" value="<?php echo $StudentDetail->second_language ?>" required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Optionals</label>
                           <input type="text" placeholder="Caste" id="secondlanguage" name="optionals" class="form-control mb" value="<?php echo $StudentDetail->optionals ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Mother Tounge</label>
                           <input type="text" placeholder="Caste" id="mothertounge" name="mothertounge" class="form-control mb" value="<?php echo $StudentDetail->mother_tounge ?>" required>
                        </div>
                        <div class="col-md-3">
                           <label class="text-uppercase text-sm">Medium</label>
                           <input type="text" placeholder="Caste" id="medium" name="medium" class="form-control mb" value="<?php echo $StudentDetail->medium ?>" required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Eligible</label>
                           <input type="text" placeholder="eligible" id="eligible" name="eligible" class="form-control mb" value="<?php echo $StudentDetail->eligible ?>" required>
                        </div>
                         <div class="col-md-3">
                           <label class="text-uppercase text-sm">Qualified</label>
                           <input type="text" placeholder="eligible" id="qualified" name="qualified" class="form-control mb" value="<?php echo $StudentDetail->qualified ?>" required>
                        </div>
                          <div class="col-md-3">
                           <label class="text-uppercase text-sm">Conduct</label>
                           <input type="text" name='conduct' class="form-control mb" value="<?php echo $StudentDetail->conduct ?>"  required>
                        </div>
                       
                        <div class="col-md-3">
                           <br />
                           <input type="hidden" id="userid" name="userid" value="<?php echo $StudentDetail->id; ?>" />
                           <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
         <?php
         endforeach;
         }
         ?>
      </div>
   </div>
   
   
 
<?php
else :
?>
   <div class="content-wrapper">
      <div class="container-fluid">
         <?php
         $aa = 0;
         foreach ($StudentDetails as $StudentDetail) :
             
         ?>
            <div class="row">
               <div class="col-md-12">
                  <h2 class="page-title">Student Details - <?php echo $StudentDetail->batchname;?>
                     <?php
                     if ($StudentDetail->applicationstatusname != "Dropped Out") {
                        if ($_SESSION['userdetails']->rolename == "CFO" || $_SESSION['userdetails']->rolename == "Super Admin" || $_SESSION['userdetails']->userid == 7181) {
                     ?>
                           <a href="<?php echo base_url('users/dropstudent?id=') . $userid ?>" class="btn btn-danger">Mark as Dropped Out</a>
                     <?php
                        }
                     } else {
                        echo "<span style='color:red'>Student Dropped Out<span>";
                     }
                     ?>

                  </h2>
                  <a><?php echo "https://resonancehyderabad.com/maidendrop/users/student_form?uniqueid={$StudentDetail->uniqueid}" ?></a>
                  <br /><br />
                  <div class="row">
                     <div class="col-md-12">
                        <ul class="nav nav-pills red">
                           <li class="nav-item active"><a class="nav-link active" data-toggle="tab" href="#summary_<?php echo $StudentDetail->batchid;?>">Summary</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile_<?php echo $StudentDetail->batchid;?>">Profile</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#invoices_<?php echo $StudentDetail->batchid;?>">Invoices</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Payments_<?php echo $StudentDetail->batchid;?>">Payments</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#inventory_<?php echo $StudentDetail->batchid;?>">Inventory</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#wallet_<?php echo $StudentDetail->batchid;?>">Wallet</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Enrollments_<?php echo $StudentDetail->batchid;?>">Remarks</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#idcard_<?php echo $StudentDetail->batchid;?>">Issue Id Card</a></li>
                           <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Forms_<?php echo $StudentDetail->batchid;?>">Forms</a></li>
                           <?php
                            $helperModel = new HelperModel();
                                           $promoted = $helperModel->studentpromoteddiscount($StudentDetail->userid);
                                           if($promoted ==  1)
                                           {
                                               ?>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Promote_<?php echo $StudentDetail->batchid;?>">Promote</a></li>

                                               <?php
                                           }
                                           ?>
                        </ul>
                        <div class="tab-content">
                           <div id="summary_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade in active">
                              <br />
                              <div class="col-md-2">
                                 <img id="output_image" src="<?php echo file_exists("uploads/{$userid}/photo.jpeg") ? base_url("uploads/{$userid}/photo.jpeg") :  base_url('images/user-image.png') ?>" width="140"><br />
                                 <form method="post" enctype="multipart/form-data" action="<?php echo base_url('users/uploadphoto') ?>">
                                    <input accept="image/*" onchange="preview_image(event)" type="file" style="display: none;" id="student_photo" name="student_photo" class="form-control mb" />
                                    <input type="hidden" name="student_id" value="<?php echo $userid; ?>" class="form-control mb" />

                                    <br />
                                    <button type="submit" name="add_photo" class="btn btn-primary">Upload Photo</button>
                                 </form>
                                 <br />

                                 <div id="divprint" style="display: none;"></div>

                                 <div id="studentdata" style="display: none;"><?php echo json_encode($StudentDetail); ?></div>
                                 <div id="boardlookup" style="display: none;"><?php echo $lookups['boardlookup_json']; ?></div>
                              </div>
                              <div class="col-md-5">
                                 <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                          <th style="background-color: #00203d; color: white;" colspan="3">Personal Details</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td><b>Name</td>
                                          <td colspan="2"><?php echo $StudentDetail->name ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Date of Birth</td>
                                          <td colspan="2"><?php echo date_format(date_create($StudentDetail->dateofbirth), 'd/m/Y') ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Mobile</td>
                                          <td colspan="2"><?php echo $StudentDetail->mobile1 ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>E-Mail</td>
                                          <td colspan="2"><?php echo $StudentDetail->email ?></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>

                              <div class="col-md-5">
                                 <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                          <th style="background-color: #00203d; color: white;" colspan="3">Course Details</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td><b>Course</td>
                                          <td colspan="2"><?php echo $StudentDetail->coursename ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Admission Type</td>
                                          <td colspan="2"><?php echo $StudentDetail->admissiontypename ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Admission Date</td>
                                          <td colspan="2"><?php echo date_format(date_create($StudentDetail->admissiondate), 'd/m/Y') ?></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>

                              <div class="col-md-5">
                                 <table class="table table-bordered">
                                    <thead>
                                       <tr>
                                          <th style="background-color: #00203d; color: white;" colspan="3">Payment Details</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                          <td><b>Total Fees</td>
                                          <td colspan="2"><?php
                                          
                                          //print_r($InvoiceDetails);
                                       // print_r($InvoiceDetails);
                                            $TotalValue=0;
                                            foreach ($InvoiceDetails as $result) :
                                                if($StudentDetail->batchid==$result->batchid){
                                            $TotalValue = $TotalValue+$result->TotalValue; 
                                                }
                                            endforeach;
                                            echo  $TotalValue.'.00';
                                          ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Fees Paid</td>
                                          <td colspan="2"><?php 
                                          //print_r($InvoiceDetails);
                                           $TotalPaid=0;
                                            foreach ($InvoiceDetails as $result1) :
                                                if($StudentDetail->batchid==$result1->batchid){
                                                    $TotalPaid = $result1->TotalPaid; 
                                                }
                                            endforeach;
                                            $myString =  $StudentDetail->applicationnumber ;
                                            if ($myString > 220001 && $aa==0) {
                                                $TotalPaid = $TotalPaid-2500;
                                                echo  $TotalPaid.".00";
                                                
                                                
                                            }else{
                                                                                        echo  $TotalPaid;
                                            }
                                          ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Remaining Fees</td>
                                          <td colspan="2"><?php 
                                          
                                         $RemainingAmount=0;
                                            foreach ($InvoiceDetails as $result1) :
                                                if($StudentDetail->batchid==$result1->batchid){
                                            $RemainingAmount = $RemainingAmount+$result1->RemainingAmount; 
                                                }
                                            endforeach;
                                             
                                            echo $TotalValue - $TotalPaid.'.00';
                                          ?>
                                          </td>
                                       </tr>
                                       <?php
                                       /* foreach ($InvoiceDetails as $result) :
                                          if($result->batchid==$StudentDetail->batchid){
                                             $paymentsModel = new PaymentsModel();
                                             $Totalfee = $paymentsModel->getSingleStudentInvoiceDetails($StudentDetail->userid,$StudentDetail->batchid);
                                             foreach($Totalfee as $fee):
                                             if($fee->batchid==$StudentDetail->batchid){
                                            ?>
                                       <tr>
                                          <td><b>Total Fees</td>
                                          <td colspan="2"><?php if($StudentDetail->batchid==1)
                                          {
                                             echo $InvoiceDetails[0]->TotalPaid;
                                          }elseif($StudentDetail->batchid==2)
                                          {
                                          $TotalValue=0;
                                 foreach ($InvoiceDetails as $result) :
                                 $TotalValue = $TotalValue+$result->TotalValue; 
                                       endforeach;
                                       echo  $TotalValue;
                                    } ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Fees Paid</td>
                                          <td colspan="2"><?php echo $fee->TotalPaid; ?></td>
                                       </tr>
                                       <tr>
                                          <td><b>Remaining Fees</td>
                                          <td colspan="2"><?php echo $TotalValue-$InvoiceDetails[0]->TotalPaid; ?></td>
                                       </tr>
                                       <?php
                                             }
                                    endforeach;

                                    } ?>
                                        <?php
                                                endforeach; */
                                                ?>
                                    </tbody>
                                 </table>
                              </div>

                           </div>

                           <div id="profile_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                              <br />
                              <form method="post" id="editstudentform" action="<?php echo base_url('users/updatestudent/'.$StudentDetail->batchid) ?>">

                                 <ul class="nav nav-tabs">
                                    <li class="active"><a id="EditBasicTab" data-toggle="tab" href="#Editbasic_<?php echo $StudentDetail->batchid;?>">Basic Details</a></li>
                                    <li><a id="EditFamilyTab" data-toggle="tab" href="#Editfamily_<?php echo $StudentDetail->batchid;?>">Family Details</a></li>
                                    <li><a id="EditEducationTab" data-toggle="tab" href="#Editeducation_<?php echo $StudentDetail->batchid;?>">Education Details</a></li>
                                    <li><a id="EditContactTab" data-toggle="tab" href="#Editcontact_<?php echo $StudentDetail->batchid;?>">Contact Details</a></li>
                                    <li><a id="EditFeesTab" data-toggle="tab" href="#EditFees_<?php echo $StudentDetail->batchid;?>">Fees Details</a></li>
                                    <li><a id="EditApplicationTab" data-toggle="tab" href="#Editapplication_<?php echo $StudentDetail->batchid;?>">Application Details</a></li>
                                 </ul>
                                 <div class="tab-content tab-validate">
                                    <div id="Editbasic_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade in active">
                                       <br>
                                       <div class="row">
                                          <div class="col-md-6">

                                             <label class="text-uppercase text-sm">Student Name</label>
                                             <input type="text" placeholder="Name" id="name" name="name" class="form-control mb" value="<?php echo $StudentDetail->name ?>" required>
                                          </div>
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Date Of Birth</label>
                                             <input type="text" placeholder="dd/mm/yy" id="dateofbirth" name="dateofbirth" class="form-control mb datepicker" value="<?php echo date_format(date_create($StudentDetail->dateofbirth), 'd/m/Y') ?>">
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error')" id="genderid" name="genderid" style="width: 100%;" class="select2 form-control mb select">
                                                <option value="">Select Gender</option>
                                                <?php
                                                foreach ($lookups['genderlookup'] as $gender) :
                                                ?>
                                                   <option <?php echo $StudentDetail->genderid == $gender->genderid ? "selected" : ""; ?> value="<?php echo $gender->genderid; ?>"><?php echo $gender->gendername; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                             <br />
                                             <br />
                                          </div>
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error')" id="categoryid" name="categoryid" style="width: 100%;" class="select2 form-control mb">
                                                <option value="">Select Category</option>
                                                <?php
                                                foreach ($lookups['categorylookup'] as $category) :
                                                ?>
                                                   <option <?php echo $StudentDetail->categoryid == $category->categoryid ? "selected" : "" ?> value="<?php echo $category->categoryid; ?>"><?php echo $category->categoryname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error')" id="nationalityid" name="nationalityid" style="width: 100%;" class="select2 form-control mb">
                                                <option value="">Select Nationality</option>
                                                <?php
                                                foreach ($lookups['nationalitylookup'] as $nationality) :
                                                ?>
                                                   <option <?php echo $StudentDetail->nationalityid == $nationality->nationalityid ? "selected" : "" ?> value="<?php echo $nationality->nationalityid; ?>"><?php echo $nationality->nationalityname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                             <br />
                                             <br />
                                          </div>
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error')" id="religionid" name="religionid" style="width: 100%;" class="select2 form-control mb">
                                                <option value="">Select Religion</option>
                                                <?php
                                                foreach ($lookups['religionlookup'] as $religion) :
                                                ?>
                                                   <option <?php echo $StudentDetail->religionid == $religion->religionid ? "selected" : "" ?> value="<?php echo $religion->religionid; ?>"><?php echo $religion->religionname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Aadhaar Number</label>
                                             <input type="text" placeholder="Aadhaar Number" id="studentaadhaar" name="studentaadhaar" class="form-control mb" value="<?php echo $StudentDetail->studentaadhaar ?>">
                                          </div>
                                       </div>
                                    </div>
                                    <div id="Editfamily_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                       <br>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Father Name/ Guardian Name</label>
                                             <input type="text" placeholder="Father Name" id="fathername" name="fathername" class="form-control mb" value="<?php echo $StudentDetail->fathername ?>">
                                          </div>
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Mother Name</label>
                                             <input type="text" placeholder="Mother Name" id="mothername" name="mothername" class="form-control mb" value="<?php echo $StudentDetail->mothername ?>">
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Parent Occupation</label>
                                             <input type="text" placeholder="Parent Occupation" id="parentoccupation" name="parentoccupation" class="form-control mb" value="<?php echo $StudentDetail->parentoccupation ?>">
                                          </div>
                                       </div>
                                    </div>
                                    <div id="Editeducation_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                       <br>
                                       <?php
                                       $PreviousClassesInfo = json_decode($StudentDetail->previous_class_information);
                                       if ($PreviousClassesInfo != "") {
                                          foreach ($PreviousClassesInfo as $classInfo) {
                                             $classInfo = $classInfo;
                                          }
                                       }
                                       ?>
                                       <h3><label>Last Studied Information</label></h3>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Board</label>
                                             <select id="board" name="board" style="width: 100%;" class="select2 form-control mb">
                                                <?php
                                                foreach ($lookups['boardlookup'] as $board) :
                                                ?>
                                                   <option <?php echo $classInfo->board == $board->boardid ? "selected" : "" ?> value="<?php echo $board->boardid; ?>"><?php echo $board->boardname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                             <br />
                                             <br />
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">School</label>
                                             <input type="text" placeholder="School Name" id="school" name="school" class="form-control mb" value="<?php echo $classInfo->school ?>">
                                          </div>
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Place</label>
                                             <input type="text" placeholder="Place" id="place" name="place" class="form-control mb" value="<?php echo $classInfo->place ?>">
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Grade/ Marks</label>
                                             <input type="text" placeholder="Grade/ Marks" id="grade" name="grade" class="form-control mb" value="<?php echo $classInfo->grade ?>">
                                          </div>
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">HallTicket No.</label>
                                             <input type="text" placeholder="HallTicket No." id="hallticketNo" name="hallticketNo" class="form-control mb" value="<?php echo $classInfo->hallticketNo ?>">
                                          </div>
                                       </div>
                                    </div>
                                    <div id="Editcontact_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                       <br>
                                       <?php
                                       $Address = json_decode($StudentDetail->address);
                                       $permanentAddress = $Address->permanent;
                                       ?>
                                       <h3><label>Address</label>
                                       </h3>

                                       <div class="row">
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Door No./ Street Name</label>
                                             <input type="text" placeholder="Door No./ Street Name" id="door_street" name="door_street" class="form-control mb" value="<?php echo $permanentAddress->door_street ?>">
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">State</label>
                                             <select onchange="getdistricts_perm(this.value);" id="state" name="state" style="width: 100%;" class="select2 form-control mb">
                                                <option value="">Select State</option>
                                                <?php
                                                foreach ($lookups['stateslookup'] as $state) :
                                                ?>
                                                   <option <?php echo $permanentAddress->state == $state->state_id ? "selected" : "" ?> value="<?php echo $state->state_id; ?>"><?php echo $state->state_name; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">District</label>
                                             <select id="district" name="district" style="width: 100%;" class="select2 form-control mb">
                                                <option value="">Select District</option>
                                                <?php
                                                foreach ($lookups['districtslookup'] as $district) :
                                                   if ($district->state_id == $permanentAddress->state) :
                                                ?>
                                                      <option <?php echo $permanentAddress->district == $district->district_id ? "selected" : "" ?> value="<?php echo $district->district_id; ?>"><?php echo $district->district_name; ?></option>
                                                <?php
                                                   endif;
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                       </div>

                                       <div class="row">
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">City/ Town</label>
                                             <input type="text" placeholder="City/ Town" id="city_town" name="city_town" class="form-control mb" value="<?php echo $permanentAddress->city_town ?>">
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Village/ Mandal</label>
                                             <input type="text" placeholder="Village/ Mandal" id="village_mandal" name="village_mandal" class="form-control mb" value="<?php echo $permanentAddress->village_mandal ?>">
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Pin</label>
                                             <input type="text" placeholder="Pin" id="pin" name="pin" class="form-control mb" value="<?php echo $permanentAddress->pin ?>">
                                          </div>
                                       </div>

                                       <div class="row">
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Landmark</label>
                                             <input type="text" placeholder="Landmark" id="landmark" name="landmark" class="form-control mb" value="<?php echo $permanentAddress->landmark ?>">
                                          </div>
                                       </div>

                                       <div class="row">
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Mobile 1</label>
                                             <input type="number" placeholder="Mobile 1" id="mobile1" name="mobile1" class="form-control mb" value="<?php echo $StudentDetail->mobile1 ?>" required>
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Mobile 2</label>
                                             <input type="number" placeholder="Mobile 2" id="mobile2" name="mobile2" class="form-control mb" value="<?php echo $StudentDetail->mobile2 ?>">
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Email Address</label>
                                             <input type="text" placeholder="Email Address" id="email" name="email" class="form-control mb" value="<?php echo $StudentDetail->email ?>">
                                          </div>
                                       </div>
                                    </div>

                                    <div id="EditFees_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                       <br />

                                       <!-- <?php

                                             foreach ($InvoiceDetails as $result) :
                                                $paymentsModel = new PaymentsModel();
                                                $eachInvoice = $paymentsModel->getInvoiceDetailsByInvoiceId($result->invoiceid, $_SESSION['activebatch']);
                                                $TotalDetails = $paymentsModel->getInvoiceDetails($StudentDetail->userid);

                                                foreach ($eachInvoice as $eachFees) :
                                             ?>
                                          <b><?php echo $eachFees->feetype ?></b> -
                                          <?php echo $eachFees->feesvalue ?><br />
                                    <?php endforeach;
                                                echo "-------------------------------------------------------<br />";
                                                echo "<b>Total Fees</b>: " . $TotalDetails[0]->TotalValue . "<br />";
                                                echo "<b>Paid Fees</b>: " . $TotalDetails[0]->TotalPaid . "<br />";
                                                echo "-------------------------------------------------------<br />";
                                                echo "<b>Remaining Fees</b>: " . $TotalDetails[0]->RemainingAmount . "<br />";


                                             endforeach; ?> -->

                                       <br />
                                       <?php
                                       $chequeDetails = json_decode($StudentDetail->cheque_details);
                                       ?>

                                       <?php
                                       if ($StudentDetail->applicationstatusname <> "Approved") : ?>
                                          <div class="row">
                                             <div class="col-md-4">
                                                <label class="text-uppercase text-sm">Final Tuition Fees</label>
                                                <input type="number" name="tuition_discount" value="<?php echo $StudentDetail->tuition_discount ?>" class='form-control mb' />
                                             </div>
                                             <div class="col-md-4">
                                                <label class="text-uppercase text-sm">Final Hostel Fees</label>
                                                <input type="number" name="hostel_discount" value="<?php echo $StudentDetail->hostel_discount ?>" class='form-control mb' />
                                             </div>
                                             <div class="col-md-4">
                                                <label class="text-uppercase text-sm">Comments</label>
                                                <input type='text' name='comments' value="<?php echo $StudentDetail->comments ?>" class='form-control mb'>
                                                <span id="fees_total"></span>
                                             </div>
                                          </div>
                                       <?php
                                       endif; ?>
                                        <?php if($chequeDetails){ ?>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Cheque 1</label>
                                             <input type="text" name="cheque_1" value="<?php echo $chequeDetails[0]; ?>" class="form-control mb">
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Cheque 2</label>
                                             <input type="text" name="cheque_2" value="<?php echo $chequeDetails[1]; ?>" class="form-control mb">
                                          </div>
                                          <div class="col-md-4">
                                             <label class="text-uppercase text-sm">Cheque 3</label>
                                             <input type="text" name="cheque_3" value="<?php echo $chequeDetails[2]; ?>" class="form-control mb">
                                          </div>
                                       </div>
                                       <?php } ?>
                                    </div>

                                    <div id="Editapplication_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                       <br>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Application Number</label>
                                             <input type="text" placeholder="Application Number" id="applicationnumber" name="applicationnumber" class="form-control" value="<?php echo $StudentDetail->applicationnumber ?>" disabled required>
                                          </div>
                                          <?php if($StudentDetail->reservation_ukey !=''  || $StudentDetail->reservation_ukey !=NULL)
                                          {
                                              $reservationModel = new ReservationModel();
				$reservationid =  $reservationModel->getReservationDetail($StudentDetail->reservation_ukey);
			//	print_r($reservationid->reservationid);
                                              ?>
                                              <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Reservation Number</label><br>
                                            <a href="reservationDetails?id=<?php echo $reservationid->reservationid ?>" target='_blank'><?php echo $StudentDetail->reservation_ukey ?></a>
                                          </div>
                                              <?php
                                          }
                                          ?>
                                       </div>
                                       <br />
                                       <div class="row">
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error');" id="admissiontypeid" name="admissiontypeid" style="width: 100%;" class="select2 form-control mb" required>
                                                <option value="">Select Admission Type</option>
                                                <?php
                                                foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                                ?>
                                                   <option <?php echo $StudentDetail->admissiontypeid == $admissiontype->admissiontypeid ? "selected" : "" ?> value="<?php echo $admissiontype->admissiontypeid; ?>"><?php echo $admissiontype->admissiontypename; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                             <br />
                                             <br />
                                          </div>
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error')" id="branchid" name="branchid" style="width: 100%;" class="select2 form-control mb" required>
                                                <option value="">Select Branch</option>
                                                <?php
                                                foreach ($lookups['branchlookup'] as $branch) :
                                                ?>
                                                   <option <?php echo $StudentDetail->branchid == $branch->branchid ? "selected" : "" ?> value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error')" id="courseid" name="courseid" style="width: 100%;" class="select2 form-control mb" required>
                                                <option value="">Select Course</option>
                                                <?php
                                                foreach ($lookups['courselookup'] as $course) :
                                                ?>
                                                   <option <?php echo $StudentDetail->courseid == $course->courseid ? "selected" : "" ?> value="<?php echo $course->courseid; ?>"><?php echo $course->coursename; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                             <br />
                                             <br />
                                          </div>
                                          <div class="col-md-6">
                                             <select name="sectionid" style="width: 100%;" class="select2 form-control mb">
                                                <option value="">Select Section</option>
                                                <?php
                                                foreach ($lookups['sectionlookup'] as $section) :
                                                ?>
                                                   <option <?php echo $StudentDetail->sectionid == $section->sectionid ? "selected" : "" ?> value="<?php echo $section->sectionid; ?>"><?php echo $section->sectionname; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="row">
                                          <div class="col-md-6">
                                             <select onchange="this.classList.remove('error')" id="secondlanguageid" name="secondlanguageid" style="width: 100%;" class="select2 form-control mb" required>
                                                <option value="">Select Second Language</option>
                                                <?php
                                                foreach ($lookups['secondlanguagelookup'] as $secondlanguage) :
                                                ?>
                                                   <option <?php echo $StudentDetail->secondlanguageid == $secondlanguage->secondlanguageid ? "selected" : "" ?> value="<?php echo $secondlanguage->secondlanguageid; ?>"><?php echo $secondlanguage->secondlanguagename; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                          <div class="col-md-6">
                                          <label class="text-uppercase text-sm">Student Room Number</label>
                                             <input type="text" placeholder="Room Number" id="room" name="room" class="form-control" value="<?php echo $StudentDetail->roomnumber ?>" >
                                          </div>
                                          
                                       </div>
                                    </div>
                                 </div>
                                 <br />
                                 <input type="hidden" id="userid" name="userid" value="<?php echo $StudentDetail->userid; ?>" />
                                 <input type="hidden" name="applicationstatusname" value="<?php echo $StudentDetail->applicationstatusname ?>" />

                                 <?php
                                 if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1 || $StudentDetail->applicationstatusname == "Declined") : ?>
                                    <button type="submit" id="updatestudent" name="updatestudent" class="btn btn-primary">Update Student</button>
                                 <?php
                                 endif;
                                 ?>
                              </form>
                           </div>

                           <div id="invoices_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                              <br>
                              <?php if ($_SESSION['rights'][array_search('Invoice', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                               <?php if($StudentDetail->batchid == $_SESSION['activebatch'] && $StudentDetail->batchid==1)
                                 {
                                     ?>
                                
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addinvoice">Add Invoice</a>
                                 
                                 <?php } ?>
                              <?php
                              endif;
                              ?>
                              <br>
                              <br>

                              <table id="tblinvoices" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>InvoiceId</th>
                                       <th>Total Invoice Value</th>
                                       <?php if ($_SESSION['rights'][array_search('Invoice', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                          <th>
                                             Edit </th>
                                       <?php
                                       endif;
                                       ?>
                                       <th>Download</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                    foreach ($InvoiceDetails as $result) :
                                      if($result->batchid==$StudentDetail->batchid){
                                    ?>
                                       <tr>
                                          <td><a target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><?php echo $result->invoiceid ?></a></td>
                                          <td><?php echo $result->TotalValue ?></td>
                                          <?php if ($_SESSION['rights'][array_search('Invoice', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                             <td>
                                                <i data-toggle="modal" data-target="#editinvoice_<?php echo $result->invoiceid ?>" class="fa fa-pencil-square-o"></i>
                                                <div class="modal fade" id="editinvoice_<?php echo $result->invoiceid ?>" tabindex="-1" role="dialog">
                                                   <div class="modal-dialog" role="document" style="width: 60vw">
                                                      <div class="modal-content">
                                                         <div class="modal-header">
                                                            <h2 class="modal-title">Edit Invoice - <?php echo $result->invoiceid ?></h2>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                               <span>&times;</span>
                                                            </button>
                                                         </div>
                                                         <div class="modal-body">
                                                            <form method="post" action="<?php echo base_url('payments/editinvoice') ?>">
                                                               <div class="row">
                                                                  <div class="col-md-12">
                                                                     <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                                     <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />
                                                                     <input type="hidden" name="invoiceid" id="invoiceid" value="<?php echo $result->invoiceid ?>" />

                                                                     <table class="table ">
                                                                        <thead>
                                                                           <tr>
                                                                              <th>Fees Type</th>
                                                                              <th>Fees Value(Value should be negative for Discount)</th>
                                                                              <th>Additional Details</th>
                                                                              <th>Discount Type</th>
                                                                           </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                           <?php
                                                                           $paymentsModel = new PaymentsModel();
                                                                           $PD = $paymentsModel->getInvoiceDetailsByInvoiceId($result->invoiceid, $result->batchid);
                                                                           foreach ($PD as $each) :
                                                                           ?>
                                                                              <tr>
                                                                                 <td><?php echo $each->feetype ?></td>
                                                                                 <td><?php echo $each->feesvalue ?></td>
                                                                                 <td><?php echo $each->additionaldetails ?></td>
                                                                                 <td><?php echo $each->discountname ?></td>
                                                                              </tr>
                                                                           <?php endforeach; ?>
                                                                           <tr>
                                                                              <td>
                                                                                 <select name="feesid" class="form-control mb" required onchange="getdiscountlookup(this.value);">
                                                                                    <option value="">Select Fee Type</option>
                                                                                    <?php
                                                                                    foreach ($lookups['feestructurelookup_Other'] as $otherFees) :
                                                                                        if($_SESSION['userdetails']->userid == 1 || $_SESSION['userdetails']->userid == 6766){
                                                                                            ?>
                                                                                            <option value="<?php echo $otherFees->feesid; ?>"><?php echo $otherFees->feetype; ?></option>
                                                                                            <?php
                                                                                        }else{
                                                                                            
                                                                                        if($otherFees->feesid !=44 ){
                                                                                    ?>
                                                                                       <option value="<?php echo $otherFees->feesid; ?>"><?php echo $otherFees->feetype; ?></option>
                                                                                    <?php
                                                                                        }
                                                                                        }
                                                                                    endforeach;
                                                                                    ?>
                                                                                 </select>
                                                                              </td>
                                                                               <td class='discount_id' style='display:none'>
                                                                                 <select name="discountid" class="form-control mb">
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
                                                                              <td>
                                                                                 <div class="col-md-12">
                                                                                    <input type="number" placeholder="Invoice Amount" name="feesvalue" class="form-control mb" required>

                                                                                 </div>
                                                                              </td>
                                                                              <td>
                                                                                 <div class="col-md-12">
                                                                                    <input type="text" placeholder="additionaldetails" name="additionaldetails" class="form-control mb" required>
                                                                                 </div>
                                                                              </td>
                                                                           </tr>
                                                                        </tbody>
                                                                     </table>
                                                                  </div>
                                                               </div>
                                                               <button type="submit" name="addInvoice" class="btn btn-primary">Update Invoice</button>
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </td>
                                          <?php
                                          endif;
                                          ?>
                                          <td>
                                             <a title="View" target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><i class="fa fa-eye"></i></a>&nbsp;
                                             <a title="Download" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=download"><i class="fa fa-download"></i></a>&nbsp;
                                             <a title="Send Email" onclick="sendinvoiceemail('<?php echo $result->invoiceid ?>', '<?php echo $result->userid ?>')"><i class="fa fa-paper-plane"></i></a>
                                          </td>
                                       </tr>
                                    <?php
                                 }
                                 endforeach; ?>
                                 </tbody>
                              </table>
                           </div>

                           <div id="Payments_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                              <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                                 <br>
                                 <?php if($StudentDetail->batchid == $_SESSION['activebatch'])
                                 {
                                     ?>
                                
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addpayment">Add Payment</a>
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#createPaymentLink">Create Payment Link</a>
                                 <?php } ?>
                                 <br><br>
                              <?php endif; ?>
                              <h2>Payment Links</h2>

                              <table id="tblPayments" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>Invoice Id</th>
                                       <th>Order Id</th>
                                       <th>Payment Status</th>
                                       <th>Payment Amount</th>
                                       <th>URL</th>
                                       <th>
                                          <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                             Send Notification
                                          <?php endif; ?>
                                       </th>
                                       <th>
                                          <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                             Cancel
                                          <?php endif; ?>
                                       </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    //print_r($PaymentLinks);
                                    foreach ($PaymentLinks as $result) :
                                       if($result->batchid==$StudentDetail->batchid){
                                    ?>
                                       <tr>
                                          <td><?php echo $result->invoiceid ?></td>
                                          <td><?php echo $result->orderid ?></td>
                                          <td><?php echo $result->status == "cancelled" ? "<span class='btn-danger'>Cancelled</span>" : ($result->status == "paid" ? "<span class='btn-success'>Paid</span>" : "<span class='btn-warning'>Issued</span>") ?></td>
                                          <td><?php echo $result->amount ?></td>
                                          <td><a target="_blank" href="<?php echo $result->url ?>"><?php echo $result->url ?></a></td>
                                          <td>
                                             <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) :
                                                if ($result->status != "paid" && $result->status != "cancelled") { ?>

                                                   <a onclick="notifyByEmail('<?php echo $result->invoiceid ?>')"><i class="fa fa-envelope-o"></i></a>
                                                   &nbsp;&nbsp;&nbsp;
                                                   <a onclick="notifyBySms('<?php echo $result->invoiceid ?>')"><i class="fa fa-commenting"></i></a>

                                             <?php }
                                             endif; ?>
                                          </td>
                                          <td>
                                             <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) :
                                                echo "";
                                                if ($result->status != "paid" && $result->status != "cancelled") {
                                             ?>
                                                   <a onclick="cancelPayment('<?php echo $result->invoiceid ?>')"><i class="fa fa-ban"></i></a>
                                             <?php }
                                             endif; ?>
                                          </td>
                                       </tr>
                                    <?php
                                       }
                                 endforeach; ?>
                                 </tbody>
                              </table>
                              <br><br>
                              <h2>Payments</h2>
                              <table id="tblPayments" class="table table-striped DataTable" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>PaymentId</th>
                                       <th>Payment Status</th>
                                       <th>Payment</th>
                                       <th>Payment Date</th>
                                       <th>Payment Type</th>
                                       <th>Payment Details</th>
                                       <th>Amount Received By</th>
                                       <th>
                                          <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                             Edit
                                          <?php endif; ?>
                                           <?php 
                                           if($_SESSION['userdetails']->userid == 7269){
                                               echo "Edit";
                                           }
                                           ?>
                                       </th>
                                       <th>
                                          <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                             Delete
                                          <?php endif; ?>
                                          <?php 
                                           if($_SESSION['userdetails']->userid == 7269){
                                               echo "Delete";
                                           }
                                           ?>
                                       </th>
                                    </tr>
                                 </thead>

                                 <tbody>
                                    <?php
                                           // print_r($PaymentDetails);
                                    foreach ($PaymentDetails as $result) :
                                      
                                       if($result->batchid==$StudentDetail->batchid){
                                            
                                            ?>
                                     
                                       <tr>
                                          <td><a target="_blank" href="<?php echo base_url('payments/generatereceipt') ?>?paymentid=<?php echo $result->paymentid ?>&type=view"><?php echo $result->paymentid ?>(<?php echo $result->invoice ?>)</a></td>
                                          <td><?php echo $result->paymentstatusname ?></td>
                                          <td><?php echo $result->paymentamount ?></td>
                                          <td><?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?></td>
                                          <td><?php echo $result->paymenttypename ?></td>
                                          <td><?php echo $result->otherdetails ?></td>
                                          <td><?php echo $result->receivedby ?></td>
                                          <td>
                                              
                                              <?php
                                              
                                               if($_SESSION['userdetails']->userid == 7269){
                                                    if ($result->paymentstatusname != "Approved") :
                                              $html = "<a href='" . base_url('payments/deletepayment') . "?paymentid=" . $result->paymentid . "' class='btn-del'><i class='fa fa-trash'></i></a>";
                                                ?>
                                       <i data-toggle="modal" data-target="#editpayment" class="fa fa-pencil-square-o" onclick="editPayment('<?php echo $result->paymentid ?>','<?php echo $result->name ?>','<?php echo $result->paymenttypeid ?>','<?php echo $result->paymentamount ?>','<?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?>','<?php echo $result->otherdetails ?>','<?php echo $result->remarks ?>')"></i>

                                                <?php
                                                    endif;
                                           }
                                           ?>
                                             <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) :
                                                if ($result->paymentstatusname != "Approved") :
                                             ?>
                                                   <i data-toggle="modal" data-target="#editpayment" class="fa fa-pencil-square-o" onclick="editPayment('<?php echo $result->paymentid ?>','<?php echo $result->name ?>','<?php echo $result->paymenttypeid ?>','<?php echo $result->paymentamount ?>','<?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?>','<?php echo $result->otherdetails ?>','<?php echo $result->remarks ?>')"></i>
                                             <?php
                                                endif;
                                             endif; ?>
                                          </td>
                                          <td>
                                              <?php 
                                           if($_SESSION['userdetails']->userid == 7269){
                                              $html = "<a href='" . base_url('payments/deletepayment') . "?paymentid=" . $result->paymentid . "' class='btn-del'><i class='fa fa-trash'></i></a>";
                                                echo $html;
                                           }
                                           ?>
                                             <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                                <?php
                                                if($_SESSION['userdetails']->userid == 7269){
                                                $html = "<a href='" . base_url('payments/deletepayment') . "?paymentid=" . $result->paymentid . "' class='btn-del'><i class='fa fa-trash'></i></a>";
                                                echo $html; } ?>
                                             <?php endif; ?>
                                          </td>
                                       </tr>
                                    <?php } 
                                 endforeach; 
                                 $myString =  $StudentDetail->applicationnumber ;
                                          //  if (strpos($myString, '22000') !== false) {
                                           $myString =  $StudentDetail->applicationnumber ;
                                                if ($myString > 220001 && $aa==0) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        Note : 2500 Application Fee
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                 </tbody>
                              </table>
                             
                           </div>

                           <div id="inventory_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade in">
                              <br />
                              <div class="col-md-12">
                                 <table id="tblotherusers" class="DataTable table table-striped">
                                    <thead>
                                       <tr>
                                          <th>Product Name</th>
                                          <th>Quantity</th>
                                          <th>Date</th>
                                          <th>Print</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($Inventory as $inv) :
                                         if($StudentDetail->batchid == $inv->batchid) : 
                                          
                                       ?>
                                             <tr>
                                                <td>
                                                   <?php echo $inv->name ?>
                                                </td>
                                                 <td>
                                                   <?php echo $inv->quantity ?>
                                                </td>
                                                <td>
                                                   
                                                   <?php echo ($inv->created_timestamp != "" ?  date_format(date_create($inv->created_timestamp), 'd/m/Y') : "") ?>
                                                </td>
                                                 <td>
                                                   
                                                  <a target="_blank" href="<?php echo base_url('inventory/print_InventoryReceiptstudent') . '?userid=' . $StudentDetail->userid . '&inventorydetailsid=' . $inv->id ?>"><i class='fa fa-print'></i></a>
                                                </td>
                                             </tr>
                                       <?php
                                        endif;
                                       endforeach; ?>
                                    </tbody>
                                    <tbody>
                                 </table>
                              </div>
                           </div>

                           <div id="wallet_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                              <br>
                              <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                                 <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addMoney">Add Money</a>
                                 <br><br>
                              <?php endif; ?>
                              <h2>Wallet</h2>

                              <table class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>Wallet Type</th>
                                       <th>Balance</th>
                                       <th>Transactions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    foreach ($WalletDetails as $wallet) :
                                    ?>
                                       <tr>
                                          <td>
                                             <?php echo $wallet->wallettypename ?><br /><br />
                                             <a target="_blank" href="<?php echo base_url('wallet/print_WalletReceipt') . '?userid=' . $StudentDetail->userid . '&walletid=' . $wallet->walletid ?>"><i class='fa fa-print'></i></a>
                                          </td>
                                          <td><b style="<?php echo $wallet->amount > 0 ? 'color:green' : 'color:red' ?>"><?php echo $wallet->amount ?></b></td>
                                          <td>
                                             <table class="DataTable table table-striped" style="width: 100% !important;">
                                                <thead>
                                                   <tr>
                                                      <th>Date</th>
                                                      <th>Transaction Type</th>
                                                      <th>Payment Type</th>
                                                      <th>Amount</th>
                                                      <th>Transacted By</th>
                                                      <th>Payment Details</th>
                                                      <th>Remarks</th>
                                                      <th>Print</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                   $walletModel = new WalletModel();
                                                   $walletTransactions = $walletModel->getWalletTransactions($StudentDetail->userid, $wallet->walletid);
                                                   foreach ($walletTransactions as $transaction) :
                                                   ?>
                                                      <tr>
                                                         <td><?php echo date_format(date_create($transaction->date), 'd/m/Y') ?></td>
                                                         <td><span style="<?php echo $transaction->transactiontype == "Debit" ? 'color:red' : 'color:green' ?>"><?php echo $transaction->transactiontype ?></span></td>
                                                         <td><?php echo $transaction->paymenttypename ?></td>
                                                         <td><?php echo $transaction->amount ?></td>
                                                         <td><?php echo $transaction->name ?></td>
                                                         <td><?php echo $transaction->payment_details ?></td>
                                                         <td><?php echo $transaction->remarks ?></td>
                                                         <td><a target="_blank" href="<?php echo base_url('wallet/print_WalletTransactionReceipt') . '?userid=' . $StudentDetail->userid . '&wallettransactionid=' . $transaction->wallettransactionid ?>"><i class='fa fa-print'></i></a></td>
                                                      </tr>
                                                   <?php endforeach; ?>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                    <?php endforeach; ?>
                                 </tbody>
                              </table>
                              <br><br>
                           </div>

                           <div id="Enrollments_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                <br>
                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addremark">Add Remark</a>
                              <br><br>
                              <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>Remarks</th>
                                       <th>Remark Date</th>
                                       <th>Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                        if($StudentDetail->remarks != ''){
                                        ?>
                                          <tr>
                                             <td> <?php echo $StudentDetail->remarks ?>
                                          </td>
                                           
                                             <td> <?php echo $StudentDetail->remarkdate ?>
                                          </td>
                                             <td>
                                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editremark"> <i class='fa fa-pencil'></i></
                                             </td>
                                          </tr>
                                    <?php
                                        }
                                        ?>
                                    
                                 </tbody>
                              </table>
                           </div>
                           
                            <div id="idcard_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                <br>
                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addidcard">Issue Id Card</a>
                              <br><br>
                              <table id="tblenrollments" class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>Id Card</th>
                                       <th>Actions</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                        <?php
                                        if($StudentDetail->rfid != ''){
                                        ?>
                                          <tr>
                                             <td> <?php echo $StudentDetail->rfid ?>
                                          </td>
                                             <td>
                                               <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#editidcard"> <i class='fa fa-pencil'></i></
                                             </td>
                                          </tr>
                                    <?php
                                        }
                                        ?>
                                 </tbody>
                              </table>
                           </div>

                           <div id="Forms_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                              <br />
                              <h2>My Forms</h2>
                              <table class="DataTable table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>Form Type</th>
                                       <th>Data</th>
                                       <th>Status</th>
                                       <th>Created By</th>
                                       <th>Updated By</th>
                                       <th>Created Date</th>
                                       <th>Print</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    if ($forms != null) :
                                       foreach ($forms as $form) :
                                    ?>
                                          <tr>
                                             <td><?php echo $form->form_type ?></td>
                                             <td><?php foreach (json_decode($form->data) as $key => $row) {
                                                /*  if($key == "discountby")
                                                  {
                                                        $UsersModel = new UsersModel();
                                                        $Detail = $UsersModel->getEmployeename($row);
                                                        print_r("<b>Discount Requested By :</b> ".$Detail[0]->name);
                                                        echo "<br>";
                                                  }else */
                                                  if($key == "discountid")
                                                  {
                                                      $UsersModel = new UsersModel();
                                                        $Detail = $UsersModel->getDiscounttype($row);
                                                        print_r("<b>Discount Type : </b>".$Detail[0]->discountname);
                                                        echo "<br>";
                                                  }
                                                  else{
                                                      echo "<b>" . $key . "</b>: " . $row . "<br />";
                                                  }
                                                   } ?></td>
                                             <td><?php echo $form->status ?></td>
                                             <td><?php echo $form->CreatedBy ?></td>
                                             <td><?php echo $form->UpdatedBy == "" ? "-" : $form->UpdatedBy ?></td>
                                             <td><?php echo date_format(date_create($form->created_timestamp), 'd/m/Y') ?></td>
                                             <td>
                                                 <?php if($form->status=='approved' && $form->form_type=='StudentOutPass')
                                                 {
                                                     ?>
                                                <?php if ($_SESSION['rights'][array_search('StudentOutPass', array_column($_SESSION['rights'], 'operationname'))]->_view == 1) : ?>

                                                      <a class="btn btn-success" onclick="printDiv1('div1_<?php echo $form->form_request_id;?>')">Print</a>
                                                       <?php endif; ?>
                                                     <?php
                                                 }elseif($form->form_type=='refundApproval'){
                                                 ?>
                                                 <a class="btn btn-success" onclick="printDiv('div_<?php echo $form->form_request_id;?>')">Print</a>
                                             <?php }elseif($form->status=='approved'  && $form->form_type=='branchtransfer')
                                             {
                                                 ?>
                                                 <a class="btn btn-success" onclick="printDiv('div2_<?php echo $form->form_request_id;?>')">Print</a>
                                             <?php
                                                 
                                             }
                                             ?>
                                           
                        <div class="col-md-12" id="div1_<?php echo $form->form_request_id;?>" style="display:none">
                            <div class="scale">
                                <p><?php echo $StudentDetail->branchname.'-'.$form->gatepassid;?><span style="float:right">Student Copy</span></p>
                                <p style='font-size:10px;'>Branch Name : <?php
                                        echo $StudentDetail->branchname; ?> </p>
                                        <p style='font-size:10px;'>Date : <?php
                                        echo date('Y-m-d') ?> </p>
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="160" height="60" /></p>
                               
                                
                                <h5 style="text-align: center;"><strong><u>STUDENT OUT PASS</u></strong></h5>
                                <table style="width: 100%;margin: 0;">
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Application Number</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $StudentDetail->applicationnumber; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Student Name</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $StudentDetail->name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Section</span></td>
                                        <td ><span style="width: 50%;"><?php echo $StudentDetail->sectionname; ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Mobile</span></td>
                                        <td ><span style="width: 50%;"><?php  echo $StudentDetail->mobile1;?></span></td>
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
                                <p style='font-size:10px;'>Sign of the Student
                                <span style="margin-left:100px;">Sign of the Parent</span>
                                <span style="margin-left:160px;">Sign of the Vice-Principal</span>
                                    <span style="float:right">Sign of the Principal</span>
                                </p>
                            </div>
                         
                            
                            <hr>
                            <div class="scale">
                                 <p><?php echo $StudentDetail->branchname.'-'.$form->gatepassid;?><span style="float:right">Security Copy</span></p>
                                 <p style='font-size:10px;'>Branch Name : <?php
                                        echo $StudentDetail->branchname; ?> </p>
                                        <p style='font-size:10px;'>Date : <?php
                                        echo date('Y-m-d') ?> </p>
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="160" height="60" /></p>
                               
                                <h5 style="text-align: center;"><strong><u>STUDENT OUT PASS</u></strong></h5>
                                <table style="width: 100%;margin: 0;">
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Application Number</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $StudentDetail->applicationnumber; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Student Name</span></td>
                                        <td ><span style="width: 50%;"><?php
                                        echo $StudentDetail->name; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Section</span></td>
                                        <td ><span style="width: 50%;"><?php echo $StudentDetail->sectionname; ?></span></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td ><span style="width: 50%;">Mobile</span></td>
                                        <td ><span style="width: 50%;"><?php  echo $StudentDetail->mobile1;?></span></td>
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
                               <p style='font-size:10px;'>Sign of the Student
                                <span style="margin-left:100px;">Sign of the Parent</span>
                                <span style="margin-left:160px;">Sign of the Vice-Principal</span>
                                    <span style="float:right">Sign of the Principal</span>
                                </p>
                            </div>
                            <style>
                                @media print {
                                    .scale {
                                        font-size: 16px;
                                    }
                                }
                            </style>
                        </div>
                   
                        <div class="col-md-12" id="div2_<?php echo $form->form_request_id;?>" style="display:none;">
                            <div class="scale">
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="160" height="80" /></p>
                                <br />
                                <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                <h4 style="text-align: center;"><strong><u>BRANCH TRANSFER FORM </u></strong></h4>
                                <table style="width: 100%;margin: 0;">
                                    <tr>
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Name of the Pupil</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php echo $StudentDetail->name; ?></span></td>
                                    </tr>
                                      <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Current Branch</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                            echo $StudentDetail->branchname;
                                        ?></span></td>
                                        <br>
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Destination Branch</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Branchid")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Admission Type</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "AdmissionType")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Inventory</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Inventory")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Reporting Date</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "ReportingDate")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Transfer Date</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "TransferDate")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Number Of Days Stayed In Hostel</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "DaysStayedInHostel")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Fee</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "fee")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        <br>
                                    </tr>
                                    <tr>
                                          <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Approved By</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        
                                            echo $form->UpdatedBy;
                                     
                                        ?></span></td>
                                        <br>
                                        
                                    </tr>


                                </table>
                                
                                <br />
                                 <br />
                                <p>Clerk-in-Charge
                                    <span style="float:right">PRINCIPAL</span>
                                </p>
                            </div>
                            
                        </div>
                        
                        <div class="col-md-12" id="div_<?php echo $form->form_request_id;?>" style="display:none;">
                            <div class="scale">
                                <p style="text-align: center;"><img src="<?php echo base_url('images/logo1.png') ?>" width="160" height="80" /></p>
                                <br />
                                <p style="text-align: right;">Date: <?php echo date("d-m-Y"); ?><br />Hyderabad</p>
                                <h4 style="text-align: center;"><strong><u>REFUND APPROVAL FORM </u></strong></h4>
                                <table style="width: 100%;margin: 0;">
                                    <tr>
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Application Number</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php echo $StudentDetail->applicationnumber; ?></span></td>
                                    </tr>
                                     <tr>
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Name of the Pupil</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php echo $StudentDetail->name; ?></span></td>
                                    </tr>
                                      <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Branch</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                            echo $StudentDetail->branchname;
                                        ?></span></td>
                                        <br>
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Course</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                            echo $StudentDetail->coursename;
                                        ?></span></td>
                                        
                                    </tr>
                                    
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Refund Reason</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "RefundReason")
                                            echo $row;
                                        }
                                        ?></span></td>
                                       
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Books Received</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "BooksReceived")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Inventory</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "MaterialReceived")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        
                                    </tr>
                                     <tr>
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Number Of Days Stayed In Hostel</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "DaysInHostel")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        
                                    </tr>
                                    <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Parent A/c Details (Bank) Name</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "BankName")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">Branch</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Branch")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        
                                    </tr>
                                      <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">IFSC</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;">&nbsp;<?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "IFSC")
                                            echo $row;
                                        }
                                        ?></span></td>
                                        
                                    </tr>
                                      <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">A/c No </span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "Ac/No")
                                            echo $row;
                                        }
                                        ?></span></td>
                                       
                                    </tr>
                                     <tr >
                                         <td ><span style="width: 10%;"></span></td>
                                        <td ><span style="width: 40%;">APPROVED AMOUNT ( Office Use Only )</span></td>
                                        <td ><span style="width: 10%;">:</span></td>
                                        <td ><span style="width: 40%;"><?php 
                                        foreach (json_decode($form->data) as $key => $row) {
                                            if( $key == "RefundAmount")
                                            if($row == 0)
                                            {
                                                
                                            }else{
                                            echo $row;
                                            }
                                        }
                                        ?></span></td>
                                        
                                    </tr>


                                </table>
                                <br />
                                <br />
                                <br />
                                 <br />
                                 <br />
                                <p>Clerk-in-Charge
                                    <span style="float:right">PRINCIPAL</span>
                                </p>
                            </div>
                            
                        </div>
               
                                             </td>
                                          </tr>
                                    <?php endforeach;
                                    endif; ?>
                                 </tbody>
                              </table>
                              <br />
                              <h2>Create Forms</h2>

                              <table class="table table-striped" style="width: 100% !important;">
                                 <thead>
                                    <tr>
                                       <th>Title</th>
                                       <th>Link</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                     <?php if($_SESSION['userdetails']->roleid == 2 || $_SESSION['userdetails']->roleid == 3)
                                     {
                                         ?>
                                     
                                    <!--<tr>-->
                                    <!--   <td>Fee Discount Approval Form</td>-->
                                    <!--   <td>-->
                                    <!--      <a target="_blank" href="<?php echo base_url('forms/discountApproval?userId=') . $userid.'&batchid='.$StudentDetail->batchid ?>">Click Here</a>-->
                                    <!--   </td>-->
                                    <!--</tr>-->
                                    <?php } ?>
                                    <tr>
                                       <td>Refund Approval Form</td>
                                       <td>
                                          <a target="_blank" href="<?php echo base_url('forms/refundApproval?userId=') . $userid.'&batchid='.$StudentDetail->batchid ?>">Click Here</a>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>No Due Certificate</td>
                                       <td>
                                          <a target="_blank" href="<?php echo base_url('forms/noDueCertificate?userId=') . $userid.'&batchid='.$StudentDetail->batchid ?>">Click Here</a>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Transfer Certificate</td>
                                       <td>
                                          <a target="_blank" href="<?php echo base_url().'/forms/transferCertificate?userId='.$userid.'&batchid='.$StudentDetail->batchid?>">Click Here</a>
                                       </td>
                                    </tr>
                                     <tr>
                                       <td>Branch Transfer Form</td>
                                       <td>
                                          <a target="_blank" href="<?php echo base_url('forms/branchtransfer?userId=') . $userid.'&batchid='.$StudentDetail->batchid ?>">Click Here</a>
                                       </td>
                                    </tr>
                                     <tr>
                                       <td>On-Boarding Form</td>
                                       <td>
                                          <a target="_blank" href="<?php echo base_url('users/reservationDetails?id=') . $reservationid->reservationid.'&batchid='.$StudentDetail->batchid ?>">Click Here</a>
                                       </td>
                                    </tr>
                                     <?php if ($_SESSION['rights'][array_search('StudentOutPass', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                                   <!-- <tr>
                                       <td>Student Out Pass Form</td>
                                       <td>
                                          <a target="_blank" href="<?php echo base_url('forms/outpass?userId=') . $userid.'&batchid='.$StudentDetail->batchid ?>">Click Here</a>
                                       </td>
                                    </tr>-->
                                     <?php endif; ?>
                                 </tbody>
                              </table>
                           </div>
                             <div id="Promote_<?php echo $StudentDetail->batchid;?>" class="tab-pane fade">
                                <br>
                               <?php
                                            if ($StudentDetail->applicationstatusname != "Dropped Out" && ($_SESSION['userdetails']->rolename == "CFO" || $_SESSION['userdetails']->rolename == "Super Admin" || $_SESSION['userdetails']->rolename == "Administrator" || $_SESSION['userdetails']->rolename == "Accounts") && $aa==0) :
                                           
                                             echo "<a href='" . base_url('users/promotestudent?id=') . $StudentDetail->userid . "' class='btn btn-success'>Promote</a>";
                                            
                                              endif;?>
                              <br><br>
                             
                           </div>
                           <div class=" modal fade" id="addinvoice" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Add Invoice</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('payments/addinvoice') ?>">
                                          <br>
                                          <div class="row">
                                             <div class="col-md-12">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />

                                                <label class="text-uppercase text-sm">Select Fee Type</label>
                                                <select name="feesid" style="width: 100%;" class="select2 form-control mb" required>
                                                   <option value="">Select Fee Type</option>
                                                   <?php

                                                   foreach ($lookups['feestructurelookup_Other'] as $otherFees) :
                                                   ?>
                                                      <option value="<?php echo $otherFees->feesid; ?>"><?php echo $otherFees->feetype; ?></option>
                                                   <?php
                                                   endforeach;
                                                   ?>
                                                </select>
                                             </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                             <div class="col-md-12">
                                                <label class="text-uppercase text-sm">Fees Amount (Should be negative for Discount)</label>
                                                <input type="number" placeholder="Invoice Amount" name="feesvalue" class="form-control mb" required>
                                             </div>
                                             <div class="col-md-12">
                                                <label class="text-uppercase text-sm">Additional Details</label>
                                                <input type="text" placeholder="" name="additionaldetails" class="form-control mb" required>
                                             </div>
                                          </div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary">Add Invoice</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="modal fade" id="addremark" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Add Remark</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addremark') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-3">
                                                 </div>
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />

                                                <label class="text-uppercase text-sm">Remark</label>
                                            
                                            
                                                <input type="text" placeholder="Remarks" name="remarks" class="form-control mb" required>
                                             </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="modal fade" id="editremark" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Edit Remark</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addremark') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-3">
                                                 </div>
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />

                                                <label class="text-uppercase text-sm">Remark</label>
                                            
                                            
                                                <input type="text" placeholder="Remarks" name="remarks" class="form-control mb" value="<?php echo $StudentDetail->remarks ?>" required>
                                             </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                            <div class="modal fade" id="addidcard" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Add RF Id</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addidcard') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-3">
                                                 </div>
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />

                                                <label class="text-uppercase text-sm">RF Id</label>
                                            
                                            
                                                <input type="text" placeholder="RF Id" name="rfid" class="form-control mb" required>
                                             </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="modal fade" id="editidcard" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Edit RF Id</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -45px;">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('users/addidcard') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-3">
                                                 </div>
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />

                                                <label class="text-uppercase text-sm">RF Id</label>
                                            
                                            
                                                 <input type="text" placeholder="RF Id" name="rfid" class="form-control mb" value="<?php echo $StudentDetail->rfid ?>" required>
                                             </div>
                                             <div class="col-md-3">
                                                 </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                            
                                          </div>
                                          <div>&nbsp;</div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary" style="margin-left: 236px;">Submit</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="modal fade" id="addMoney" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Credit/ Debit Money To/ From Wallet</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('Wallet/addWalletDetails') ?>">
                                          <br>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />

                                                <label class="text-uppercase text-sm">Select Wallet Type</label>
                                                <select name="wallettypeid" style="width: 100%;" class="select2 form-control mb" required>
                                                   <option value="">Select Wallet Type</option>
                                                   <?php

                                                   foreach ($lookups['wallettypelookup'] as $wallettype) :
                                                   ?>
                                                      <option value="<?php echo $wallettype->wallettypeid; ?>"><?php echo $wallettype->wallettypename; ?></option>
                                                   <?php
                                                   endforeach;
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6">
                                                <label class="text-uppercase text-sm">Select Transaction Type</label>
                                                <select name="transactiontype" style="width: 100%;" class="select2 form-control mb" required>
                                                   <option value="">Select Transaction Type</option>
                                                   <option value="Credit">Credit</option>
                                                   <option value="Debit">Debit</option>
                                                </select>
                                             </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                             <div class="col-md-6">
                                                <label class="text-uppercase text-sm">Amount</label>
                                                <input type="number" placeholder="Amount" min="0" name="amount" class="form-control mb" required>
                                             </div>
                                             <div class="col-md-6">
                                                <label class=" text-uppercase text-sm">Remarks</label>
                                                <input type="text" placeholder="Remarks" name="remarks" class="form-control mb" required>
                                             </div>
                                             <br />
                                             <br />
                                             <br />
                                             <br />
                                              <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Payment Mode</label>
                                             <!--<input type="text" placeholder="dd/mm/yy" name="date" class="form-control mb paymentdate" required>-->
                                              <select name="paymenttypeid" style="width: 100%;" class="select2 form-control mb" required>
                                                   <option value="">Select Payment Type</option>
                                                   <?php

                                                   foreach ($lookups['paymenttypelookup'] as $paymenttype) :
                                                   ?>
                                                      <option value="<?php echo $paymenttype->paymenttypeid; ?>"><?php echo $paymenttype->paymenttypename; ?></option>
                                                   <?php
                                                   endforeach;
                                                   ?>
                                                </select>
                                          </div> 
                                             <div class="col-md-6">
                                                <label class=" text-uppercase text-sm">Payment Details</label>
                                                <input type="text" placeholder="UTR No / Check No / Recipt No" name="payment_details" class="form-control mb" required>
                                             </div>
                                          </div>
                                          <button type="submit" name="addInvoice" class="btn btn-primary">Add Transaction</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="modal fade" id="addpayment" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Add Payment</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('payments/addpaymentNew') ?>">
                                          <br>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />

                                                <select name="paymenttypeid" style="width: 100%;" class="select2 form-control mb" required>
                                                   <option value="">Select Payment Type</option>
                                                   <?php

                                                   foreach ($lookups['paymenttypelookup'] as $paymenttype) :
                                                   ?>
                                                      <option value="<?php echo $paymenttype->paymenttypeid; ?>"><?php echo $paymenttype->paymenttypename; ?></option>
                                                   <?php
                                                   endforeach;
                                                   ?>
                                                </select>
                                             </div>
                                              <div class="col-md-6">
                                                  <?php
                                                 if($_SESSION['activebatch'] > 2){
                                                 ?>
                                                <select name="invoiceid" onchange="getinvoiceid1(this.value,<?php echo $userid; ?>);" style="width: 100%;" class="select2 form-control mb getinvoiceid1" required>
                                                      <option value="">Select Invoice id</option>
                                                      <?php
                                                        $UsersModel = new UsersModel();
                                                        $Detail = $UsersModel->getMaxInvoice(2,$userid);
                                                        $Detail1 = $UsersModel->getMaxPayment(2,$userid);
                                                        $inv2 = $Detail[0]->amount - $Detail1[0]->amount;
                                                        
                                                        $Detail2 = $UsersModel->getMaxInvoice(1,$userid);
                                                        $Detail3 = $UsersModel->getMaxPayment(1,$userid);
                                                        $inv1 = $Detail2[0]->amount - $Detail3[0]->amount;
                                                        //print_r($inv2);
                                                     if($inv2 > 0)
                                                        {
                                                   foreach ($InvoiceDetails as $result) :
                                                      if ($result->invoice ==2 && $result->batchid == $_SESSION['activebatch']) {
                                                   ?>
                                                      <option value="<?php echo  $result->invoiceid;?>" data-id="<?php echo  $result->invoice;?>"><?php echo  $result->invoiceid;?></option>
                                                   <?php
                                                      }
                                                   endforeach;
                                                        }elseif($inv1 > 0)
                                                        {
                                                            foreach ($InvoiceDetails as $result) :
                                                      if ($result->invoice ==1 && $result->batchid == $_SESSION['activebatch']) {
                                                   ?>
                                                      <option value="<?php echo  $result->invoiceid;?>" data-id="<?php echo  $result->invoice;?>"><?php echo  $result->invoiceid;?></option>
                                                   <?php
                                                      }
                                                   endforeach;
                                                        }
                                                   ?>
                                                </select>
                                                <?php }else
                                                {
                                                    ?>
                                                    <select name="invoiceid"  style="width: 100%;" class="select2 form-control mb" required>
                                                      <option value="">Select Invoice id</option>
                                                       <option value="2">Maidendrop Edu Foundation</option>
                                                       <option value="1">Soceity</option>
                                                      </select>
                                                    <?php
                                                }?>
                                             </div>
                                          </div>
                                          <br>
                                          <div class="row">
                                             <div class="col-md-6">
                                                <label class="text-uppercase text-sm">Payment Amount</label>( Rs.<b id="payamount"></b>)
                                                <input type="number" placeholder="Payment Amount" name="paymentamount" class="form-control mb invoice4" required>
                                                <input type="hidden" placeholder="Payment Amount" name="invoice" class="form-control mb invoice5" required style="display:none">
                                             </div>
                                             <div class="col-md-6">
                                                <label class="text-uppercase text-sm">Payment Details</label>
                                                <input type="text" placeholder="UTR No / Check No / Recipt No" name="otherdetails" class="form-control mb" required>
                                             </div>
                                          </div>
                                          <div class="row">
                                             
                                             <div class="col-md-6">
                                                <label class="text-uppercase text-sm">Remarks</label>
                                                <input type="text" placeholder="Remarks" name="remarks" class="form-control mb">
                                             </div>
                                          </div>
                                          <!-- <div class="row">
                                          <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Payment Collected By</label>
                                             <select name="paymentcollectedby" style="width: 100%;" class="select2 form-control mb" required>
                                                <option value="">Select Employee</option>
                                                <?php
                                                foreach ($EmployeeDetails as $reference) :
                                                ?>
                                                   <option value="<?php echo $reference->userid; ?>"><?php echo $reference->employeeid . " - " . $reference->name; ?></option>
                                                <?php
                                                endforeach;
                                                ?>
                                             </select>
                                          </div>
                                       </div> -->
                                          <br />
                                          <?php if($_GET['id']==10618){ 
                                              ?>
                                               <div class="row">
                                             
                                             <div class="col-md-6">
                                           <span onclick="sendotp()" id="sendotp" class="btn btn-primary">Get OTP</span>
                                           
                                           <input type="hidden" id="contact" value="<?php echo $StudentDetail->mobile1; ?>" />
                                           <input type="text" placeholder="Enter Otp" class="form-control mb"  id="otp" name="otp" style="display:none" required>
                                           </div>
                                           <div class="col-md-6">
                                          <span style="display:none" onclick="verifyotp(<?php echo $StudentDetail->userid; ?>)" id="verifybutton" class="btn btn-primary">Verify OTP</span>
                                          <button style="display:none" type="submit" name="addpayment" id="paymentverify" class="btn btn-primary">Add Payment</button>
                                          </div>
                                          </div>
                                          <?php } else
                                          {
                                              ?>
                                              <button type="submit" name="addpayment" class="btn btn-primary">Add Payment</button>
                                              <?php
                                          }
                                          ?>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="modal fade" id="createPaymentLink" tabindex="-1" role="dialog">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h2 class="modal-title">Create Payment Link</h2>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span>&times;</span>
                                       </button>
                                    </div>
                                    <div class="modal-body">
                                       <form method="post" action="<?php echo base_url('razorpay/createPaymentLink') ?>">
                                          <br>
                                          <div class="row">
                                              <div class="col-md-6">
                                                  <label class="text-uppercase text-sm">select Invoice</label>
                                             <select name="invoiceid" onchange="getinvoiceid(this.value,<?php echo $userid; ?>);" style="width: 100%;" class="select2 form-control mb getinvoiceid" required>
                                                   <option value="">Select Invoice</option>
                                                    <?php
                                                        $UsersModel = new UsersModel();
                                                        $Detail = $UsersModel->getMaxInvoice(2,$userid);
                                                        $Detail1 = $UsersModel->getMaxPayment(2,$userid);
                                                        $inv2 = $Detail[0]->amount - $Detail1[0]->amount;
                                                        $Detail2 = $UsersModel->getMaxInvoice(1,$userid);
                                                        $Detail3 = $UsersModel->getMaxPayment(1,$userid);
                                                        $inv1 = $Detail2[0]->amount - $Detail3[0]->amount;
                                                       
                                                        if($inv2 > 0)
                                                        {
                                                           foreach ($InvoiceDetails as $result) :
                                                               if($result->invoice == 2 && $result->batchid == $_SESSION['activebatch']){
                                                              ?>
                                                                        <option value="<?php echo  $result->invoiceid;?>" data-id="<?php echo  $result->invoice;?>"><?php echo  $result->invoiceid;?></option>
                                                                     <?php
                                                               }
                                                           endforeach;
                                                        }elseif($inv1 > 0)
                                                        {
                                                           foreach ($InvoiceDetails as $result) :
                                                               if($result->invoice == 1 && $result->batchid == $_SESSION['activebatch']){
                                                              ?>
                                                                        <option value="<?php echo  $result->invoiceid;?>" data-id="<?php echo  $result->invoice;?>"><?php echo  $result->invoiceid;?></option>
                                                                     <?php
                                                               }
                                                           endforeach;
                                                        }
                                                   ?>
                                             </select>
                                             </div>
                                             
                                         
                                             <div class="col-md-6">
                                                <input type="hidden" name="userid" value="<?php echo $userid; ?>" />
                                                <input type="hidden" name="contact" value="<?php echo $StudentDetail->mobile1; ?>" />
                                                <input type="hidden" name="email" value="<?php echo $StudentDetail->email; ?>" />
                                                <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />
                                                <label class="text-uppercase text-sm">Payment Amount</label>( Rs.<b id="payamount1"></b>)
                                                 <input type="number" placeholder="Payment Amount" name="amount" class="form-control mb invoice2" required>
                                                <input type="hidden" placeholder="Payment Amount" name="invoice" class="form-control mb invoice3" required style="display:none">
                                             </div>
                                             </div>
                                             <br>
                                              <div class="row">
                                             <div class="col-md-12">
                                                <label class="text-uppercase text-sm">Description</label>
                                                <input type="text" placeholder="Description" name="description" class="form-control mb" required>
                                             </div>
                                             </div>
                                             
                                             <br>
                                          
                                          <button type="submit" class="btn btn-primary">Create Payment Link</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         <?php
         $aa++;
         endforeach;
         ?>
      </div>
   </div>
    <div class="modal fade" id="editpayment" tabindex="-1" role="dialog">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h2 class="modal-title">Edit Payment</h2>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span>&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                          <form method="post" action="<?php echo base_url('payments/updatepayment') ?>">
                                             <br>
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $StudentDetail->userid; ?>" />
                                                   <input type="hidden" name="paymentid" id="paymentid" />
                                                   <label class="text-uppercase text-sm">Student Name</label>
                                                   <input type="text" id="paymentname" class="form-control mb" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="text-uppercase text-sm">Payment Type</label>
                                                   <select name="paymenttypeid" id="paymenttypeid" style="width: 100%;" class="select2 form-control mb" required>
                                                      <option value="">Select Payment Type</option>
                                                      <?php

                                                      foreach ($lookups['paymenttypelookup'] as $paymenttype) :
                                                      ?>
                                                         <option value="<?php echo $paymenttype->paymenttypeid; ?>"><?php echo $paymenttype->paymenttypename; ?></option>
                                                      <?php
                                                      endforeach;
                                                      ?>
                                                   </select>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <label class="text-uppercase text-sm">Payment Amount</label>
                                                   <input type="number" id="paymentamount" readonly class="form-control mb" required>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="text-uppercase text-sm">Payment Details</label>
                                                   <input type="text" id="otherdetails" name="otherdetails" class="form-control mb" required>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <label class="text-uppercase text-sm">Payment Date</label>
                                                   <input type="text" id="paymentdate" readonly class="form-control mb" required>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="text-uppercase text-sm">Remarks</label>
                                                   <input type="text" id="remarks" placeholder="Remarks" name="remarks" class="form-control mb">
                                                </div>
                                             </div>
                                             <br />
                                             <button type="submit" name="updatepayment" class="btn btn-primary">Update Payment Details</button>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
   <style>
      input.error {
         border-color: #f00 !important;
      }

      select.error+span>span>span {
         border-color: #f00 !important;
      }

      small.required {
         color: #f00;
      }

      .error {
         color: red;
      }
   </style>
     
   <script>
   
                        function printDiv(divName) {
                            var printContents = document.getElementById(divName).innerHTML;
                            var originalContents = document.body.innerHTML;

                            document.body.innerHTML = printContents;
                            
                            window.print();

                            document.body.innerHTML = originalContents;
                        }
                        function printDiv1(divName) {
                            var printContents = document.getElementById(divName).innerHTML;
                            var originalContents = document.body.innerHTML;

                            document.body.innerHTML = printContents;
                            
                            window.print();

                            document.body.innerHTML = originalContents;
                        }
                    </script>
   <script>
    
      $('#output_image').click(function() {
         $('#student_photo').click();
      });

      function getdistricts_perm(stateid = 0) {
         $.getJSON("<?php echo base_url('home/get_districts') ?>" + "?state_id=" + stateid, function(json) {
            $('#district').empty();
            $('#district').append($('<option>').text("Select District"));
            $.each(json, function(i, obj) {
               $('#district').append($('<option>').text(obj.district_name).attr('value', obj.district_id));
            });
         });
      }
      function getdiscountlookup(discountid)
      {
          if(discountid==44)
          {
              $('.discount_id').show();
          }else
          {
              $('.discount_id').hide();
          }
      }

      $('#editstudentform').validate({
         ignore: [],
         submitHandler: function() {
            form.submit();
         },
         errorPlacement: function(error, element) {},
         invalidHandler: function() {
            setTimeout(function() {
               $('.nav-tabs a small.required').remove();
               var validatePane = $('.tab-content.tab-validate .tab-pane:has(input.error)').each(function() {
                  var id = $(this).attr('id');
                  $('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">*</small>');
               });
               var validatePaneSelect = $('.tab-content.tab-validate .tab-pane:has(select.error)').each(function() {
                  var id = $(this).attr('id');
                  $('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">*</small>');
               });
            });
         }
      });

      function notifyBySms(invoiceid) {
         $.ajax({
            type: "GET",
            url: "<?php echo base_url('Razorpay/notifyAboutPaymentLinkBySms?invoicenumber=') ?>" + invoiceid,
            success: () => {
               alert('SMS Notification Sent Successfully');
            }
         });
      }

      function notifyByEmail(invoiceid) {
         $.ajax({
            type: "GET",
            url: "<?php echo base_url('Razorpay/notifyAboutPaymentLinkByEmail?invoicenumber=') ?>" + invoiceid,
            success: () => {
               alert('Email Notification Sent Successfully');
            }
         });
      }

      function cancelPayment(invoiceid) {
         $.ajax({
            type: "GET",
            url: "<?php echo base_url('Razorpay/cancelPaymentLink?invoicenumber=') ?>" + invoiceid,
            success: () => {
               location.reload();
            }
         });
      }

      function editPayment(paymentid, name, paymenttypeid, paymentamount, paymentdate, otherdetails, remarks) {
         document.getElementById('paymentid').value = paymentid;
         document.getElementById('paymentname').value = name;
         document.getElementById('paymenttypeid').value = paymenttypeid;
         $('#paymenttypeid').trigger('change');

         document.getElementById('paymentamount').value = paymentamount;
         document.getElementById('remarks').value = remarks;
         document.getElementById('paymentdate').value = paymentdate;
         document.getElementById('otherdetails').value = otherdetails;

      }

      function preview_image(event) {
         var reader = new FileReader();
         reader.onload = function() {
            var output = document.getElementById('output_image');
            output.src = reader.result;
         }
         reader.readAsDataURL(event.target.files[0]);
      }
   </script>
   <script>
      $('.btn-del').on('click', function(e) {
         e.preventDefault();
         const href = $(this).attr('href')
         swal({
               title: "Are you sure?",
               text: "Once deleted, you will not be able to recover this Data!",
               icon: "warning",
               buttons: true,
               dangerMode: true,
            })
            .then((willDelete) => {
               if (willDelete) {
                  document.location.href = href;
               }
            })

      })
     
   </script>

<?php
endif;
?>
  <script>
  function sendotp()
  {
      var mobile = $('#contact').val();
      $.ajax({
            type: "POST",
            url: "<?php echo base_url('api/sendotptoparent') ?>",
            data: {
                phone: mobile
            },
            success: function(data) {
            
                $('#sendotp').hide();
                $('#otp').show();
                $('#verifybutton').show();

            }
        });
     
  }
  function verifyotp(userid)
  {
      var otp = $('#otp').val();
       var mobile = $('#contact').val();
      if(otp == '')
      {
          alert('Enter Otp');
      }else
      {
          $.ajax({
            type: "POST",
            url: "<?php echo base_url('api/verifyparentotp') ?>",
            data: {
                phone: mobile,
                otp:otp
            },
            success: function(data) {
            
                if(data.status==true)
                {
                    $('#paymentverify').show();
                    $('#verifybutton').hide();
                }else
                {
                    alert(data.message);
                }

            }
        });
      }
  }
  
 function getinvoiceid(invoiceid, userid) {
      var invoiceid = $('.getinvoiceid').val();
      var invoice = $('.getinvoiceid').find(':selected').data('id');
      $.ajax({
         type: "POST",
             url: "<?php echo base_url('users/getinvoicevalue') ?>",
         data: {
            invoiceid: invoiceid,
            invoice:invoice,
            userid: userid
         },
         success: function(data) {
            var response = JSON.parse(data);
           
            var total = response.TotalValue;
            var paid = response.TotalPaid;
            var final = total - paid;
               if (final > 0) {
                  $('.invoice2').attr("max", final);
                  $('.invoice3').val(invoice);
                  $('#payamount1').append(final);
               } else {
                  $('.invoice2').attr("max", 0);
                  $('.invoice3').val(invoice);
               }
            

         }
      });

   }
     function getinvoiceid1(invoiceid, userid) {
      var invoiceid = $('.getinvoiceid1').val();
      var invoice = $('.getinvoiceid1').find(':selected').data('id');
      $.ajax({
         type: "POST",
             url: "<?php echo base_url('users/getinvoicevalue') ?>",
         data: {
            invoiceid: invoiceid,
            invoice:invoice,
            userid: userid
         },
         success: function(data) {
            var response = JSON.parse(data);
           
            var total = response.TotalValue;
            var paid = response.TotalPaid;
            var final = total - paid;
               if (final > 0) {
                  $('.invoice4').attr("max", final);
                  $('.invoice5').val(invoice);
                  $('#payamount').append(final);
               } else {
                  $('.invoice4').attr("max", 0);
                  $('.invoice5').val(invoice);
               }
            

         }
      });

   }
       $("#college_code").change(function() {
        var id = $('#college_code').val();
   $.ajax({
            type: "POST",
            url: "<?php echo base_url('users/getcollgecode') ?>",
            data: {
                id: id
            },
            success: function(data) {
             
            var response = JSON.parse(data);
           //console.log(response.address); 
           $("#address").val(function() {
        return response.address;
    });
    
     $("#rc_no").val(function() {
        return response.rc_no;
    });
     $("#place").val(function() {
        return response.place;
    });
    $("#district").val(function() {
        return response.district;
    });

            }
        });
        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('users/gettcno') ?>",
            data: {
                id: id
            },
            success: function(data) {
             
            var response = JSON.parse(data);
           //console.log(response.address); 
           $("#tc_no").val(function() {
        return parseInt(response.tc_no) + 1;
    });

            }
        });
});
   </script>