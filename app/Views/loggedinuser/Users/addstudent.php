<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Add Student</h2>
                <br />
                <form method="post" id="studentform" action="<?php

                                                                use App\Models\HelperModel;

                                                                echo base_url('users/createstudent') ?>">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a id="ApplicationTab" data-toggle="tab" href="#application">Application Details</a>
                        </li>
                        <li><a id="BasicTab" data-toggle="tab" href="#basic">Basic Details</a></li>
                        <li><a id="FamilyTab" data-toggle="tab" href="#family">Family Details</a></li>
                        <li><a id="EducationTab" data-toggle="tab" href="#education">Education Details</a></li>
                        <li><a id="ContactTab" data-toggle="tab" href="#contact">Contact Details</a></li>
                        <li><a id="FeesTab" data-toggle="tab" href="#fees">Fee Details</a></li>
                        <li><a id="PaymentTab" data-toggle="tab" href="#payment">Payment Details</a></li>
                        <li><a id="PreviewTab" data-toggle="tab" href="#preview" onclick="generatePreview()">Preview and Create</a></li>
                    </ul>

                    <div class="tab-content tab-validate">
                        <?php
                        $rezofastdetails = json_decode($StudentDetail->rezofastdetails);
                        ?>
                        <div id="application" class="tab-pane fade in active">
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Application Number<i style="color: red;">*</i></label>
                                    <input type="text" name="applicationnumber" id="applicationnumber" class="form-control" required>
                                    <br />
                                    <br />
                                    <!-- <input type="hidden" name="applicationnumber" id="applicationnumber" value="<?php echo $applicationNumber ?>" required> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="admissiontypeid" name="admissiontypeid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Admission Type<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                        ?>
                                            <option value="<?php echo $admissiontype->admissiontypeid; ?>"><?php echo $admissiontype->admissiontypename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="branchid" name="branchid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Branch<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['branchlookup'] as $branch) :
                                        ?>
                                            <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="batchid" name="batchid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Academic Year<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['batchlookup'] as $batch) :
                                            
                                        ?>
                                                <option value="<?php echo $batch->batchid; ?>"><?php echo $batch->batchname; ?></option>
                                        <?php
                                           
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="courseid" name="courseid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Course<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['courselookup'] as $course) :
                                        ?>
                                            <option value="<?php echo $course->courseid; ?>"><?php echo $course->coursename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Section</label>
                                    <select onchange="this.classList.remove('error')" id="sectionid" name="sectionid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Section<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['sectionlookup'] as $section) :
                                        ?>
                                            <option value="<?php echo $section->sectionid; ?>"><?php echo $section->sectionname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Admission Date<i style="color: red;">*</i></label>
                                    <input onchange="this.classList.remove('error')" type="text" placeholder="dd/mm/yy" id="admissiondate" name="admissiondate" class="form-control mb datepicker" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="secondlanguageid" name="secondlanguageid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Second Language<i style="color: red;">*</i></option>
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
                                    <select onchange="this.classList.remove('error')" name="referredby" style="width: 100%;" class="select2 form-control mb">
                                        <option value="">Select Reference Employee</option>
                                        <?php

                                        foreach ($EmployeeDetails as $reference) :
                                        ?>
                                            <option value="<?php echo $reference->userid; ?>"><?php echo $reference->employeeid . " - " . $reference->name; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                             <div class="row">
                                </br>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Student Room Number</label>
                                    <input type="text" placeholder="Room Number" id="room" name="room" class="form-control mb" >

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
                                    <input type="text" placeholder="Name" id="name" name="name" class="form-control mb" required>

                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Date Of Birth<i style="color: red;">*</i></label>
                                    <input onchange="this.classList.remove('error')" type="text" placeholder="dd/mm/yy" id="dateofbirth" name="dateofbirth" class="form-control mb datepicker" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="genderid" name="genderid" style="width: 100%;" class="select2 form-control mb select" required>
                                        <option value="">Select Gender<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['genderlookup'] as $gender) :
                                        ?>
                                            <option value="<?php echo $gender->genderid; ?>"><?php echo $gender->gendername; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="categoryid" name="categoryid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Category<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['categorylookup'] as $category) :
                                        ?>
                                            <option value="<?php echo $category->categoryid; ?>"><?php echo $category->categoryname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="nationalityid" name="nationalityid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Nationality<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['nationalitylookup'] as $nationality) :
                                        ?>
                                            <option value="<?php echo $nationality->nationalityid; ?>"><?php echo $nationality->nationalityname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select onchange="this.classList.remove('error')" id="religionid" name="religionid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Religion<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['religionlookup'] as $religion) :
                                        ?>
                                            <option value="<?php echo $religion->religionid; ?>"><?php echo $religion->religionname; ?></option>
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
                            <br />
                            <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-primary" onclick="$('#ApplicationTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#FamilyTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="family" class="tab-pane fade">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Father Name/ Guardian Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Father Name" id="fathername" name="fathername" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Mother Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Mother Name" id="mothername" name="mothername" class="form-control mb" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Parent Occupation<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Parent Occupation" id="parentoccupation" name="parentoccupation" class="form-control mb" required>
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
                            <h3><label>Last Studied Information</label></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Board<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error')" id="board" name="board" style="width: 100%;" class="select2 form-control mb" required>
                                        <?php
                                        foreach ($lookups['boardlookup'] as $board) :
                                        ?>
                                            <option value="<?php echo $board->boardid; ?>"><?php echo $board->boardname; ?></option>
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
                                    <input type="text" placeholder="School Name" id="school" name="school" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Place<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Place" id="place" name="place" class="form-control mb" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Grade/ Marks</label>
                                    <input type="text" placeholder="Grade/ Marks" id="grade" name="grade" class="form-control mb">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">HallTicket No.</label>
                                    <input type="text" placeholder="HallTicket No." id="hallticketNo" name="hallticketNo" class="form-control mb">
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
                            <h3><label>Address</label>
                            </h3>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Door No./ Street Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Door No./ Street Name" id="door_street" name="door_street" class="form-control mb" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">State<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');getdistricts_perm(this.value);" id="state" name="state" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select State</option>
                                        <?php
                                        foreach ($lookups['stateslookup'] as $state) :
                                        ?>
                                            <option value="<?php echo $state->state_id; ?>"><?php echo $state->state_name; ?></option>
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
                                                <option value="<?php echo $district->district_id; ?>"><?php echo $district->district_name; ?></option>
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
                                    <input type="text" placeholder="City/ Town" id="city_town" name="city_town" class="form-control mb" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Village/ Mandal<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Village/ Mandal" id="village_mandal" name="village_mandal" class="form-control mb" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Pin<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Pin" id="pin" name="pin" class="form-control mb" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Landmark<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Landmark" id="landmark" name="landmark" class="form-control mb" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Mobile 1<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile 1" id="mobile1" name="mobile1" class="form-control mb" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Mobile 2<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile 2" id="mobile2" name="mobile2" class="form-control mb" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Email Address<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Email Address" id="email" name="email" class="form-control mb" required>
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

                            <div style="display: none;">
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        Merit Scholarship
                                    </div>
                                    <div class="col-md-4">
                                        <b>(<span id="meritscholarship" style="color: red;">0</span>)</b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        Interview Scholarship
                                    </div>
                                    <div class="col-md-4">
                                        <b>(<span id="meritinterviewscholarship" style="color: red;">0</span>)</b>
                                    </div>
                                </div>
                            </div>

                            <br />

                            <?php $helperModel = new HelperModel(); ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Final Tuition Fees</label>
                                    <input type="number" min="0" value="0" onkeyup="changeNormal()" onchange="changeNormal()" name="tuition_discount" id="text_tuition_fees_total" class='form-control mb' />
                                    <input type="hidden" id="MaxDiscountPermitted" name="MaxDiscountPermitted" value="<?php
                                                                                                                        $maxDiscountAllowed = 0;
                                                                                                                        if ($FeesLimit[0]->discount != NULL && $FeesLimit[0]->availablelimit != NULL) {
                                                                                                                            if ($FeesLimit[0]->availablelimit > $FeesLimit[0]->discount) {
                                                                                                                                $maxDiscountAllowed = $FeesLimit[0]->discount;
                                                                                                                            } else {
                                                                                                                                $maxDiscountAllowed = $FeesLimit[0]->availablelimit;
                                                                                                                            }
                                                                                                                        } else {
                                                                                                                            $maxDiscountAllowed = 0;
                                                                                                                        }
                                                                                                                        echo $maxDiscountAllowed;
                                                                                                                        ?>" />
                                    Available Discount Limit: <b><?php echo $FeesLimit[0]->availablelimit != NULL ? $FeesLimit[0]->availablelimit : 0 ?></b><br />
                                    Maximum Discount: <b><?php echo $maxDiscountAllowed ?></b>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Final Hostel Fees</label>
                                    <input type="number" min="0" value="0" onkeyup="changeNormal()" readonly onchange="changeNormal()" name="hostel_discount" id="text_hostel_fees_total" class='form-control mb' />
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Comments</label>
                                    <input type='text' name='comments' placeholder="comments" class='form-control mb'>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Booking Fees</label>
                                    <select onchange="this.classList.remove('error')" name="paymenttypeid" style="width: 100%;" class="select2 form-control mb" required>
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
                                    <label class="text-uppercase text-sm">Payment Amount</label>
                                    <input type="number" placeholder="Payment Amount" name="paymentamount" class="form-control mb" required>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Payment Date</label>
                                    <input type="text" placeholder="dd/mm/yy" id="paymentdate" name="paymentdate" class="form-control mb paymentdate" required>
                                </div> -->
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Payment Details</label>
                                    <input type="text" placeholder="UTR No / Check No / Recipt No" name="otherdetails" class="form-control mb" required>
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
                                        <th style="float: left !important;">Application Number: <b><span id="preview_applicationnumber"></span></b></th>
                                    </tr>

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Application Details</i></th>
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
                                        <td>Date Of Birth: <b><span id="preview_dateofbirth"></span></b></td>
                                        <td>Gender: <b><span id="preview_gender"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Category: <b><span id="preview_category"></span></b></td>
                                        <td>Nationality: <b><span id="preview_nationality"></span></b></td>
                                        <td>Religion: <b><span id="preview_religion"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Aadhaar Number: <b><span id="preview_aadhaar"></span></b></td>
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
                                        <td>Board Name: <b><span id="preview_board"></span></b></td>
                                        <td>School Name: <b><span id="preview_schoolname"></span></b></td>
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
                                        <td>Door No./ Street Name: <b><span id="preview_doorno"></span></b></td>
                                        <td>State: <b><span id="preview_state"></span></b></td>
                                        <td>District: <b><span id="preview_district"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>City/ Town: <b><span id="preview_city"></span></b></td>
                                        <td>Village/ Mandal: <b><span id="preview_village"></span></b></td>
                                        <td>Pin: <b><span id="preview_pin"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Landmark: <b><span id="preview_landmark"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Mobile1: <b><span id="preview_mobile1"></span></b></td>
                                        <td>Mobile2: <b><span id="preview_mobile2"></span></b></td>
                                        <td>Email Address: <b><span id="preview_email"></span></b></td>
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
                                <div class="col-md-9">
                                    <button type="submit" name="createstudent" class="btn btn-primary">Create Student</button>
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#PaymentTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="print_preview()">Print Application</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="coachingfee" name='coachingfee' required />
                    <input type="hidden" id="scholarship" name='scholarship' required />
                    <input type="hidden" id="discountgiven" name='discountgiven' required />
                    <input type="hidden" id="hdnrezofastdetails" name='rezofastdetails' value="<?php echo urlencode($StudentDetail->rezofastdetails) ?>" />
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
            var fakeURL = "http://www.example.com/t.html?" + $('#studentform').serialize();
            var createURL = new URL(fakeURL);

            $('#preview_applicationnumber').html(createURL.searchParams.get('applicationnumber'));
            admissiontypelookup_json.forEach((a) => {
                if (a.admissiontypeid == createURL.searchParams.get('admissiontypeid')) {
                    $('#preview_admissiontype').html(a.admissiontypename)
                }
            });
            branchlookup_json.forEach((a) => {
                if (a.branchid == createURL.searchParams.get('branchid')) {
                    $('#preview_branch').html(a.branchname)
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
            $('#preview_dateofbirth').html(createURL.searchParams.get('dateofbirth'));
            genderlookup_json.forEach((a) => {
                if (a.genderid == createURL.searchParams.get('genderid')) {
                    $('#preview_gender').html(a.gendername)
                }
            });
            categorylookup_json.forEach((a) => {
                if (a.categoryid == createURL.searchParams.get('categoryid')) {
                    $('#preview_category').html(a.categoryname)
                }
            });
            nationalitylookup_json.forEach((a) => {
                if (a.nationalityid == createURL.searchParams.get('nationalityid')) {
                    $('#preview_nationality').html(a.nationalityname)
                }
            });
            religionlookup_json.forEach((a) => {
                if (a.religionid == createURL.searchParams.get('religionid')) {
                    $('#preview_religion').html(a.religionname)
                }
            });
            $('#preview_aadhaar').html(createURL.searchParams.get('studentaadhaar'));

            $('#preview_fathername').html(createURL.searchParams.get('fathername'));
            $('#preview_mothername').html(createURL.searchParams.get('mothername'));
            $('#preview_parentoccupation').html(createURL.searchParams.get('parentoccupation'));

            boardlookup_json.forEach((a) => {
                if (a.boardid == createURL.searchParams.get('board')) {
                    $('#preview_board').html(a.boardname)
                }
            });
            $('#preview_schoolname').html(createURL.searchParams.get('school'));
            $('#preview_area').html(createURL.searchParams.get('place'));
            $('#preview_grade').html(createURL.searchParams.get('grade'));
            $('#preview_hallticketnumber').html(createURL.searchParams.get('hallticketNo'));

            $('#preview_doorno').html(createURL.searchParams.get('door_street'));
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
            $('#preview_city').html(createURL.searchParams.get('city_town'));
            $('#preview_village').html(createURL.searchParams.get('village_mandal'));
            $('#preview_pin').html(createURL.searchParams.get('pin'));
            $('#preview_landmark').html(createURL.searchParams.get('landmark'));
            $('#preview_mobile1').html(createURL.searchParams.get('mobile1'));
            $('#preview_mobile2').html(createURL.searchParams.get('mobile2'));
            $('#preview_email').html(createURL.searchParams.get('email'));

            $('#preview_totalfee').html(parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee));
            $('#preview_comments').html(createURL.searchParams.get('comments'));

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

            $('#studentform').validate({
                ignore: [],
                rules: {
                    applicationnumber: {
                        remote: "<?php echo base_url('users/checkapplicationnumber') ?>"
                    }
                },
                messages: {
                    applicationnumber: {
                        remote: "Invalid Application Number"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "applicationnumber" && error[0].innerHTML == "Invalid Application Number") {
                        error.insertAfter("#applicationnumber");
                    }
                },
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
            var admissiontype_id = $('#admissiontypeid').val();
            var batch_id = $('#batchid').val();

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
            $('#text_hostel_fees_total').val(0);
            $('#text_hostel_fees_total').attr("min", 0);
            $('#text_hostel_fees_total').attr("max", 0);
            $('#totalfeecontent').html("");

            if (course_id != "" && admissiontype_id != "" && batch_id != "") {
                feestructurelookup_json.map((a) => {
                    if (a.courseid == course_id && a.admissiontypeid == admissiontype_id && a.batchid == batch_id) {
                        if (a.feetype == "Tuition Fee") {
                            actualCoachingFee = a.feesvalue;
                        }
                        if (a.feetype == "Miscellaneous Charges") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualMiscellaneousFee = a.feesvalue;
                        }
                        if (a.feetype == "Intermediate Fee") {
                            fees += "<div class='row'><div class='col-md-4'>" + a.feetype + "</div><div class='col-md-4'>" + a.feesvalue + "</div><div class='col-md-4'>&nbsp;</div></div>";
                            actualIntermediateFee = a.feesvalue;
                        }
                        if (a.feetype == "Hostel Fee") {
                            actualHostelFee = a.feesvalue;
                        }
                    };
                });
                change();
            }

            $('#feecontent').html(fees);
        }

        function change() {
            var ms = parseFloat($('#meritscholarship').html()) + parseFloat($('#meritinterviewscholarship').html());
            $('#scholarship').val(ms);
            $('#coachingfee').val(actualCoachingFee - ms);
            $('#text_tuition_fees_total').attr("min", $('#coachingfee').val() - $('#MaxDiscountPermitted').val());
            $('#text_tuition_fees_total').attr("max", $('#coachingfee').val());
            $('#text_tuition_fees_total').attr("title", "Fees Should be between " + ($('#coachingfee').val() - $('#MaxDiscountPermitted').val()) + " and " + $('#coachingfee').val());
            $('#text_tuition_fees_total').val($('#coachingfee').val());
            $('#text_hostel_fees_total').attr("min", actualHostelFee);
            $('#text_hostel_fees_total').attr("max", actualHostelFee);
            $('#text_hostel_fees_total').val(actualHostelFee);
            changeNormal();
        }

        function changeNormal() {
            $('#discountgiven').val($('#coachingfee').val() - $('#text_tuition_fees_total').val());
            $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee)) + "</div><div class='col-md-4'>&nbsp;</div></div>");
        }
    </script>
</div>