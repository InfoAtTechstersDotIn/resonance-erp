<style>
    @media print{
        .contactdetails
    {
        display:flex;
        justify-content:space-between;

    }
    }

</style>
<div class="content-wrapper">
    <div class="container-fluid dont-display">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reservation Details
                    <?php

                    if ($_SESSION['rights'][array_search('Student', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                        <a class="btn btn-success" data-toggle="modal" data-target="#Resofast" style="float: right;margin-left:10px">Add Resofast Number</a>
                    <?php endif; ?>
                </h2>
                <br />
                <form method="post" id="reservationform" action="<?php
use App\Models\ReservationModel;
                                                                    use App\Models\HelperModel;

                                                                    echo base_url('users/updatereservation') ?>">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a id="ReservationTab" data-toggle="tab" href="#reservation">Reservation Details</a>
                        </li>
                        <li><a id="BasicTab" data-toggle="tab" href="#basic">Basic Details</a></li>
                        <li><a id="FamilyTab" data-toggle="tab" href="#family">Family Details</a></li>
                        <li><a id="EducationTab" data-toggle="tab" href="#education">Education Details</a></li>
                        <li><a id="ContactTab" data-toggle="tab" href="#contact">Contact Details</a></li>
                        <li><a id="FeesTab" data-toggle="tab" href="#fees">Fee Details</a></li>
                        <li><a id="PaymentTab" data-toggle="tab" href="#payment">Payment Details</a></li>
                        <li><a id="PreviewTab" data-toggle="tab" href="#preview" onclick="generatePreview()">Preview and Update</a></li>
                    </ul>

                    <div class="tab-content tab-validate">
                        <?php
                          if ($rezofastdetails) {
                        $rezofastdetails = json_decode($StudentDetail->rezofastdetails);
                          }
                        ?>
                        <div id="reservation" class="tab-pane fade in active">
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Reservation Id<i style="color: red;">*</i></label>
                                    <input type="text" id="reservationid" name="reservationid" class="form-control" value="<?php echo $StudentDetail->reservation_ukey ?>" readonly required>
                                    <br />
                                    <br />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php if ($_SESSION['userdetails']->userid == 1) {
                                        ?>
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
                                    <?php }else
                                    {
                                        ?>
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
                                        
                                    <?php
                                    }?>
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Section<i style="color: red;">*</i></label>
                                    <input type="text" value="UnAssigned" class="form-control" required readonly>
                                    <input type="hidden" id="sectionid" name="sectionid" value="0" class="form-control" required readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Reservation Date<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="dd/mm/yy" id="admissiondate" name="admissiondate" value="<?php echo date_format(date_create($StudentDetail->admissiondate), 'd/m/Y') ?>" class="form-control mb datepicker" required <?php 
                                        ?>>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="secondlanguageid" name="secondlanguageid" style="width: 100%;" class="select2 form-control mb"  <?php 
                                        ?>>
                                        <option value="">Select Second Language</i></option>
                                        <?php
                                        foreach ($lookups['secondlanguagelookup'] as $secondlanguage) :
                                        ?>
                                            <option <?php echo $StudentDetail->secondlanguageid == $secondlanguage->secondlanguageid ? "selected" : "" ?> value="<?php echo $secondlanguage->secondlanguageid; ?>"><?php echo $secondlanguage->secondlanguagename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                 <?php if ($_SESSION['userdetails']->userid == 1) : ?>
                                 <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" name="referredby" style="width: 100%;" class="select2 form-control mb">
                                        <option value="">Select Reference Employee</option>
                                        <?php
                                       // echo $StudentDetail->referredby;
                                            
                                        foreach ($EmployeeDetails as $reference) :
                                           // echo $reference->userid
                                        ?>
                                            <option value="<?php echo $reference->userid ?>" <?php echo $StudentDetail->referredby == $reference->userid ? "selected" : "" ?>><?php echo $reference->employeeid . " - " . $reference->name; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <?php endif ?>
                                <div class="col-md-6">
                                         <img src="<?php echo base_url('reservation/'.$StudentDetail->profile_image)?>" class="img-fluid" height="200px"/>
                                    <br>
                                    <label class="text-uppercase f-16">Profile Image Link : <i style="color: red;"></i></label>
                                    
                                     <h4><a target="_blank" href="<?php print_r('https://maidendropgroup.com/public/users/reservationstudentprofileimage/'.$StudentDetail->reservationid);?>">Upload profile picture</a></h4>
                                    <br />
                                    </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#BasicTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="basic" class="tab-pane fade">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Student Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Name" id="name" name="name" class="form-control mb" value="<?php echo $StudentDetail->name ?>" required>

                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Date Of Birth<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="dd/mm/yy" id="dateofbirth" name="dateofbirth" class="form-control mb datepicker" value="<?php echo date_format(date_create($StudentDetail->dateofbirth), 'd/m/Y') ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="categoryid" name="categoryid" style="width: 100%;" class="select2 form-control mb" >
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
                                    <select onchange="this.classList.remove('error')" id="nationalityid" name="nationalityid" style="width: 100%;" class="select2 form-control mb" >
                                        <option value="">Select Nationality</option>
                                        <?php
                                        foreach ($lookups['nationalitylookup'] as $nationality) :
                                        ?>
                                            <option <?php echo $StudentDetail->nationalityid == $nationality->nationalityid ? "selected" : "" ?> value="<?php echo $nationality->nationalityid; ?>"><?php echo $nationality->nationalityname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="religionid" name="religionid" style="width: 100%;" class="select2 form-control mb" >
                                        <option value="">Select Religion</option>
                                        <?php
                                        foreach ($lookups['religionlookup'] as $religion) :
                                        ?>
                                            <option <?php echo $StudentDetail->religionid == $religion->religionid ? "selected" : "" ?> value="<?php echo $religion->religionid; ?>"><?php echo $religion->religionname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Aadhaar Number<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Aadhaar Number" id="studentaadhaar" name="studentaadhaar" class="form-control mb" value="<?php echo $StudentDetail->studentaadhaar ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Visitor Name</label>
                                    <input type="text" placeholder="Name" id="visitorname" name="visitorname" class="form-control mb" value="<?php echo $StudentDetail->visitorname ?>">

                                </div>
                                <div class="col-md-6">
                                <label class="text-uppercase text-sm">Relationship with student</label>
                                    <input type="text" placeholder="Relation with student" id="relationwithstudent" name="relationwithstudent" class="form-control mb" value="<?php echo $StudentDetail->relationwithstudent ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Visitor Mobile Number</label>
                                    <input type="text" placeholder="Visitor Phone Number" id="visitornumber" name="visitornumber" class="form-control mb" value="<?php echo $StudentDetail->visitornumber ?>">

                                </div>
                            </div>

                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#ReservationTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#FamilyTab').click()">Next</a>
                                </div>
                            </div>

                        </div>
                        <div id="family" class="tab-pane fade">
                            <br>
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
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Parent Occupation</label>
                                    <input type="text" placeholder="Parent Occupation" id="parentoccupation" name="parentoccupation" class="form-control mb" value="<?php echo $StudentDetail->parentoccupation ?>" >
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">

                                    <a class="btn btn-primary" onclick="$('#BasicTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#EducationTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="education" class="tab-pane fade">
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
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Grade/ Marks</label>
                                    <input type="text" placeholder="Grade/ Marks" id="grade" name="grade" value="<?php echo $classInfo->grade ?>" class="form-control mb">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">HallTicket No.</label>
                                    <input type="text" placeholder="HallTicket No." id="hallticketNo" name="hallticketNo" class="form-control mb" value="<?php echo $classInfo->hallticketNo ?>">
                                </div>
                            </div>
                            <br /><br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#FamilyTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#ContactTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="contact" class="tab-pane fade">
                            <br>
                            <?php
                            $Address = json_decode($StudentDetail->address);
                            $permanentAddress = $Address->permanent;
                            ?>
                            <h3><label>Address</label>
                            </h3>
                            <div class="row">
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
                                    <label class="text-uppercase text-sm">Landmark</label>
                                    <input type="text" placeholder="Landmark" id="landmark" name="landmark" class="form-control mb" value="<?php echo $permanentAddress->landmark ?>" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Mobile 1<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile 1" id="mobile1" name="mobile1" class="form-control mb" value="<?php echo $StudentDetail->mobile1 ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Mobile 2<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile 2" id="mobile2" name="mobile2" class="form-control mb" value="<?php echo $StudentDetail->mobile2 ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Email Address<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Email Address" id="email" name="email" class="form-control mb" value="<?php echo $StudentDetail->email ?>" required>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#EducationTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Next</a>
                                </div>
                            </div>
                        </div>

                        <div id="fees" class="tab-pane fade">
                            <br />
                            <?php if($rezofastdetails){
                                
                                ?>
                          
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="6">
                                            Scholar Ship Details
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Resofast Hallticket Number </b><br />
                                            <?php echo $rezofastdetails->hallticketnumber ?>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <b>Resofast Score </b><br />
                                            <?php echo $rezofastdetails->score ?>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <b>Resofast Interview Score </b><br />
                                            <?php echo $rezofastdetails->interviewscore ?>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div style="display: block;">
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        Merit Scholarship
                                    </div>
                                    <div class="col-md-4">
                                        <b>(<span id="meritscholarship" style="color: red;"><?php echo $rezofastdetails->scholarship != null ? $rezofastdetails->scholarship->scholarshipvalue : 0 ?></span>)</b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Interview Scholarship
                                    </div>
                                    <div class="col-md-4">
                                        <b>(<span id="meritinterviewscholarship" style="color: red;"><?php echo $rezofastdetails->scholarship != null ? $rezofastdetails->scholarship->scholarshipinterviewvalue : 0 ?></span>)</b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Discount Requested
                                    </div>
                                    <div class="col-md-4">
                                        <b><span style="color: green;"><?php echo $StudentDetail->amount ?></span></b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Discount Given
                                    </div>
                                    <div class="col-md-4">
                                        <b>(<span style="color: red;"><?php echo $StudentDetail->approvedamount ?></span>)</b>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <br />

                            <?php $helperModel = new HelperModel(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm"><?php echo $StudentDetail->coursename;?></label>
                                    <?php if ($_SESSION['userdetails']->userid == 1) : ?>
                                        <input  type="number" min="0" value="<?php echo $StudentDetail->tuition_discount ?>" onkeyup="changeNormal()" readonly onchange="changeNormal1()" name="tuition_discount" id="text_tuition_fees_total1" class='form-control mb' />
                                        <input type="hidden" value="<?php echo $StudentDetail->tuition_discount ?>" id="1styear">
                                        <input type="hidden" value="<?php echo $StudentDetail->coursename;?>" id="1styearnamefee">
                                    <?php else: ?>
                                        <input type="number" min="0" value="<?php echo $StudentDetail->tuition_discount ?>" onkeyup="changeNormal()" readonly onchange="changeNormal1()" name="tuition_discount" id="text_tuition_fees_total1" class='form-control mb' />
                                    <input type="hidden" value="<?php echo $StudentDetail->tuition_discount ?>" id="1styear">
                                     <input type="hidden" value="<?php echo $StudentDetail->coursename;?>" id="1styearnamefee">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    
                                    <?php
                                      $helperModel = new HelperModel();
                                        $fee = $helperModel->getFeeStructure($StudentDetail->courseid,$StudentDetail->admissiontypeid,$StudentDetail->batchid);
                                        $new = $fee[0]->fee;
                                        $var = (int)$new ;
                                        if($StudentDetail->nextid != 0){
                                        $fee1 = $helperModel->getNextFeeStructure($StudentDetail->nextid,$StudentDetail->admissiontypeid,$StudentDetail->batchid);
                                        $new1 = $fee1[0]->fee;
                                        $new2 = $fee1[0]->coursename;
                                        $var1 = (int)$new1 ;
                                        }else
                                        {
                                            $var1 = 0;
                                            $new2 = '';
                                        }
                                        $kit = $helperModel->getStudentKit($StudentDetail->courseid);
                                        if($StudentDetail->admissiontypeid == 3)
                                        {
                                         $studentkit = $kit[0]->studentkit_dayscholar;
                                        }else
                                        {
                                            $studentkit = $kit[0]->studentkit_resdential;
                                        }
                                             if($var1 !=0){ ?>
                                    <label class="text-uppercase f-16"><?php echo $new2;?></label>
                                  <input type="number" disabled min="0" value="<?php echo $StudentDetail->tuition_discount1 ?>"  name="tuition_discount1" id="text_hostel_fees_total2" class='form-control mb'/>
                                     <input type="hidden" value="<?php echo $StudentDetail->tuition_discount1 ?>" name="tuition_discount1" id="2ndyear">
                                     <input type="hidden" value="<?php echo $new2;?>" name="tuition_discount1" id="2ndyearnamefee">
                                     <?php } 
                                     else
                                     {
                                         ?>
                                         <input type="hidden" value="0" name="tuition_discount1" id="2ndyear">
                                     <input type="hidden" value="0" name="tuition_discount1" id="2ndyearnamefee">
                                         <?php
                                     }
                                    /* $people = array(3,6,8,9,10,13,14,15,16,17);
                                    // if(in_array($StudentDetail->courseid,$people)){
                                    //     ?>
                                    //     <label class="text-uppercase text-sm">Miscellaneous Fee</label>
                                    //     <?php
                                    // }else
                                    // {
                                    //     ?>
                                    //     <label class="text-uppercase text-sm">IPE Fees</label>
                                    //     <?php
                                    // } 
                                    
                                    // if ($_SESSION['userdetails']->roleid == 1) : ?>
                                    //     <input type="number" min="0" value="0" onkeyup="changeNormal()" readonly onchange="changeNormal()" name="ipe_discount" id="text_ipe_fees_total" class='form-control mb' />
                                    // <?php else: ?>
                                    //     <input type="number" min="0" value="0" onkeyup="changeNormal()" readonly onchange="changeNormal()" name="ipe_discount" id="text_ipe_fees_total" class='form-control mb'  <?php 
                                    //     ?>/>
                                    // <?php endif; ?> 
                                    */
                                    ?>
                                </div>
                              <!--  <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Hostel Fees</label>
                                    <input type="number" min="0" value="0" onkeyup="changeNormal()" readonly onchange="changeNormal()" name="hostel_discount" id="text_hostel_fees_total" class='form-control mb' <?php 
                                        ?>/>
                                </div> -->
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Comments</label>
                                    <input type='text' name='comments' placeholder="comments" class='form-control mb' value="<?php echo $StudentDetail->comments ?>">
                                </div>
                            </div>
                            <br />
                            <div id="feecontent"></div>
                            <div id="totalfeecontent"></div>
                            <br />

                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#ContactTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#PaymentTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="payment" class="tab-pane fade">
                            <br>
                            <br>
                            <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                                <a class="btn btn-success" style="background-color: #00203d;" data-toggle="modal" data-target="#addpayment">Add Payment</a>
                            <?php endif; ?>
                            <br><br>
                            <div class="row">
                                <div class="col-md-12">
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
                                                 <?php
                                                    if($_SESSION['userdetails']->rolename == "CFO"){
                                                        ?>
                                                <th>Edit</th>
                                                <?php } ?>
                                                <?php
                                                    if($_SESSION['userdetails']->rolename == "CFO" || $_SESSION['userdetails']->rolename == "Accounts"){
                                                        ?>
                                                <th>Delete</th>
                                                <?php } ?>
                                                <!-- <th>
                                                    <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) : ?>
                                                        Edit
                                                    <?php endif; ?>
                                                </th>
                                                <th>
                                                    <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                                        Delete
                                                    <?php endif; ?>
                                                </th> -->
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php

                                            foreach ($PaymentDetail as $result) :
                                            ?>

                                                <tr>
                                                    <td><a target="_blank" href="<?php echo base_url('payments/generatereservationreceipt') ?>?reservationpaymentid=<?php echo $result->reservation_paymentid ?>&type=view"><?php echo $result->reservation_paymentid ?></a></td>
                                                    <td><?php echo $result->paymentstatusname ?></td>
                                                    <td><?php echo $result->paymentamount ?></td>
                                                    <td><?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?></td>
                                                    <td><?php echo $result->paymenttypename ?></td>
                                                    <td><?php echo $result->otherdetails ?></td>
                                                    <td><?php echo $result->receivedby ?></td>
                                                     <?php
                                                    if($_SESSION['userdetails']->rolename == "CFO"){
                                                        ?>
                                                        <td>
                                                            <i data-toggle="modal" data-target="#editpayment" class="fa fa-pencil-square-o" onclick="editPayment('<?php echo $result->reservation_paymentid ?>','<?php echo $result->name ?>','<?php echo $result->paymenttypeid ?>','<?php echo $result->paymentamount ?>','<?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?>','<?php echo $result->otherdetails ?>','<?php echo $result->remarks ?>')"></i>
                                                            <?php
                                                             ?>
                                                        
                                                    </td>
                                                    <?php } ?>
                                                    <?php
                                                    if($_SESSION['userdetails']->rolename == "CFO"){
                                                        ?>
                                                        <td>
                                                            <?php
                                                            $html = "<a href='" . base_url('payments/deletereservationpayment') . "?paymentid=" . $result->reservation_paymentid . "&reservationid=".$result->reservationid."' class='btn-del'><i class='fa fa-trash'></i></a>";
                                                            echo $html; ?>
                                                        
                                                    </td>
                                                    <?php } ?>
                                                    <!-- <td>
                                                        <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) :
                                                            if ($result->paymentstatusname != "Approved") :
                                                        ?>
                                                        <?php
                                                            endif;
                                                        endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                                            <?php
                                                            $html = "<a href='" . base_url('payments/deletepayment') . "?paymentid=" . $result->reservation_paymentid . "' class='btn-del'><i class='fa fa-trash'></i></a>";
                                                            echo $html; ?>
                                                        <?php endif; ?>
                                                    </td> -->
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#PreviewTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="preview" class="tab-pane fade">
                            <div id="print_preview">
                                <table style="width: 100%;margin: 0;">
                                    <br />

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Reservation Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Reservation Id: <b><span id="preview_reservationid"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Admission Type: <b><span id="preview_admissiontype"></span></b></td>
                                        <td>Branch: <b><span id="preview_branch"></span></b></td>
                                        <td>Batch: <b><span id="preview_batch"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Course: <b><span id="preview_course"></span></b></td>
                                        <td>Section: <b><span id="preview_section"></span></b></td>
                                        <td>Admission Date: <b><span id="preview_admissiondate"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Second Language: <b><span id="preview_secondlanguage"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Basic Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Student Name: <b><span id="preview_studentname"></span></b></td>
                                        <td>Date Of Birth: <b><span class="preview_dateofbirth"></span></b></td>
                                        <td>Gender: <b><span class="preview_gender"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Category: <b><span id="preview_category"></span></b></td>
                                        <td>Nationality: <b><span id="preview_nationality"></span></b></td>
                                        <td>Religion: <b><span id="preview_religion"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Aadhaar Number: <b><span class="preview_aadhaar"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Family Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Father Name/ Guardian Name: <b><span id="preview_fathername"></span></b></td>
                                        <td>Mother Name: <b><span id="preview_mothername"></span></b></td>
                                        <td>Parent Occupation: <b><span id="preview_parentoccupation"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Education Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Board Name: <b><span class="preview_board"></span></b></td>
                                        <td>School Name: <b><span class="preview_schoolname"></span></b></td>
                                        <td>Area/ Place: <b><span id="preview_area"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Grade/ Marks: <b><span id="preview_grade"></span></b></td>
                                        <td>Hallticket Number: <b><span id="preview_hallticketnumber"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Contact Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Door No./ Street Name: <b><span class="preview_doorno"></span></b></td>
                                        <td>State: <b><span id="preview_state"></span></b></td>
                                        <td>District: <b><span id="preview_district"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>City/ Town: <b><span class="preview_city"></span></b></td>
                                        <td>Village/ Mandal: <b><span class="preview_village"></span></b></td>
                                        <td>Pin: <b><span id="preview_pin"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Landmark: <b><span id="preview_landmark"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile1: <b><span class="preview_mobile1"></span></b></td>
                                        <td>Mobile2: <b><span class="preview_mobile2"></span></b></td>
                                        <td>Email Address: <b><span class="preview_email"></span></b></td>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Fee Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Total Fee: <b><span id="preview_totalfee"></span></b></td>
                                        <td>Comments: <b><span id="preview_comments"></span></b></td>
                                    </tr>
                                </table>
                            </div>
                           
                            <br />
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="reservationstatusid" style="width: 100%;" class="form-control">
                                        <option value="">Select Reservation Status</option>
                                        <?php
                                        //if ($_SESSION['userdetails']->roleid == 1) {
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
                                </div>
                                <div class="col-md-4">
                                    <?php
                                    //echo $_SESSION['userdetails']->roleid;
                                    if ($_SESSION['userdetails']->roleid == 1 ) {
                                        ?>
                                        <button type="submit" name="createstudent" class="btn btn-primary">Update Reservation</button>
                                        
                                        <?php
                                    }
                                    if($_SESSION['userdetails']->roleid == 3 || $_SESSION['userdetails']->userid == 7181)
                                    {
                                         ?>
                                        <button type="submit" name="updatestudent" class="btn btn-primary">Update Reservation Details</button>
                                        
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-primary" onclick="$('#PaymentTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="print_preview()">Print Application</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="print_preview1()">Print ON BOARDFORM</a>&nbsp;&nbsp;&nbsp;
                                    
                                    
                                    <?php
                                    
                                      $reservationModel = new ReservationModel();
                                   $PaymentDetail = $reservationModel->getReservationPaymentDetailsByReservationId($StudentDetail->reservationid);
                                   $totalPayment=0;
                                   foreach ($PaymentDetail as $payment) :
                                       $totalPayment = $totalPayment+$payment->paymentamount;
                                    //if( $payment->paymentstatusid == 3)
                                   // {
                                        
                                    //}
                                   endforeach;
                                    
                                      $helperModel = new HelperModel();
                                  $ipe =  $helperModel->get_fees_from_lookup($StudentDetail->courseid, $StudentDetail->admissiontypeid, $StudentDetail->batchid, 'Intermediate Fee');
                                 
                                   $tution =  $helperModel->get_fees_from_lookup($StudentDetail->courseid, $StudentDetail->admissiontypeid, $StudentDetail->batchid, 'Tuition Fee');
                                    $hostel =  $helperModel->get_fees_from_lookup($StudentDetail->courseid, $StudentDetail->admissiontypeid, $StudentDetail->batchid, 'Hostel Fee');
                                     $laundry =  $helperModel->get_fees_from_lookup($StudentDetail->courseid, $StudentDetail->admissiontypeid, $StudentDetail->batchid, 'Laundry');
                                     $uniform =  $helperModel->get_fees_from_lookup($StudentDetail->courseid, $StudentDetail->admissiontypeid, $StudentDetail->batchid, 'Uniform');
                                      $books =  $helperModel->get_fees_from_lookup($StudentDetail->courseid, $StudentDetail->admissiontypeid, $StudentDetail->batchid, 'Books');
                                       $caution =  $helperModel->get_fees_from_lookup($StudentDetail->courseid, $StudentDetail->admissiontypeid, $StudentDetail->batchid, 'Caution Deposit');
                                   $finalfee = ($tution + $hostel + $ipe + $laundry + $books + $caution + $uniform)- $StudentDetail->discountgiven;
                                 // echo $result->tuition_discount;
                                   
                                  $halffee = (40 / 100) * $finalfee;
                                 // echo $halffee;
                                  // echo $totalPayment;
                                // echo  $result->reservationstatusname;
                                  //$halffee = $finalfee/2;
                                    if($StudentDetail->reservationstatusid==4 && $StudentDetail->is_migrate==0)
                                    {
                                        echo "<a href='" . base_url('users/migratestudent?id=') . $StudentDetail->reservationid . "' class='btn btn-primary'>Migrate</a>";
                                       // echo 1111;
                                    }
                                    if($StudentDetail->is_migrate==1)
                                    {
                                        echo "<a class='btn btn-primary'>Migrated</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="coachingfee" name='coachingfee'  />
                    <input type="hidden" id="hostelfee" name='hostelfee'  />
                    <input type="hidden" id="ipefee" name='ipefee'  />
                    <input type="hidden" id="scholarship" name='scholarship'  />
                    <input type="hidden" id="discountgiven" name='discountgiven' value="<?php echo $StudentDetail->discountgiven ?>"  />
                    <input type="hidden" id="id" name='id' value="<?php echo $StudentDetail->reservationid ?>"  />
                    <input type="hidden" id="hdnrezofastdetails" name='rezofastdetails' value="" />
                </form>
                
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
                                          <form method="post" action="<?php echo base_url('payments/updatereservationpayment') ?>">
                                             <br>
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <input type="hidden" name="returnURL" value="users/reservationDetails?id=<?php echo $StudentDetail->reservationid; ?>" />
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
                                                   <input type="number" id="paymentamount" name="paymentamount" class="form-control mb" required>
                                                </div>
                                                <div class="col-md-6">
                                                   <label class="text-uppercase text-sm">Payment Details</label>
                                                   <input type="text" id="otherdetails" name="otherdetails" class="form-control mb" required>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <label class="text-uppercase text-sm">Payment Date</label>
                                                   <input type="text" id="paymentdate" name="paymentdate" readonly class="form-control mb" required>
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

                <div class="modal fade" id="Resofast" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 80vw">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Load Student Details with Resofast</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="<?php echo base_url('users/reservationDetails') ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Reso Fast Hallticket Number</label>
                                            <input type="text" placeholder="Reso Fast Hallticket Number" name="resofast" class="form-control">
                                            <input type="hidden" name="id" value="<?php echo $StudentDetail->reservationid ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <br />
                                            <button type="submit" class="btn btn-primary">Load</button>
                                        </div>
                                    </div>
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
                                <form method="post" action="<?php echo base_url('payments/addReservationPayment') ?>">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="hidden" name="reservationid" value="<?php echo $StudentDetail->reservationid; ?>" />
                                            <input type="hidden" name="returnURL" value="users/reservationDetails?id=<?php echo $StudentDetail->reservationid ?>" />

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
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Payment Amount</label>
                                            <input type="number" placeholder="Payment Amount" name="paymentamount" class="form-control mb" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Payment Details</label>
                                            <input type="text" placeholder="UTR No / Check No / Recipt No" name="otherdetails" class="form-control mb" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                             <label class="text-uppercase text-sm">Payment Date</label>
                                             <input type="text" placeholder="dd/mm/yy" name="paymentdate" class="form-control mb paymentdate" required>
                                          </div> -->
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
                                    <button type="submit" name="addpayment" class="btn btn-primary">Add Payment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <div id="print_preview1" style="display:none; border:1px solid black;">
                                <table style="width: 100%;margin: 0;border:1px solid black;">
                                    <tr>
                                        <th style="text-align:center !important; border-bottom:1px solid black;    display: flex;
    justify-content: center; width:50%; margin-left:auto; margin-right:auto;">STUDENT ONBOARDING FORM</th>
                                    </tr>
                                   
                                    <tr>
                                        <th style="text-align:right !important;">Date:<?php echo date("d-m-Y"); ?></th>
                                    </tr>
                                    <tr>
                                        <td>To,<br>The Resonance College,<br>Hyderabad.<br><br>I have decided to join my ward for <b><span class="preview_course1"></span></b> course in <b><span class="preview_branch1"></span></b> branch as <b><span class="preview_admissiontype1"></span></b> student.
                                        Here by i am confirming that all the details furnished regarding my ward Admission are correct. 
                                        </td>
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr><td><b>Student Details</b></td></tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Reservation Number:</span> <b style="margin-right: auto;"><span id="preview_reservationid1"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Student Name:</span> <b style="margin-right: auto;"><span id="preview_studentname1"></span></b></td>
                                    </tr>
                                    <tr  style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Date Of Birth:</span> <b style="margin-right: auto;"><span class="preview_dateofbirth"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Category:</span> <b style="margin-right: auto;"><span class="preview_category"></span></b></td>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Nationality:</span> <b style="margin-right: auto;"><span class="preview_nationality"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Religion:</span> <b style="margin-right: auto;"><span class="preview_religion"></span></b></td>
                                    </tr>
                                    
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Gender:</span> <b style="margin-right: auto;"><span class="preview_gender"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Aadhar Number:</span> <b style="margin-right: auto;"><span class="preview_aadhaar"></span></b></td>
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr><td><b>Education Details</b></td></tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">School/College:</span> <b style="margin-right: auto;"><span class="preview_schoolname"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Board:</span> <b style="margin-right: auto;"> <b><span class="preview_board"></span></b></td>
                                    </tr>
                                    <tr>
                                    
                                    </tr>
                                    <tr><td><br></td></tr>
                                    <tr><td><b>Family Details</b></td></tr>
                                    <tr style="display:flex;">    
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Father/Guardian Name:</span> <b style="margin-right: auto;"><span class="preview_fathername"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Mother's Name:</span> <b style="margin-right: auto;"><span class="preview_mothername"></span></b></td>
                                    </tr>
                                    <tr>    
                                        
                                    </tr>
                                    <tr>
                                        <th style="float: left !important;"><br />Contact Details</th>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Door No./ Street Name:</span> <b style="margin-right: auto;"><span class="preview_doorno"></span</b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Colony/Village:</span> <b style="margin-right: auto;"><span class="preview_village"></span></b></td>
                                       
                                       
                                    </tr>
                                    <tr  style="display:flex;">
                                         <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">City/ Town: </span> <b style="margin-right: auto;"><span class="preview_city"></span></b></td>
                                         <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Email Address: </span> <b style="margin-right: auto;"><span class="preview_email"></span></b></td>
                                    </tr>
                                     <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Mobile1: </span> <b style="margin-right: auto;"><span class="preview_mobile1"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Mobile2: </span> <b style="margin-right: auto;"><span class="preview_mobile2"></span></b></td>
                                    </tr>
                                    <tr>
                                        <th style="float: left !important;"><br />Visitor Details</th>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Name:</span> <b style="margin-right: auto;"><span id="preview_visitorname"></span</b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Relationship with student: </span> <b style="margin-right: auto;"><span id="preview_relation"></span></b></td>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Mobile Number: </span> <b style="margin-right: auto;"><span id="preview_visitornumber"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;"></span> <b style="margin-right: auto;"><span id=""></span></b></td>

                                    </tr>
                                    <tr>
                                        <th style="float: left !important;"><br />Fee Details</th>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Approved Fee for 1st Year:</span> <b style="margin-right: auto;"><span id="preview_totalfee2"></span></b></td>
                                          <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Reservation Amount Paid: </span> <b style="margin-right: auto;"><span id=""><?php
                                       $TotalPaid = 0;
                                       $TotalPaid1 = 0;
                                       foreach($PaymentDetail as $result)
                                       {
                                           if($result->paymenttypeid != 10){
                                            $TotalPaid1 = $TotalPaid1+$result->paymentamount;
                                           }
                                           $TotalPaid = $TotalPaid+$result->paymentamount;
                                       }
                                        echo $TotalPaid1-2500 ;
                                        
                                        ?>
                                        <input type="hidden" value="<?php echo $TotalPaid-2500 ;?>" id="preview_resamount">
                                        <input type="hidden" value="<?php echo $studentkit ;?>" id="preview_mis">
                                        
                                        </span></b></td>
                                    </tr>
                                     <tr style="display:flex;">
                                         
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Application Processing Fee: </span> <b style="margin-right: auto;">2500</b></td>
                                        
                                         <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Balance to be Paid: </span> <b style="margin-right: auto;"><span id="preview_bal"></span></b></td>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">At the time of reporting(50%) + Miscellaneous Charges: </span> <b style="margin-right: auto;"><span id="preview_reporting"></span></b></td>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">1st Installment<br>(25% - 15th Oct): </span> <b style="margin-right: auto;"><span id="preview_1st"></span></b></td>
                                    </tr>
                                    <tr style="display:flex;">
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">2nd Installment<br>(25% - 10th Jan): </span> <b style="margin-right: auto;"><span id="preview_2nd"></span></b>
                                          
                                        </td>
                                          <?php
                                        if($var1 !=0){ ?>
                                                <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;">Approved Fee for 2nd Year :</span> <b style="margin-right: auto;"><span id="preview_totalfee3"></span></b></td>

                                        <?php }else{ ?>
                                        <td style="width: 100%;  border:1px solid #edebe6;border: 1px solid #edebe6;display: flex;justify-content: space-between;"><span style="width: 50%;"> </span> <b style="margin-right: auto;"><span id=""></span></b>
                                          
                                        </td>
                                     <?php } ?>
                                    </tr>
 
                                    <tr>
                                        <td>
                                           <br>
                                           <br>
                                           <br>
                                            <br>
                                             <br>
                                              <br>
                                        
                                            <b>Undertaking by the student</b>: I will abide by all the rules and regulations of the college. I will follow the discipline of the institution and strictly adopt anti ­
                                    ragging policies. In the event of my misbehavior, I will not question the action whatsoever taken by the authorities of the Institution, as a part of discipline,
                                    including my expulsion. I am informed by the management that electronic items like cell phones, FM Radio, Video games etc., should not be brought into the
                                    campus. If the student doesn't join for any reason reservation fee will not be refunded.
                                    <br>
                                    <br> <br />
                                    <span style='float:right;'>Signature of student </span>
                                    </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><br /><b>Undertaking by the parent</b>: I know that the fee paid towards reservation is non-refundable in any case. Cancellation of admission or settlement of account is
                                    as per the conditions mentioned above by the management. If my ward/visitor/misbehaves or creates any disturbance on the campus, the concerned ward
                                    will be transferred to the Day-Scholar campus or will be terminated from the Institution. The Institution will not bear any kind of responsibility for my ward's
                                    behavior outside the campus. If my ward leaves the campus without obtaining prior permission from the administrative authorities of the campus concerned
                                    the institution authorities are not held responsible and I myself will take up the responsibility of my ward. I understand that such actions on the part of the my
                                    ward may result to the terminatation from the Institution.
                                    <ul>
                                        <li>Fee paid for my ward will not be transferred to another student's name in any case.</li>
                                     <li>If I want to shift my ward from your institution to other before completion of two years course, I shall payback the concession given at the time of
                                    admission.</li>
                                     <li>Fee structure and concession may vary from branch to branch. The course fee does not include transport.</li>
                                     <li>Allotment of campus and section is at the sole discretion of the management. The management reserves the right to shift the students from one
                                    campus to another campus.</li>
                                     <li>Fee concession, if offered will be valid for that academic year only. Any other taxes will be collected separately, where ever applicable.</li>
                                     <li>Permission can be given to my ward, if he/she wishes to go out from the campus on any urgency or during the common outing.</li>
                                     <li> Reservation Fee once paid will not be refunded at any cost.</li>
                                     <li>Rs.10000/- from Reservation fee will be adjusted towards Tution Fee</ul>
                                    <br>
                                    <br>
                                    <span style='float:right;'>Signature of Parent </span>
                                    </td>
                                                                        </tr>
                                    </table>
                                    <br>
                                    <!--
                                    <table style='border: 1px solid #dddddd;width: 100%;margin: 0;border-collapse: collapse;' >
                                        <thead>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Details</td>
                                            <td style='border: 1px solid #dddddd'>Course</td>
                                        </tr>
                                        </thead>
                                        <tbody style='border: 1px solid #dddddd'>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Total Fee</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_totalfee12"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Concession Fee</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_concessionfee"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Committed Fee</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_committedfee"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>Miscellaneous Charges</td>
                                            <td style='border: 1px solid #dddddd'><span id="preview_misfee"><span></td>
                                        </tr>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'><b>Total Payable Amount</b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_t"><span></b></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h2>Payment Details</h2>
                                <div class="row" style="display:flex;">
                                
                                    <div class="col-md-5" style="flex:50%;max-width:50%">
                                    <h4>Payment Method - Direct Payment</h4>
                                    <p>Reservation Amount: <span id="preview_course"></span></p>
                                    <p>1st Installment Amount: <span id="preview_course"></span></p>
                                    <p>2nd Installment Amount: <span id="preview_course"></span></p>
                                    <table style='border: 1px solid #dddddd;width: 100%;margin: 0;border-collapse: collapse;'>
                                        <tr style='border: 1px solid #dddddd'>
                                            <td style='border: 1px solid #dddddd'>S.no</td>
                                            <td style='border: 1px solid #dddddd'>Cheque No</td>
                                            <td style='border: 1px solid #dddddd'>Amount </td>
                                            <td style='border: 1px solid #dddddd'>Bank Name </td>
                                            <td style='border: 1px solid #dddddd'>Cheque Date</td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">1</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">2</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">3</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        <tr>
                                        <td style='border: 1px solid #dddddd'><b><span id="preview_totalfee">4</span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                            <td style='border: 1px solid #dddddd'><b><span id="preview_comments"></span></b></td>
                                        </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-2" style="flex:10%;max-width:10%">
                                    </div>
                                    <div class="col-md-5" style="flex:40%;max-width:40%">
                                    <h4>Payment Method - Bajaj Payment</h4>
                                    <p>Reservation Amount: <span id="preview_course"></span></p>
                                    <p>Initial Payment: <span id="preview_course"></span></p>
                                    <p>Final Approved Fee: <span id="preview_course"></span></p>
                                    <p>Bajaj Application No: <span id="preview_course"></span></p>
                                    <p>Bajaj Application Date: <span id="preview_course"></span></p>
                                    <p>Bajaj Net Loan Amount: <span id="preview_course"></span></p>
                                    <p>Balance Amount: <span id="preview_course"></span></p>
                                    </div>
                                </div>-->
                                
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <div class="row" style="display:flex;">
                                    <div class="col-md-6" style="flex:50%;max-width:50%">
                                    <b>Accountant</b></div>
                                    <div class="col-md-4" style="flex:50%;max-width:50%">
                                    <b></b></div>
                                    <div class="col-md-2" style="flex:40%;max-width:40%">
                                    <b>Principal</b>
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

            $('#preview_reservationid').html(createURL.searchParams.get('reservationid'));
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('#preview_admissiontype').html(a.admissiontypename)
                }
            });
            $('#preview_reservationid1').html(createURL.searchParams.get('reservationid'));
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('#preview_admissiontype').html(a.admissiontypename)
                }
            });
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('.preview_admissiontype1').html(a.admissiontypename)
                }
            });
            branchlookup_json.forEach((a) => {
                if (a.branchid == createURL.searchParams.get('branchid')) {
                    $('#preview_branch').html(a.branchname)
                }
            });
            branchlookup_json.forEach((a) => {
                if (a.branchid == createURL.searchParams.get('branchid')) {
                    $('.preview_branch1').html(a.branchname)
                }
            });
            batchlookup_json.forEach((a) => {
                if (a.batchid == createURL.searchParams.get('batchid')) {
                    $('#preview_batch').html(a.batchname)
                }
            });
            courselookup_json.forEach((a) => {
                if (a.courseid == createURL.searchParams.get('courseid')) {
                    $('#preview_course').html(a.coursename)
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
            $('#preview_admissiondate').html(createURL.searchParams.get('admissiondate'));
            secondlanguagelookup_json.forEach((a) => {
                if (a.secondlanguageid == createURL.searchParams.get('secondlanguageid')) {
                    $('#preview_secondlanguage').html(a.secondlanguagename)
                }
            });

            $('#preview_studentname').html(createURL.searchParams.get('name'));
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
            $('#preview_area').html(createURL.searchParams.get('place'));
            $('#preview_grade').html(createURL.searchParams.get('grade'));
            $('#preview_hallticketnumber').html(createURL.searchParams.get('hallticketNo'));

            $('.preview_doorno').html(createURL.searchParams.get('door_street'));
            stateslookup_json.forEach((a) => {
                if (a.state_id == createURL.searchParams.get('state')) {
                    $('#preview_state').html(a.state_name)
                }
            });
            districtslookup_json.forEach((a) => {
                if (a.district_id == createURL.searchParams.get('district')) {
                    $('#preview_district').html(a.district_name)
                }
            });
            $('.preview_city').html(createURL.searchParams.get('city_town'));
            $('.preview_village').html(createURL.searchParams.get('village_mandal'));
            $('#preview_pin').html(createURL.searchParams.get('pin'));
            $('#preview_landmark').html(createURL.searchParams.get('landmark'));
            $('.preview_mobile1').html(createURL.searchParams.get('mobile1'));
            $('.preview_mobile2').html(createURL.searchParams.get('mobile2'));
            $('.preview_email').html(createURL.searchParams.get('email'));
if($('#text_hostel_fees_total').val() > 0)
{
            $('#preview_totalfee').html(parseFloat($('#1styear').val()));
            $('#preview_totalfee1').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualIntermediateFee) + parseFloat($('#discountgiven').val()));
            $('#preview_committedfee').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualIntermediateFee));
            $('#preview_misfee').html(parseFloat(parseFloat(actualMiscellaneousFee)));
            $('#preview_comments').html(createURL.searchParams.get('comments'));
            $('#preview_concessionfee').html(createURL.searchParams.get('discountgiven'));
            $('#preview_totalfee2').html(parseFloat($('#1styear').val()));
            $('#preview_bal').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee) - parseFloat($('#preview_resamount').val()));
            $('#preview_reporting').html(Math.abs((parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualIntermediateFee))/2 - parseFloat($('#preview_resamount').val()) +  parseFloat(actualMiscellaneousFee)));
            $('#preview_1st').html((parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualIntermediateFee))/4);
            $('#preview_2nd').html((parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val())  + parseFloat(actualIntermediateFee))/4);
}else
{
    $('#preview_totalfee').html(parseFloat($('#1styear').val()));
    $('#preview_totalfee1').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + (parseFloat(actualIntermediateFee)- $('#discountgiven').val()) + parseFloat($('#discountgiven').val()));
            $('#preview_committedfee').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + (parseFloat(actualIntermediateFee)- $('#discountgiven').val()));
            $('#preview_misfee').html(parseFloat(parseFloat(actualMiscellaneousFee)));
            $('#preview_comments').html(createURL.searchParams.get('comments'));
            $('#preview_concessionfee').html(createURL.searchParams.get('discountgiven'));
            $('#preview_totalfee2').html(parseFloat($('#1styear').val()));
             $('#preview_totalfee3').html(parseFloat($('#2ndyear').val()));
            $('#preview_bal').html(parseFloat($('#1styear').val()) - parseFloat($('#preview_resamount').val()));
              if(((parseFloat($('#1styear').val()))/2) - parseFloat($('#preview_resamount').val()) <= 0)
              {
                  $('#preview_reporting').html(0);
              }else
              {
                $('#preview_reporting').html(((parseFloat($('#1styear').val()))/2) + parseFloat($('#preview_mis').val()) - parseFloat($('#preview_resamount').val()));
              }
              if (((parseFloat($('#1styear').val()) )/2) - parseFloat($('#preview_resamount').val()) < 0) {
              if(Math.abs(((parseFloat($('#1styear').val()))/2) - parseFloat($('#preview_resamount').val())) > (parseFloat($('#1styear').val()))/4)
              {
                  $('#preview_1st').html(0);
              }
              else if(parseFloat($('#preview_resamount').val()) - Math.abs(((parseFloat($('#1styear').val()))/2) - parseFloat($('#preview_resamount').val())) > 0)
              {
                   $('#preview_1st').html((parseFloat($('#1styear').val()))/4 -Math.abs(((parseFloat($('#1styear').val()))/2) - parseFloat($('#preview_resamount').val())));
              }
              else
              {
                $('#preview_1st').html((parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + (parseFloat(actualIntermediateFee)- $('#discountgiven').val()))/4);
              }
              }else
              {
              $('#preview_1st').html((parseFloat($('#1styear').val()))/4);
              }
                            if (((parseFloat($('#1styear').val()) )/2) - parseFloat($('#preview_resamount').val()) < 0) {

              if(Math.abs(((parseFloat($('#1styear').val()))/2) - parseFloat($('#preview_resamount').val())) > (parseFloat($('#1styear').val()) )/8)
              {
                  $('#preview_2nd').html(0);
              }else
              {
                $('#preview_2nd').html((parseFloat($('#1styear').val()))/4);
            }
                            }else
                            {
                                                $('#preview_2nd').html((parseFloat($('#1styear').val()))/4);

                            }
            }
            

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
            var course_id = $('#courseid').val();
            //alert(course_id);
            var admissiontype_id = $('#admissiontypeid').val();
            var batch_id = $('#batchid').val();
            if(admissiontype_id==1)
            {
                $("#text_hostel_fees_total").attr("readonly", false); 
            }else
            {
                $("#text_hostel_fees_total").attr("readonly", true); 
            }
            if(admissiontype_id==3)
            {
                $("#text_ipe_fees_total").attr("readonly", false); 
            }
            else
            {
                $("#text_ipe_fees_total").attr("readonly", true); 
            }
            $('#feecontent').html('');
            var fees = "";

            actualCoachingFee = 0;
            actualHostelFee = 0;
            actualMiscellaneousFee = 0;
            actualIntermediateFee = 0;

            $('#coachingfee').val(0);
            $('#text_tuition_fees_total').val(0);
            $('#text_tuition_fees_total').attr("min", 0);
            $('#text_tuition_fees_total').attr("max", 0);
          //  $('#text_hostel_fees_total').val(0);
            $('#text_hostel_fees_total').attr("min", 0);
         //   $('#text_hostel_fees_total').attr("max", actualHostelFee);
            $('#totalfeecontent').html("");

            if (course_id != "" && admissiontype_id != "" && batch_id != "") {
                
                feestructurelookup_json.map((a) => {
                    if (a.courseid == course_id && a.admissiontypeid == admissiontype_id && a.batchid == batch_id) {
                        //alert(a.feetype);
                        if (a.feetype == "Tuition Fee") {
                            actualCoachingFee = a.feesvalue;
                        }
                        if (a.feetype == "Books") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee += parseFloat(a.feesvalue);
                        }
                        if (a.feetype == "Uniform") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee += parseFloat(a.feesvalue);
                        }
                        if (a.feetype == "Caution Deposit") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee += parseFloat(a.feesvalue);
                        }
                        if (a.feetype == "Laundry") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee += parseFloat(a.feesvalue);
                        }
                        const array = [3,6,8, 9, 10,13,14,15];
                        const value = parseInt(course_id);
                        const isInArray = array.includes(value);
                        if(isInArray == true)
                        {
                            if (a.feetype == "Miscellaneous Charges") {
                                                    actualIntermediateFee = a.feesvalue;
                                                }
                        }else{
                                                if (a.feetype == "Intermediate Fee") {
                                                    actualIntermediateFee = a.feesvalue;
                                                }
                        }
                        if (a.feetype == "Hostel Fee") {
                            actualHostelFee = a.feesvalue;
                        }
                    };
                });
                change(admissiontype_id);
            }
            $('#feecontent').html(fees);
        }

        function change(admissiontype_id) {
            
            if(admissiontype_id==1)
            {
            var ms = parseFloat($('#meritscholarship').html()) + parseFloat($('#meritinterviewscholarship').html());
            $('#scholarship').val(ms);
            $('#coachingfee').val(actualCoachingFee - ms);
            $('#hostelfee').val(actualHostelFee);
            $('#ipefee').val(actualIntermediateFee);
            $('#text_tuition_fees_total').attr("min", 0);
            $('#text_tuition_fees_total').attr("max", $('#coachingfee').val());
            $('#text_tuition_fees_total').attr("title", "Fees Should be between " + 0 + " and " + $('#coachingfee').val());
            $('#text_tuition_fees_total').val($('#coachingfee').val());
            $('#text_ipe_fees_total').val(actualIntermediateFee);
            $('#text_hostel_fees_total').attr("min", 0);
           // $('#text_hostel_fees_total').attr("max", actualHostelFee);
            $('#text_hostel_fees_total').val($('#hostelfee').val() - $('#discountgiven').val());
            }else
            {
                var ms = parseFloat($('#meritscholarship').html()) + parseFloat($('#meritinterviewscholarship').html());
                $('#scholarship').val(ms);
                $('#coachingfee').val(actualCoachingFee - ms);
                $('#hostelfee').val(actualHostelFee);
                $('#ipefee').val(actualIntermediateFee);
                $('#text_tuition_fees_total').attr("min", 0);
                $('#text_tuition_fees_total').attr("max", $('#coachingfee').val());
                $('#text_tuition_fees_total').attr("title", "Fees Should be between " + 0 + " and " + $('#coachingfee').val());
                $('#text_tuition_fees_total').val($('#coachingfee').val());
                $('#text_ipe_fees_total').val(actualIntermediateFee - $('#discountgiven').val());
                $('#text_hostel_fees_total').attr("min", 0);
                $('#text_hostel_fees_total').attr("max", actualHostelFee);
                $('#text_hostel_fees_total').val($('#hostelfee').val());
            }
            //changeNormal(admissiontype_id);
        }

        function changeNormal(admissiontype_id=0) {
            if(admissiontype_id==0)
            {
            if($('#hostelfee').val()>0)
            {
            $('#discountgiven').val($('#hostelfee').val() - $('#text_hostel_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee)) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }else
            {
            $('#discountgiven').val($('#ipefee').val() - $('#text_ipe_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat($('#text_ipe_fees_total').val())) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }
            }else
            {
                if(admissiontype_id==1)
            {
            $('#discountgiven').val($('#hostelfee').val() - $('#text_hostel_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee)) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }else
            {
                $('#discountgiven').val($('#ipefee').val() - $('#text_ipe_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat($('#text_ipe_fees_total').val())) + "</div><div class='col-md-4'>&nbsp;</div></div>");
            }
            }
        }
      $("#admissiondate").datepicker({ dateFormat: 'dd/mm/yy', minDate: 0,maxDate:0 });
    </script>
</div>