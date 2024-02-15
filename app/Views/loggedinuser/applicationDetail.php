<style>
    @media screen print{
        .contactdetails{
        display:flex;
        justify-content:space-between;

    }
    
td.course {
    width: 50%;
}   
    

    
    }
    
@media  screen print   {
    
.courrr{border:1px solid red;}
    
.two{border:2px solid red;}


    
}

</style>
<div class="content-wrapper">
    <div class="container-fluid dont-display">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Application Details
                   
                </h2>
                <br />
                <form method="post" id="reservationform" action="<?php
use App\Models\ReservationModel;
                                                                    use App\Models\HelperModel;

                                                                    echo base_url('agentdashboard/updateapplication') ?>">
                    <ul class="nav nav-tabs">
                        <li><a id="PreviewTab" class="active" data-toggle="tab" href="#preview" onclick="generatePreview()">Application Details</a></li>
                    </ul>

                    <div class="tab-content tab-validate">
                        <?php
                        $rezofastdetails = json_decode($StudentDetail->rezofastdetails);
                        ?>
                        <div id="reservation" class="tab-pane fade">
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Application Id<i style="color: red;">*</i></label>
                                    <input type="text" id="reservationid" name="reservationid" class="form-control" value="<?php echo $StudentDetail->application_ukey ?>" readonly required>
                                    <br />
                                    <br />
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="course" name="course" style="width: 100%;" class="select2 form-control mb" required >
                                        <option value="">Select Course Type<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['coursetypelookup'] as $coursetype) :
                                        ?>
                                            <option <?php echo $StudentDetail->coursetype == $coursetype->id ? "selected" : "" ?> value="<?php echo $coursetype->id; ?>"><?php echo $coursetype->coursetype; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                                <div class="col-md-6">
                                    
                                        <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="admissiontypeid" name="admissiontypeid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Admission Type<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                        ?>
                                            <option <?php echo $StudentDetail->admissiontypeid == $admissiontype->admissiontypeid ? "selected" : "" ?> value="<?php echo $admissiontype->admissiontypeid; ?>"><?php echo $admissiontype->admissiontypename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                   
                                    <br><br>
                                </div>
                               
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="courseid" name="courseid" style="width: 100%;" class="select2 form-control mb" required <?php 
                                        ?>>
                                        <option value="">Select Course<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['courselookup'] as $course) :
                                        ?>
                                            <option <?php echo $StudentDetail->courseid == $course->courseid ? "selected" : "" ?> value="<?php echo $course->courseid; ?>"><?php echo $course->coursename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                                 <div class="col-md-6">
                                    
                                    <select onchange="this.classList.remove('error')" id="branchid" name="branchid" style="width: 100%;" class="select2 form-control mb" required >
                                        <option value="">Select Branch<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['branchlookup'] as $branch) :
                                        ?>
                                            <option <?php echo $StudentDetail->branchid == $branch->branchid ? "selected" : "" ?> value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="batchid" name="batchid" style="width: 100%;" class="select2 form-control mb" required <?php
                                        ?>>
                                        <option value="">Select Academic Year<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['batchlookup'] as $batch) :
                                            if ($batch->batchid != "1") :
                                        ?>
                                                <option <?php echo $StudentDetail->batchid == $batch->batchid ? "selected" : "" ?> value="<?php echo $batch->batchid; ?>"><?php echo $batch->batchname; ?></option>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Application Date<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="dd/mm/yy" id="admissiondate" name="admissiondate" value="<?php echo date_format(date_create($StudentDetail->admissiondate), 'd/m/Y') ?>" class="form-control mb datepicker" required <?php 
                                        ?>>
                                </div>
                            </div>
                           
                            <br />
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#BasicTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="basic" class="tab-pane fade">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Student Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Name" id="name" name="name" class="form-control mb" value="<?php echo $StudentDetail->name ?>" required>

                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Date Of Birth<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="dd/mm/yy" id="dateofbirth" name="dateofbirth" class="form-control mb datepicker" value="<?php echo date_format(date_create($StudentDetail->dateofbirth), 'd/m/Y') ?>" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Father Name/ Guardian Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Father Name" id="fathername" name="fathername" class="form-control mb" value="<?php echo $StudentDetail->fathername ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Mother Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Mother Name" id="mothername" name="mothername" class="form-control mb" value="<?php echo $StudentDetail->mothername ?>" required>
                                </div>
                            </div>
                             <div class="row">
                                 <?php
                            $PreviousClassesInfo = json_decode($StudentDetail->previous_class_information);
                            if ($PreviousClassesInfo != "") {
                                foreach ($PreviousClassesInfo as $classInfo) {
                                    $classInfo = $classInfo;
                                }
                            }
                            ?>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Board<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error')" id="board" name="board" style="width: 100%;" class="select2 form-control mb" required>
                                        <?php
                                        foreach ($lookups['boardlookup'] as $board) :
                                        ?>
                                            <option <?php echo $classInfo->board == $board->boardid ? "selected" : "" ?> value="<?php echo $board->boardid; ?>"><?php echo $board->boardname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br /><br />
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">School/ College<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="School Name" id="school" name="school" class="form-control mb" value="<?php echo $classInfo->school ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Place<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Place" id="place" name="place" class="form-control mb" value="<?php echo $classInfo->place ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                 <?php
                            $Address = json_decode($StudentDetail->address);
                            $permanentAddress = $Address->permanent;
                            ?>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Door No./ Street Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Door No./ Street Name" id="door_street" name="door_street" class="form-control mb" value="<?php echo $permanentAddress->door_street ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">State<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');getdistricts_perm(this.value);" id="state" name="state" style="width: 100%;" class="select2 form-control mb" required>
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
                                    <label class="text-uppercase text-sm">District<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error')" id="district" name="district" style="width: 100%;" class="select2 form-control mb" required>
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
                                    <label class="text-uppercase text-sm">City/ Town<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="City/ Town" id="city_town" name="city_town" class="form-control mb" value="<?php echo $permanentAddress->city_town ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Village/ Mandal<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Village/ Mandal" id="village_mandal" name="village_mandal" class="form-control mb" value="<?php echo $permanentAddress->village_mandal ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Pin<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Pin" id="pin" name="pin" class="form-control mb" value="<?php echo $permanentAddress->pin ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Landmark<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Landmark" id="landmark" name="landmark" class="form-control mb" value="<?php echo $permanentAddress->landmark ?>" required>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Mobile<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Mobile" id="mobile1" name="mobile1" class="form-control mb" value="<?php echo $StudentDetail->mobile1 ?>" required>
                                </div>
                                 <div class="col-md-6">
                                    <label class="text-uppercase f-16">Email</i></label>
                                    <input type="text" placeholder="Email" id="email" name="email" class="form-control mb" value="<?php echo $StudentDetail->email ?>">
                                </div>
                            </div>


                            <div class="row">

                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Aadhaar Number<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Aadhaar Number" id="studentaadhaar" name="studentaadhaar" class="form-control mb" value="<?php echo $StudentDetail->studentaadhaar ?>" required>
                                </div>
                                 <div class="col-md-6">
                                      <label class="text-uppercase f-16">Select Gender<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error')" id="genderid" name="genderid" style="width: 100%;" class="select2 form-control mb select" required>
                                        <option value="">Select Gender<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['genderlookup'] as $gender) :
                                        ?>
                                            <option <?php echo $StudentDetail->genderid == $gender->genderid ? "selected" : ""; ?> value="<?php echo $gender->genderid; ?>"><?php echo $gender->gendername; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                                
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" name="referredby" style="width: 100%;" class="select2 form-control mb">
                                        <option value="">Select Reference Employee</option>
                                        <?php
                                       // echo $StudentDetail->referredby;
                                            
                                        foreach ($EmployeeDetails as $reference) :
                                           // echo $reference->userid
                                        ?>
                                            <option value="<?php echo $reference->name ?>" <?php echo $StudentDetail->referredby == $reference->userid ? "selected" : "" ?>><?php echo $reference->employeeid . " - " . $reference->name; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <br />
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#ReservationTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Next</a>
                                </div>
                            </div>

                        </div>


                        <div id="fees" class="tab-pane fade">
                            <br />
                           
                           
                            <?php $helperModel = new HelperModel(); ?>
                            <div class="row">
                              
                                <div class="col-md-4">
                                    
                                    <?php
                                    
                                    
                                      if ($_SESSION['agentdetails']->roleid != 15) {
                                          ?>
                                          <label class="text-uppercase f-16">Final Course Fees</label>
                                        <input type="number" min="0" disabled value="<?php echo $StudentDetail->tuition_discount ?>"  name="tuition_discount" id="text_tuition_fees_total" class='form-control mb' required/>
                             <input type="hidden" value="<?php echo $StudentDetail->tuition_discount ?>" name="tuition_discount">
                              
                              <?php
                               if ($_SESSION['agentdetails'] != null) {
                                   ?>
                                   <!--
                              <label class="text-uppercase f-16">Proposed Discount</label>
                                    <input type="number" disabled  name="discountrequested" placeholder="Purposed Fee Discount" id="discountrequested" class='form-control mb'/ value="<?php echo $StudentDetail->discountrequested ?>" >
                                     <input type="hidden"  name="discountrequested1" class='form-control mb'/ value="<?php echo $StudentDetail->discountrequested ?>" >

                              <label class="text-uppercase f-16">Discount Given</label>
                                    <input type="number"   name="discountgiven" placeholder="Fee Comments" id="discountgiven" class='form-control mb'/ value="<?php echo $StudentDetail->discountgiven ?>" >
                                    <input type="hidden"   name="discountgiven1"  value="<?php echo $StudentDetail->discountgiven ?>" >
                                        -->
                            <?php } ?>
                               <?php }else
                               {
                                    if ($_SESSION['agentdetails'] != null) {
                                        ?>
                                 
                                    <input type="number" disabled min="0" value="<?php echo $StudentDetail->tuition_discount ?>"  name="tuition_discount" id="text_tuition_fees_total" class='form-control mb' required/>
                                    <?php if($StudentDetail->admissiontypeid ==1){ ?>
                                    <label class="text-uppercase f-16">Final Hostel Fees</label>
                                  <input type="number" disabled min="0" value="<?php echo $StudentDetail->hostel_discount ?>"  name="hostel_discount" id="text_hostel_fees_total" class='form-control mb'/>
                                     <?php } ?>
                                     <input type="hidden" value="<?php echo $StudentDetail->hostel_discount ?>" name="hostel_discount">
                                      <input type="hidden" value="<?php echo $StudentDetail->tuition_discount ?>" name="tuition_discount">
                                    <!--  <label class="text-uppercase f-16">Proposed Discount</label>
                                    <input type="number"   name="discountrequested" placeholder="Purposed Fee Discount" id="discountrequested" class='form-control mb'/ value="<?php echo $StudentDetail->discountrequested ?>" >
                                     <label class="text-uppercase f-16">Select Employee To transfer</label>
                                     <select name="employeeid" style="width: 80%;" class="form-control" required>
                                        <option value="">Select Employee</option>
                                        <option value='37'>Dean</option>
                                         <option value='38'>COO</option>
                                          <option value='6393'>School Principal</option> <option value='6402'>Gurukul Zonal Head</option<option value='2151'>Madhapur Zonal Head</option> <option value='2235'>Central Marketing Office</option>
                                        </select>
                                        -->
                                   <?php
                                    }
                               } ?>
                               <input type="hidden" value="<?php echo ($StudentDetail->tuition_discount+$StudentDetail->hostel_discount); ?>" name="total_fee">
                                <input type="hidden" id="MaxDiscountPermitted" name="MaxDiscountPermitted" value="<?php
                                                                                                                        $maxDiscountAllowed = 0;
                                                                                                                        if($StudentDetail->admissiontypeid==1)
                                                                                                                        {
                                                                                                                            if ($FeesLimit[0]->resdiscount != NULL && $FeesLimit[0]->availablelimit != NULL) {
                                                                                                                                if ($FeesLimit[0]->availablelimit > $FeesLimit[0]->resdiscount) {
                                                                                                                                    $maxDiscountAllowed = $FeesLimit[0]->resdiscount;
                                                                                                                                } else {
                                                                                                                                    $maxDiscountAllowed = $FeesLimit[0]->availablelimit;
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                $maxDiscountAllowed = 0;
                                                                                                                            }
                                                                                                                        }else if($StudentDetail->admissiontypeid==3)
                                                                                                                        {
                                                                                                                            if ($FeesLimit[0]->discount != NULL && $FeesLimit[0]->availablelimit != NULL) {
                                                                                                                                if ($FeesLimit[0]->availablelimit > $FeesLimit[0]->discount) {
                                                                                                                                    $maxDiscountAllowed = $FeesLimit[0]->discount;
                                                                                                                                } else {
                                                                                                                                    $maxDiscountAllowed = $FeesLimit[0]->availablelimit;
                                                                                                                                }
                                                                                                                            } else {
                                                                                                                                $maxDiscountAllowed = 0;
                                                                                                                            }
                                                                                                                            
                                                                                                                        }else
                                                                                                                        {
                                                                                                                            $maxDiscountAllowed = 0;
                                                                                                                        }
                                                                                                                        echo $maxDiscountAllowed;
                                                                                                                        ?>" />
                                                                                                                          <?php
                                 if( $_SESSION['agentdetails']->roleid != 15 && $_SESSION['agentdetails'] != null){
                                     ?>
                                    Available Discount Limit: <b><?php echo $FeesLimit[0]->availablelimit != NULL ? $FeesLimit[0]->availablelimit : 0 ?></b><br />
                                    Maximum Discount: <b><?php echo $maxDiscountAllowed ?></b>
                                <?php } ?>
                                </div>
                              
                               <!-- <div class="col-md-4">
                                    <label class="text-uppercase f-16">Comments</label>
                                    <input type='text' name='comments' placeholder="comments" class='form-control mb' value="<?php echo $StudentDetail->comments ?>">
                                    <label class="text-uppercase f-16">Final Total Fees</label>
                                    <input type='text' name='totalfees' disabled placeholder="Total Fee" class='form-control mb' value="<?php echo ($StudentDetail->tuition_discount + $StudentDetail->hostel_discount); ?>">
                                    
                                </div> -->
                            </div>
                            <br />

                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#BasicTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#PreviewTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                       
                        <div id="preview" class="tab-pane fade in active">
                            <div id="print_preview">
                                <table style="width: 100%;margin: 0;border:1px solid black;">
                                    <br />

                                    <tr style="border-bottom: 0px; background-color: #bedff7; display: flex;justify-content: center;">
                                        <th style="float: left !important; padding: 5px;font-size: 20px;display: flex; "><br /><i>Application Details</i></th>
                                    </tr>
                                    <!--<tr class="application_id_one">-->
                                    <!--    <td>Application Id: <b><span id="preview_reservationid"></span></b></td>-->
                                    <!--</tr>-->
                                    
                                    </table>
                                    
                                    <div class="two" style="border:1px solid black;border-bottom: 0px; ">
                                        
                                         <table style="width: 100%;margin: 0;">
                                             
                                             
                                             
                                    <tr>
                                        
                                                 <td  style="width:50%;  border: 1px solid gray;padding: 5px;">Application Id: <b><span class="preview_reservationid"></span></b></td>
                                        <td  style="width:50%;  border: 1px solid gray;padding: 5px;">Admission Type: <b><span class="preview_admissiontype"></span></b></td>
                                        
                             
                                       </tr>
   
                                        <tr>
                                                     <td class="bran" style="width:50%;  border: 1px solid gray;padding: 5px;">Branch: <b><span class="preview_branch"></span></b></td>
                                   <td style=" width: 50%; border: 1px solid gray;padding: 5px;">Batch: <b><span class="preview_batch"></span></b></td>
                                      
                                   
                                      </tr>
                                      
                                      
                                             <tr>
                                      <td style=" width: 50%; border: 1px solid gray;padding: 5px;">Admission Date: <b><span class="preview_admissiondate"></span></b></td>
                                        <td class="course" style="width:50%; border: 1px solid gray;padding: 5px;">Course: <b><span class="preview_course"></span></b></td>
                                   
                                    </tr>
                                      
                                         </table>
                                      </div>
                                      
                                    <!--       <tr>-->
                                    <!--    <td class="course" style="width:100%; border: 1px solid gray;">Course: <b><span id="preview_course"></span></b></td>-->
                                   
                                    <!--</tr>-->
                                      
                                    
                                    
                                         <div class="three"  style="border: 1px solid black; border-top: 0px; ">
                                             <table style="width: 100%;margin: 0;">
                                    <!--<tr>-->
                                    <!--      <td>Application Id: <b><span id="preview_reservationid"></span></b></td>-->
                                    <!--    <td class="course" style="width:70%; border: 1px solid gray;padding: 5px;">Course: <b><span id="preview_course"></span></b></td>-->
                                   
                                    <!--</tr>-->
                                    
                                        </table>
                                      </div>
                                      
                                      <br>
                                    
                                          <div class="four"  style="border:1px solid black;">
                                             <table style="width: 100%;margin: 0;">
                             

                                    <tr style="background-color: #bedff7; justify-content: center;display: flex;">
                                        <th style="float: left !important;padding: 5px; font-size: 20px; display: flex;"><br /><i>Basic Details</i></th>
                                    </tr>
                                    
                                         </table>
                                      </div>
                                    
                                    <div class="five"  style="border:1px solid black;">
                                             <table style="width: 100%;margin: 0;">
                                    <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Student Name: <b><span class="preview_studentname"></span></b></td>
                                        <td  style="width:50%; border: 1px solid gray;padding: 5px;">Date Of Birth: <b><span class="preview_dateofbirth"></span></b></td>
                                        
                                        </tr>
                                        
                                        <tr>    
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Father/Guardian Name: <b><span class="preview_fathername"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Mother's Name:<b><span class="preview_mothername"></span></b></td>
                                    </tr>
                                        
                                        <tr>
                                        <td  style="width:50%; border: 1px solid gray;padding: 5px;">Gender: <b><span class="preview_gender"></span></b></td>
                                        
                                            <td  style="width:50%; border: 1px solid gray;padding: 5px;"> Aadhaar Number: <b><span class="preview_aadhaar"></span></b></td>
                                    </tr>
                                    
                                           
                                    <tr>
                                       
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Mobile1: <b><span class="preview_mobile1"></span></b></td>
                                                   <td style="width:50%; border: 1px solid gray;padding: 5px;" class="maill">Email Address: <b> <span class="preview_email"></span></b></td>
                                      
                                    </tr>
                                    
                                    <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">School/College:<b ><span class="preview_schoolname"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Board: <b > <b><span class="preview_board"></span></b></td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">State: <b><span class="preview_state"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">District: <b><span class="preview_district"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Door No./ Street Name: <b><span class="preview_doorno"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">City/ Town: <b><span class="preview_city"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Village/ Mandal: <b><span class="preview_village"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Pin: <b><span class="preview_pin"></span></b></td>
                                    </tr>
                                    
                                        </table>
                                      </div>
                                      
                                      
                                   
                                      
                                      <br>


       <div class="six"  style="border:1px solid black;">
                                 <table style="width: 100%;margin: 0;">       
                                   <tr style="background-color: #bedff7; justify-content: center;display: flex;">
                                        <th style="float: left !important;padding: 5px; font-size: 20px; display: flex;"><br /><i>Fee Details</i></th>
                                    </tr>
                                    
                                        <tr style="border-top: 2px solid black;">
                                   
                                        <td style="width:50%; border: 1px solid gray; padding: 5px;">Tuition Fee: <b><span class="preview_totalfee"></span></b></td>
                                            <?php if($StudentDetail->admissiontypeid ==1){ ?>
                                        <td style="width:50%; border: 1px solid gray; padding: 5px;">Hostel Fee: <b><span class="preview_hostelfee"></span></b></td>
                                        <?php }
                                        ?>
                                    </tr>
                                    
                                    <tr style="border-top: 2px solid black;">
                                
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Course Total Fee: <b><span class="preview_total"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Referred By: <b><span class="preview_referredby"></span></b></td>

                                    </tr>
                                
                                        
                                        </table>
                                              </div>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </table>
                                <BR>
                                <h5><b><sup>*</sup>Note:</b>
                                The Above Mentioned course fee does not include Miscellaneous Charges Which Is Rs.<?php  if($StudentDetail->branchid == 11)
                                        { echo "31000"; } else{ echo "28000"; }  ?>/- (Student Kit). This Fee Need to be paid Separately to the stores department at the time of Reporting to avail Miscellaneous Kit which is mandatory.Additional Mess Charges @ Rs 35000 Towards (Lunch + Evening Snacks) for Semi residential Day Scholar Students.This above Sentence is not added in applications</h5>
                                <p style="
    padding: 10px; margin-top: 40px;
"><b>Undertaking by the student:</b><br><br>

I will abide by the rules and regulations of the college .I will follow the discipline of the institution and strictly adopt anti-ragging policies. In
                  the event of my misbehavior, I will not question the action whatsoever taken by the authorities of the institution, as a part of discipline,
                  including my expulsion. I am informed by the management that electronic items like mobile phones, FM Radio, Smart Watches, video games etc., should not be
                  brought into the campus. If the student doesn’t join for any reason reservation fee will not be refunded.
</p>
<p style='float:right'> Signature of the student</p>
<p style="
    padding: 10px;
">
    <br>
    <br>
    <br>
    <b>Undertaking by the parent:</b> <br><br>
I know that the fee paid towards reservation is non-refundable in any case. Cancellation of admission or settlement of account is as per the
                  conditions mentioned above by the management. If my ward/visitor/misbehaves or creates any disturbance within the campus, the Concerned
                  ward will be transferred to the Day-Scholar campus or will be terminated from the institution. The institution will not bear any kind of
                  responsibility for my ward’s behavior outside the Campus. If my ward leaves the campus without obtaining prior permission from the
                  administrative authorities of the campus concerned the institution authorities are not held responsible and I myself will take up the responsibility of my ward. I understand that such actions on the part of my ward may result to the termination from the institution.

</p>
<p style="
    padding: 10px;
">
    <ul class="disc_ul" style="
    padding: 10px;
">
        <li style="
    list-style-type: disc;
">
            Fee paid for my ward will not be transferred to another student’s name in any case.
        </li>
        <li style="
    list-style-type: disc;
">
            If I want to shift my ward from your institution to other before completion of two years course, I shall pay back the concession given at the time of admission. </li>
<li style="
    list-style-type: disc;
">Fee structure and concession may vary from branch to branch. The courses fee does not include Course Material, Transport, dhobi & caution. </li>
<li style="
    list-style-type: disc;
">Allotment of campus and section is at the sole discretion of the management. The management reserves the right to shift the students from one campus to another campus. </li>
<li style="
    list-style-type: disc;
">	Fee concession, if offered will be valid for the academic year only. Any other taxes will be collected separately, where ever applicable. </li>
<li style="
    list-style-type: disc;
">	Permission can be given to my ward, if he/she wishes to go out from the campus on any urgency or during the common outing. </li>
<li style="
    list-style-type: disc;
">	Reservation Fee 12500/- once paid will not be refunded at any cost. RS.10000/- From Reservation fee will be adjusted towards Tuition Fee.    </li>           
<li style="
    list-style-type: disc;
">	There will be 10k increment in fee for second year. </li>
<li style="
    list-style-type: disc;
">Fee can be paid in Three Installments 1st term will be 50% at the time of Joining and 25% After Dusshera Holidays and Remaining 25% By Sankranthi Holidays & for Foundation Courses, fee need to paid 100% @ time of Reporting.</li>


       
    </ul>
</p>
<p style='float:right'> Signature of the Parent</p>
                            </div>
                           
                            <br />
                            <div class="row">
                                <div class="col-md-2 mb">
                                    <?php
                                         if ($_SESSION['agentdetails']->roleid != 15) {
                                             ?>
                                    <select name="reservationstatusid" style="width: 100%;" class="form-control" disabled>
                                        <option value="">Select Reservation Status</option>
                                        <?php
                                   
                                             foreach ($lookups['reservationstatuslookup'] as $reservationstatus) :
                                                 if ($reservationstatus->reservationstatusid == "4")
                                                 {
                                                     ?>
                                                     <option <?php echo $reservationstatus->reservationstatusid == $StudentDetail->reservationstatusid ? "selected" : "" ?> value="<?php echo $reservationstatus->reservationstatusid; ?>" <?php echo isset($_GET['reservationstatusid']) && $_GET['reservationstatusid'] == $reservationstatus->reservationstatusid ? "selected" : "" ?>><?php echo $reservationstatus->reservationstatusname; ?></option>
                                                     <?php
                                                     
                                                 }else
                                                 {
                                            if ($reservationstatus->reservationstatusid == "1" || $reservationstatus->reservationstatusid == "2") {
                                        ?>
                                                <option <?php echo $reservationstatus->reservationstatusid == $StudentDetail->reservationstatusid ? "selected" : "" ?> value="<?php echo $reservationstatus->reservationstatusid; ?>" <?php echo isset($_GET['reservationstatusid']) && $_GET['reservationstatusid'] == $reservationstatus->reservationstatusid ? "selected" : "" ?>><?php echo $reservationstatus->reservationstatusname; ?></option>
                                        <?php
                                            }
                                                 }
                                        endforeach;
                                       ?>
                                    </select>
                                    <?php }
                                        ?>
                                </div>
                                <div class="col-md-4 mb">
                                    <?php
                                     if($StudentDetail->transferemployee !=null && $_SESSION['agentdetails']->roleid ==3)
                                     {
                                         echo "<div class='btn btn-primary'>Transferred</div>";
                                     }
                                    //echo $_SESSION['userdetails']->roleid;
                                    if ($_SESSION['agentdetails'] != null && $_SESSION['agentdetails'] != null && $_SESSION['agentdetails']->roleid != 15 && $StudentDetail->reservationstatusid !=4 && $StudentDetail->transferemployee ==null) {
                                        if($StudentDetail->transferemployee !=null)
                                        ?>
                                        <button type="submit" name="createstudent" class="btn btn-primary">Update Application</button>
                                        
                                        <?php
                                    }
                                    if( $_SESSION['agentdetails'] != null && $_SESSION['agentdetails']->roleid != 15 && $_SESSION['agentdetails']->roleid != 3 && $StudentDetail->reservationstatusid !=4 && $StudentDetail->transferemployee !=null)
                                    {
                                        ?>
                                        <button type="submit" name="createstudent" class="btn btn-primary">Update Application</button>
                                        <?php
                                    }
                                    
                                    if($_SESSION['agentdetails'] != null && $_SESSION['agentdetails']->roleid == 15 && $StudentDetail->reservationstatusid !=4 && $StudentDetail->transferemployee ==null)
                                    {
                                        ?>
                                        <button type="submit" name="createstudent" class="btn btn-primary">Update Application</button>
                                        <?php
                                    }
                                    ?>
                                </div>
                                
                                <div class="col-md-6 mb">
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" href="https://maidendropgroup.com/public/payments/printapp?userid=<?php echo $StudentDetail->applicationid ?>">Print Application</a>
                                    <!--<?php if($StudentDetail->reservationstatusid ==4){
                                    ?>
                                    <a class="btn btn-primary" onclick="print_preview1()">Print Application2</a>
                                    <?php } ?>-->
                                </div>
                            </div>
                             <div id="print_preview1" style="display:none;">
                                <table style="width: 100%;margin: 0;border:1px solid black;">
                                    <br />

                                    <tr style="border-bottom: 0px;background-color: #bedff7; display: flex;justify-content: center;">
                                        <th style="float: left !important; padding: 5px;font-size: 20px;display: flex;background-color: #bedff7; "><br /><i>Application Details1</i></th>
                                    </tr>
                                    <!--<tr class="application_id_one">-->
                                    <!--    <td>Application Id: <b><span id="preview_reservationid"></span></b></td>-->
                                    <!--</tr>-->
                                    
                                    </table>
                                    
                                    <div class="two" style="border:1px solid black;border-bottom: 0px; ">
                                        
                                         <table style="width: 100%;margin: 0;">
                                             
                                             
                                             
                                    <tr>
                                        
                                                 <td  style="width:50%;  border: 1px solid gray;padding: 5px;">Application Id: <b><span class="preview_reservationid"></span></b></td>
                                        <td  style="width:50%;  border: 1px solid gray;padding: 5px;">Admission Type: <b><span class="preview_admissiontype"></span></b></td>
                                        
                             
                                       </tr>
   
                                        <tr>
                                                     <td class="bran" style="width:50%;  border: 1px solid gray;padding: 5px;">Branch: <b><span class="preview_branch"></span></b></td>
                                   <td style=" width: 50%; border: 1px solid gray;padding: 5px;">Batch: <b><span class="preview_batch"></span></b></td>
                                      
                                   
                                      </tr>
                                      
                                      
                                             <tr>
                                      <td style=" width: 50%; border: 1px solid gray;padding: 5px;">Admission Date: <b><span class="preview_admissiondate"></span></b></td>
                                        <td class="course" style="width:50%; border: 1px solid gray;padding: 5px;">Course: <b><span class="preview_course"></span></b></td>
                                   
                                    </tr>
                                      
                                         </table>
                                      </div>
                                      
                                    <!--       <tr>-->
                                    <!--    <td class="course" style="width:100%; border: 1px solid gray;">Course: <b><span id="preview_course"></span></b></td>-->
                                   
                                    <!--</tr>-->
                                      
                                    
                                    
                                         <div class="three"  style="border: 1px solid black; border-top: 0px; ">
                                             <table style="width: 100%;margin: 0;">
                                    <!--<tr>-->
                                    <!--      <td>Application Id: <b><span id="preview_reservationid"></span></b></td>-->
                                    <!--    <td class="course" style="width:70%; border: 1px solid gray;padding: 5px;">Course: <b><span id="preview_course"></span></b></td>-->
                                   
                                    <!--</tr>-->
                                    
                                        </table>
                                      </div>
                                      
                                      <br>
                                    
                                          <div class="four"  style="border:1px solid black;">
                                             <table style="width: 100%;margin: 0;">
                             

                                    <tr style=" background-color: #bedff7; justify-content: center;display: flex;">
                                        <th style="float: left !important;padding: 5px; font-size: 20px; display: flex;"><br /><i>Basic Details</i></th>
                                    </tr>
                                    
                                         </table>
                                      </div>
                                    
                                    <div class="five"  style="border:1px solid black;">
                                             <table style="width: 100%;margin: 0;">
                                    <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Student Name: <b><span class="preview_studentname"></span></b></td>
                                        <td  style="width:50%; border: 1px solid gray;padding: 5px;">Date Of Birth: <b><span class="preview_dateofbirth"></span></b></td>
                                        
                                        </tr>
                                        
                                        <tr>    
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Father/Guardian Name: <b><span class="preview_fathername"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Mother's Name:<b><span class="preview_mothername"></span></b></td>
                                    </tr>
                                        
                                        <tr>
                                        <td  style="width:50%; border: 1px solid gray;padding: 5px;">Gender: <b><span class="preview_gender"></span></b></td>
                                        
                                            <td  style="width:50%; border: 1px solid gray;padding: 5px;"> Aadhaar Number: <b><span class="preview_aadhaar"></span></b></td>
                                    </tr>
                                    
                                           
                                    <tr>
                                       
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Mobile1: <b><span class="preview_mobile1"></span></b></td>
                                                   <td style="width:50%; border: 1px solid gray;padding: 5px;" class="maill">Email Address: <b> <span class="preview_email"></span></b></td>
                                      
                                    </tr>
                                    
                                    <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">School/College:<b ><span class="preview_schoolname"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Board: <b > <b><span class="preview_board"></span></b></td>
                                    </tr>
                                    
                                    <tr>
                                        
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">State: <b><span class="preview_state"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">District: <b><span class="preview_district"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Door No./ Street Name: <b><span class="preview_doorno"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">City/ Town: <b><span class="preview_city"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Village/ Mandal: <b><span class="preview_village"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Pin: <b><span class="preview_pin"></span></b></td>
                                    </tr>
                                    
                                        </table>
                                      </div>
                                      
                                      
                                   
                                      
                                      <br>


       <div class="six"  style="border:1px solid black; border-top: 0px;">
                                 <table style="width: 100%;margin: 0; border: 1px solid black;">       
                                   <tr >
                                        <th style="justify-content: center !important; padding: 5px; font-size: 20px;display: flex; width: 100%"><br /><i>Fee Details</i></th>
                                    </tr>
                                    
                                        <tr style="border-top: 2px solid black;">
                                   
                                        <td style="width:50%; border: 1px solid gray; padding: 5px;">Tution Fee: <b><span class="preview_totalfee"></span></b></td>
                                            <?php if($StudentDetail->admissiontypeid ==1){ ?>
                                        <td style="width:50%; border: 1px solid gray; padding: 5px;">Hostel Fee: <b><span class="preview_hostelfee"></span></b></td>
                                        <?php }
                                        ?>
                                    </tr>
                                    
                                    <tr style="border-top: 2px solid black;">
                                    <td style="width:50%; border: 1px solid gray;padding: 5px;">Course Total Fee: <b><span class="preview_total"></span></b></td>
                                    <td style="width:50%; border: 1px solid gray;padding: 5px;">Referredy By: <b><span class="preview_referredby"></span></b></td>

                                    </tr>
                                    
                                    <!--<tr style="border-top: 2px solid black;">
                                   
                                        <td style="width:50%; border: 1px solid gray; padding: 5px;">Propose Discount: <b><span class="preview_discountrequested"></span></b></td>
                                        <td style="width:50%; border: 1px solid gray;padding: 5px;">Discount Given: <b><span class="preview_discountgiven"></span></b></td>
                                    </tr>-->
                                
                                        
                                        </table>
                                              </div>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </table>
                                <BR>
                                <h4><b>Note<sup>*</sup>:</b>
                                The Above Mentioned Total Course Fee Does Not Include Course Material, Transport, Laundry, Caution Deposit.</h4>
                                <br>
                                <p style="
    padding: 10px; margin-top: 40px;
"><b>Undertaking by the student:</b><br><br>

I will abide by the rules and regulations of the college .I will follow the Discipline of the institution and strictly adopt anti-ragging policies. In the event of my misbehavior, I will not question the action whatsoever taken by the authorities of the institution, as a part of discipline, including my expulsion. I am informed by the management that electronic items like cell phones, FM Radio, video games etc., should not be brought into the campus. If the student doesn’t join for any reason reservation fee will not be refunded.
</p>
<p style='float:right'> Signature of the student</p>
<p style="
    padding: 10px;
">
    <br>
    <br>
    <br>
    <b>Undertaking by the parent:</b> <br><br>
I know that the fee paid towards reservation is non-refundable in any case. Cancellation of admission or settlement of account is as per the conditions mentioned above by the management. If my ward/visitor misbehaves or creates any disturbance on the campus, the Concerned ward will be transferred to the Day-Scholar campus or will be terminated from the institution. The institution will not bear any kind of responsibility for my ward’s behavior outside the Campus. If my ward leaves the campus without obtaining prior permission from the administrative authorities of the campus concerned the institution authorities are not held responsible and I myself will take up the responsibility of my ward. I understand that such actions on the part of my ward may result to the termination from the institution.

</p>
<p style="
    padding: 10px;
">
    <ul class="disc_ul" style="
    padding: 10px;
">
        <li style="
    list-style-type: disc;
">
            Fee paid for my ward will not be transferred to another student’s name in any case.
        </li>
        <li style="
    list-style-type: disc;
">
            If I want to shift my ward from your institution to other before completion of two years course, I shall pay back the concession given at the time of admission. </li>
<li style="
    list-style-type: disc;
">Fee structure and concession may vary from branch to branch. The courses fee does not include Course Material, Transport, dhobi & caution. </li>
<li style="
    list-style-type: disc;
">Allotment of campus and section is at the sole discretion of the management. The management               reserves the right to shift the students from one campus to another campus. </li>
<li style="
    list-style-type: disc;
">	Fee concession, if offered will be valid for the academic year only. Any other taxes will be collected separately, where ever applicable. </li>
<li style="
    list-style-type: disc;
">	Permission can be given to my ward, if he/she wishes to go out from the campus on any urgency or         during the common outing. </li>
<li style="
    list-style-type: disc;
">	Reservation Fee 12500/- once paid will not be refunded at any cost. RS.10000/- From Reservation fee will be adjusted towards Tuition Fee.    </li>           
<li style="
    list-style-type: disc;
">	There will be 10% increment in fee for second year. </li>
<li style="
    list-style-type: disc;
">Fee can be paid in Three Installments 1st term will be 50% at the time of Joining and 25% After Dusshera Holidays and Remaining 25% By Sankranthi Holidays.</li>

       
    </ul>
</p>
<p style='float:right'> Signature of the Parent</p>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id" name='id' value="<?php echo $StudentDetail->applicationid ?>" required />
                </form>
                
                
            </div>
            <br>
            <div class="col-md-12">
                 <form method="post" id="transferform" action="<?php echo base_url('agentdashboard/updateapplication') ?>">
                <div class="col-md-2">
                    </div>
                                <div class="col-md-4">
                                     <?php
                                    //echo $_SESSION['userdetails']->roleid;
                                    if ($_SESSION['agentdetails'] != null && $_SESSION['agentdetails']->roleid != 15 && $StudentDetail->reservationstatusid !=4 && $StudentDetail->transferemployee ==null) {
                                        ?>
                                     <select name="employeeid" style="width: 80%;" class="form-control" required>
                                        <option value="">Select Employee</option>
                                        <option value='37'>Dean</option>
                                         <option value='38'>COO</option>
                                          <option value='6393'>School Principal</option> <option value='6402'>Gurukul Zonal Head</option<option value='2151'>Madhapur Zonal Head</option> <option value='2235'>Central Marketing Office</option>
                                        </select>
                                        <input type="hidden" id="id" name='id' value="<?php echo $StudentDetail->applicationid ?>" required />
                                        <br>
                                   
                                        <button type="submit" name="transfer" class="btn btn-primary">Transfer Application</button>
                                        
                                        <?php
                                    }?>
                                </div>
                                </form>
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
    
   
     var admissiontypelookup_json = <?php echo $lookups['admissiontypelookup_json']; ?>;
        var batchlookup_json = <?php echo $lookups['batchlookup_json']; ?>;
        var boardlookup_json = <?php echo $lookups['boardlookup_json']; ?>;
        var branchlookup_json = <?php echo $lookups['branchlookup_json']; ?>;
        var categorylookup_json = <?php echo $lookups['categorylookup_json']; ?>;
        var courselookup_json = <?php echo $lookups['courselookup_json']; ?>;
        var districtslookup_json = <?php echo $lookups['districtslookup_json']; ?>;
        var feestructurelookup_json = <?php echo $lookups['feestructurelookup_json']; ?>;
        var genderlookup_json = <?php echo $lookups['genderlookup_json']; ?>;
        var nationalitylookup_json = <?php echo $lookups['nationalitylookup_json']; ?>;
        var religionlookup_json = <?php echo $lookups['religionlookup_json']; ?>;
        var secondlanguagelookup_json = <?php echo $lookups['secondlanguagelookup_json']; ?>;
        var sectionlookup_json = <?php echo $lookups['sectionlookup_json']; ?>;
        var stateslookup_json = <?php echo $lookups['stateslookup_json']; ?>;

        var actualCoachingFee = 0;
        var actualMiscellaneousFee = 0;
        var actualIntermediateFee = 0;
        var actualHostelFee = 0;

        function generatePreview() {
            var fakeURL = "http://www.example.com/t.html?" + $('#reservationform').serialize();
            var createURL = new URL(fakeURL);

            $('.preview_reservationid').html(createURL.searchParams.get('reservationid'));
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('.preview_admissiontype').html(a.admissiontypename)
                }
            });
            $('.preview_reservationid1').html(createURL.searchParams.get('reservationid'));
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('.preview_admissiontype').html(a.admissiontypename)
                }
            });
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('.preview_admissiontype1').html(a.admissiontypename)
                }
            });
            branchlookup_json.forEach((a) => {
                if (a.branchid == createURL.searchParams.get('branchid')) {
                    $('.preview_branch').html(a.branchname)
                }
            });
            branchlookup_json.forEach((a) => {
                if (a.branchid == createURL.searchParams.get('branchid')) {
                    $('.preview_branch1').html(a.branchname)
                }
            });
            batchlookup_json.forEach((a) => {
                if (a.batchid == createURL.searchParams.get('batchid')) {
                    $('.preview_batch').html(a.batchname)
                }
            });
            courselookup_json.forEach((a) => {
                if (a.courseid == createURL.searchParams.get('courseid')) {
                    $('.preview_course').html(a.coursename)
                }
            });
            courselookup_json.forEach((a) => {
                if (a.courseid == createURL.searchParams.get('courseid')) {
                    $('.preview_course1').html(a.coursename)
                }
            });
            sectionlookup_json.forEach((a) => {
                if (a.sectionid == createURL.searchParams.get('sectionid')) {
                    $('#preview_section').html(a.sectionname)
                }
            });
            $('.preview_admissiondate').html(createURL.searchParams.get('admissiondate'));
            secondlanguagelookup_json.forEach((a) => {
                if (a.secondlanguageid == createURL.searchParams.get('secondlanguageid')) {
                    $('#preview_secondlanguage').html(a.secondlanguagename)
                }
            });

            $('.preview_studentname').html(createURL.searchParams.get('name'));
            $('#preview_studentname1').html(createURL.searchParams.get('name'));
            $('.preview_dateofbirth').html(createURL.searchParams.get('dateofbirth'));
            genderlookup_json.forEach((a) => {
                if (a.genderid == createURL.searchParams.get('genderid')) {
                    $('.preview_gender').html(a.gendername)
                }
            });
            categorylookup_json.forEach((a) => {
                if (a.categoryid == createURL.searchParams.get('categoryid')) {
                    $('.preview_category').html(a.categoryname)
                }
            });
            nationalitylookup_json.forEach((a) => {
                if (a.nationalityid == createURL.searchParams.get('nationalityid')) {
                    $('.preview_nationality').html(a.nationalityname)
                }
            });
            religionlookup_json.forEach((a) => {
                if (a.religionid == createURL.searchParams.get('religionid')) {
                    $('.preview_religion').html(a.religionname)
                }
            });
            $('.preview_aadhaar').html(createURL.searchParams.get('studentaadhaar'));

            $('.preview_fathername').html(createURL.searchParams.get('fathername'));
            $('.preview_mothername').html(createURL.searchParams.get('mothername'));
            $('#preview_parentoccupation').html(createURL.searchParams.get('parentoccupation'));
            $('#preview_visitorname').html(createURL.searchParams.get('visitorname'));
            $('#preview_relation').html(createURL.searchParams.get('relationwithstudent'));
            $('#preview_visitornumber').html(createURL.searchParams.get('visitornumber'));

            boardlookup_json.forEach((a) => {
                if (a.boardid == createURL.searchParams.get('board')) {
                    $('.preview_board').html(a.boardname)
                }
            });
            $('.preview_schoolname').html(createURL.searchParams.get('school'));
            $('.preview_area').html(createURL.searchParams.get('place'));
            $('#preview_grade').html(createURL.searchParams.get('grade'));
            $('#preview_hallticketnumber').html(createURL.searchParams.get('hallticketNo'));

            $('.preview_doorno').html(createURL.searchParams.get('door_street'));
            stateslookup_json.forEach((a) => {
                if (a.state_id == createURL.searchParams.get('state')) {
                    $('.preview_state').html(a.state_name)
                }
            });
            districtslookup_json.forEach((a) => {
                if (a.district_id == createURL.searchParams.get('district')) {
                    $('.preview_district').html(a.district_name)
                }
            });
            $('.preview_city').html(createURL.searchParams.get('city_town'));
            $('.preview_village').html(createURL.searchParams.get('village_mandal'));
            $('.preview_pin').html(createURL.searchParams.get('pin'));
            $('.preview_landmark').html(createURL.searchParams.get('landmark'));
            $('.preview_mobile1').html(createURL.searchParams.get('mobile1'));
            $('.preview_mobile2').html(createURL.searchParams.get('mobile2'));
            $('.preview_email').html(createURL.searchParams.get('email'));
            $('.preview_totalfee').html(createURL.searchParams.get('tuition_discount'));
             $('.preview_hostelfee').html(createURL.searchParams.get('hostel_discount'));
             $('.preview_total').html(createURL.searchParams.get('total_fee'));
            $('.preview_referredby').html(createURL.searchParams.get('referredby'));
            $('.preview_discountrequested').html(createURL.searchParams.get('discountrequested1'));
             $('.preview_discountgiven').html(createURL.searchParams.get('discountgiven1'));
        
            

        }

        function getdistricts_perm(stateid = 0) {
            $.getJSON("<?php echo base_url('home/get_districts') ?>" + "?state_id=" + stateid, function(json) {
                $('#district').empty();
                $('#district').append($('<option>').text("Select District"));
                $.each(json, function(i, obj) {
                    $('#district').append($('<option>').text(obj.district_name).attr('value', obj.district_id));
                });
            });
        }

        window.onload = function() {
            changeFeesBasedOnCourse();
            generatePreview();

            $('#reservationform').validate({
                ignore: [],
                rules: {},
                messages: {},
                errorPlacement: function(error, element) {},
                submitHandler: function() {
                    form.submit();
                },
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
        }
        
         function changeFeesBasedOnCourse() {
             var MaxDiscountPermitted = $('#MaxDiscountPermitted').val();
             $('#text_tuition_fees_total').attr("min", $('#text_tuition_fees_total').val() - MaxDiscountPermitted);
              $('#discountgiven').attr("max", MaxDiscountPermitted);
             

         }

        
    </script>
</div>

<style>
    .nav-tabs>li>a{
    background-color: #29abe0;
    border-color: #fff;
    color: #fff;
    border-bottom-color: 1px solid #fff;
    font-size:16px;
    margin-top: 4px;
}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{
  color: #fff;
    background-color: #93c54b;
    border: 1px solid #93c54b;
    /* border-bottom-color: transparent; */
    cursor: default;
}
.nav-tabs>li>a:hover{
  background-color: #93c54b;
  border-color: #fff;
  color: #fff;
  border-bottom-color: 1px solid #fff;
}
.nav-tabs{
  border-bottom: 1px solid transparent;
}

.select2-container .select2-selection--single {
 height: 50px;
}
.select2-container .select2-selection--single .select2-selection__rendered{
 padding-top: 13px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
 top:12px;
}

</style>