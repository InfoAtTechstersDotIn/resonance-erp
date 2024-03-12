<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Add Applicant</h2>
                <br />
                <form method="post" id="reservationform" enctype="multipart/form-data"  action="<?php

                                                                    use App\Models\HelperModel;

                                                                    echo base_url('agentdashboard/createapplicant') ?>">
                    
                    
                    <ul class="nav nav-tabs f-16">
                        <li class="active">
                            <a id="ReservationTab" data-toggle="tab" href="#reservation">Application Details</a>
                        </li>
                        <li><a id="BasicTab" data-toggle="tab" href="#basic">Basic Details</a></li>
                        <li><a id="FeesTab" data-toggle="tab" href="#fees">Course Total Fee</a></li>
                        <li><a id="PreviewTab" data-toggle="tab" href="#preview" onclick="generatePreview()">Preview & Create</a></li>
                    </ul>

                    <div class="tab-content tab-validate">
                        <div id="reservation" class="tab-pane fade in active">
                            <br>
                             <div class="row">
                                 <div class="col-md-4">
                                     <?php $rezofastdetails = json_decode($rezofastdetails);
                                     ?>
                                      <label class="text-uppercase f-16">Select Application Type<i style="color: red;">*</i></label>
                                        <select onchange="this.classList.remove('error');changeapplicationtype();"  id="applicationtype" name="applicationtype" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Application Type<i style="color: red;">*</i></option>
                                        <option value="1">Direct Application</option>
                                        <option <?php  if($rezofastdetails != '')
                                       { echo "selected" ; } ?> value="2">ResoFAST Application</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                     <?php 
                                       if($rezofastdetails != '')
                                       {
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
                                            <b>Discount </b><br />
                                            <?php echo $rezofastdetails->discount ?>
                                        </td>
                                           </tr>
                                           </tbody>
                            </table>
                                           <?php
                                       }
                                       ?>
                                   <div id="reso" style="display:none;">
                                       <a class="btn btn-success" data-toggle="modal" data-target="#Resofast">Add Resofast Number</a>
                                      
                                   </div>
                                </div>
                                <br>
                                </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Application Id<i style="color: red;">*</i></label>
                                    <input type="text"value="RESHYD-<?php echo $nextapplicationid;?>" lass="form-control formfield" disabled>
                                    <input type="hidden" name="reservationid" value="RESHYD-<?php echo $nextapplicationid;?>" id="reservationid" class="form-control formfield" required>

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                     <label class="text-uppercase f-16">Course Type<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');changebranch();changeFeesBasedOnCourse();"  id="course" name="course" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Course Type<i style="color: red;">*</i></option>
                                        <option value="1">Inter</option>
                                        <option value="2">School</option>
                                        <option value="3">Foundation</option>
                                    </select>
                                   <br><br>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Admission Type<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');changebranch();changeFeesBasedOnCourse();" id="admissiontypeid" name="admissiontypeid" style="width: 100%;" class="select2 form-control mb" required>
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
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                     <label class="text-uppercase f-16">Course<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');changebranch();changeFeesBasedOnCourse();" id="courseid" name="courseid" style="width: 100%;" class="select2 form-control mb" required>
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
                               
                                 
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Select Academic Year<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="batchid" name="batchid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Academic Year<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['batchlookup'] as $batch) :
                                            if ($batch->batchid == "3") :
                                        ?>
                                                <option value="<?php echo $batch->batchid; ?>"><?php echo $batch->batchname; ?></option>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </select>
                                    <br><br>
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-6">
                                      <label class="text-uppercase f-16">Select Branch<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error');changeFeesBasedOnCourse();" id="branchid" name="branchid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Branch<i style="color: red;">*</i></option>
                                       <!-- <?php
                                        foreach ($lookups['branchlookup'] as $branch) :
                                        ?>
                                            <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>-->
                                    </select>
                                    <br><br>
                                </div>
                                 <div class="col-md-6">
                                      <label class="text-uppercase f-16">Upload Profile Picture</label>
                                    <input type="file" name="file" class="form-control mb" >
                                    <br><br>
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
                                    <label class="text-uppercase f-16">Student Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Name" id="name" name="name" class="form-control mb" required>

                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Date Of Birth<i style="color: red;">*</i></label>
                                    <input type="text" onchange="this.classList.remove('error')" placeholder="dd/mm/yy" id="dateofbirth" name="dateofbirth" class="form-control mb datepicker" required>
                                </div>
                            </div>
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
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">City/ Town<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="City/ Town" id="city_town" name="city_town" class="form-control mb"  required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Village/ Mandal<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Village/ Mandal" id="village_mandal" name="village_mandal" class="form-control mb"  required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Pin<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Pin" id="pin" name="pin" class="form-control mb" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-uppercase text-sm">Landmark<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Landmark" id="landmark" name="landmark" class="form-control mb"  required>
                                </div>
                            </div>

                            <div class="row">
                               <div class="col-md-6">
                                    <label class="text-uppercase f-16">Mobile<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile" id="mobile1" name="mobile1" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Alternate Mobile</label>
                                    <input type="number" placeholder="Mobile" id="mobile2" name="mobile2" class="form-control mb">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Email Address</label>
                                    <input type="text" placeholder="Email Address" id="email" name="email" class="form-control mb">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Aadhaar Number<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Aadhaar Number" id="studentaadhaar" name="studentaadhaar" class="form-control mb" required>
                                </div>
                                 <div class="col-md-6">
                                     <label class="text-uppercase f-16">Select Gender<i style="color: red;">*</i></label>
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
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="text-uppercase f-16">Course Fees</label>
                                    <input type="number" min="0" value="0" onkeyup="changeNormal()" onchange="changeNormal()" name="tuition_discount" id="text_tuition_fees_total" class='form-control mb text_tuition_fees_total' required/>
                               <input type="hidden" min="0" value="0" name="hostel_discount" id="text_hostel_fees_total" class='form-control mb' />
                                <input type="hidden" name="resofastfinalfee" id="resofastfinalfee">
                                </div>
                                
                                <div class="col-md-3">
                                   <label class="text-uppercase f-16">Comments</label>
                                    <input type='text' name='comments' placeholder="comments" class='form-control mb' >
                                </div>
                            </div>
                            <br />
                            <div id="feecontent"></div>
                            <div id="totalfeecontent"></div>
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
                        <div id="preview" class="tab-pane fade">
                            <div id="print_preview">
                                <table style="width: 100%;margin: 0;">
                                    <br />

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Application Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Application Id: <b><span id="preview_reservationid"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Admission Type: <b><span id="preview_admissiontype"></span></b></td>
                                        <td>Branch: <b><span id="preview_branch"></span></b></td>
                                        <td>Batch: <b><span id="preview_batch"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Course: <b><span id="preview_course"></span></b></td>
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
                                        <td>Aadhaar Number: <b><span id="preview_aadhaar"></span></b></td>
                                        <td>Mobile1: <b><span id="preview_mobile1"></span></b></td>
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
                                <div class="col-md-7 mb">
                                    <button type="submit" name="createstudent" class="btn btn-primary">Create Application</button>
                                </div>
                                <div class="col-md-5">
                                    <a class="btn btn-primary" onclick="$('#FeesTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="print_preview()">Print Application</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="modal fade" id="Resofast" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document" style="width: 50vw">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Load Student Details with Resofast</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="get" action="<?php echo base_url('agentdashboard/addApplicant') ?>" >
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="text-uppercase text-sm">Reso Fast Hallticket Number</label>
                                            <input type="text" placeholder="Reso Fast Hallticket Number" name="resofast" class="form-control">
                                            
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
        $(function() {
            $('.formfield').on('keypress', function(e) {
                if (e.which == 32)
                    return false;
            });
        });

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
        var cuttofffeelookup_json = <?php echo $lookups['cuttofffeelookup_json']; ?>;

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

            $('#preview_totalfee').html(createURL.searchParams.get('tuition_discount'));
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

            $('#reservationform').validate({
                ignore: [],
                rules: {
                    reservationid: {
                        remote: "<?php echo base_url('users/checkreservationid') ?>"
                    }
                },
                messages: {
                    reservationid: {
                        remote: "Invalid Reservation Id"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "reservationid" && error[0].innerHTML == "Invalid Reservation Id") {
                        error.insertAfter("#reservationid");
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

            $('#studentform').validate({
                ignore: [],
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
        function changebranch()
        {
            var course = $('#course').val();
            var course_id = $('#courseid').val();
            var admissiontype_id = $('#admissiontypeid').val();
             if(course !='' && admissiontype_id !='' && course_id !='')
            {
                $.getJSON("<?php echo base_url('home/get_branches') ?>" + "?course=" + course+"&admissiontype_id=" + admissiontype_id, function(json) {
                $('#branchid').empty();
                $('#branchid').append($('<option>').text("Select Branch"));
                $.each(json, function(i, obj) {
                    $('#branchid').append($('<option>').text(obj.branchname).attr('value', obj.branchid));
                });
            });
            }
        }
        function changeapplicationtype()
        {
            var applicationtype = $('#applicationtype').val();
            if(applicationtype==2)
            {
                $('#reso').show();
                $('#text_tuition_fees_total').removeAttr("required");
                $('#text_tuition_fees_total').prop('disabled', true);
            }else
            {
                 $('#reso').hide();
                 $("#text_tuition_fees_total").prop('required',true);
                 $('#text_tuition_fees_total').prop('disabled', false);

            }
        }
        function changeFeesBasedOnCourse() {
            
            var course = $('#course').val();
            var course_id = $('#courseid').val();
            var admissiontype_id = $('#admissiontypeid').val();
            var batch_id = $('#batchid').val();
            var branch_id = $('#branchid').val();
           // $('#text_tuition_fees_total').val(0);
           // $('#text_tuition_fees_total').attr("min", 0);
            $('#totalfeecontent').html("");
           
            if (course_id != "" && admissiontype_id != "" && batch_id != "" && branch_id !='') {
                cuttofffeelookup_json.map((a) => {
                    if (a.courseid == course_id && a.admissiontypeid == admissiontype_id && a.batchid == batch_id && a.branchid == branch_id) {
                        $('#text_tuition_fees_total').attr("min", a.fee);
                        $('#text_hostel_fees_total').val(a.hostel_fee);
                    };
                });
                change();
            }
        }

        function change() {
            changeNormal();
        }

        function changeNormal() {
           // $('#discountgiven').val($('#coachingfee').val() - $('#text_tuition_fees_total').val());
           // $('#totalfeecontent').html("<div class='row'><div class='col-md-4'>Total Fees</div><div class='col-md-4'>" + (parseFloat($('#text_tuition_fees_total').val()) + parseFloat($('#text_hostel_fees_total').val()) + parseFloat(actualMiscellaneousFee) + parseFloat(actualIntermediateFee)) + "</div><div class='col-md-4'>&nbsp;</div></div>");
        }
        jQuery("#admissiondate").datepicker({ dateFormat: 'dd/mm/yy', minDate: 0,maxDate:0 });

    </script>
</div>


<style>
    .nav-tabs>li>a{
    background-color: #29abe0;
    border-color: #fff;
    color: #fff;
    border-bottom-color: 1px solid #fff;
    font-size:14px;
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

<?php  if($rezofastdetails != ''){
     
     ?>
     <input type="hidden" value="<?php echo$rezofastdetails->discount;?>" id="resodicount">
     <script>
     var coursefee = $('#resodicount').val();
     var final = 190000- coursefee;
     $('.text_tuition_fees_total').val(final);
      $('#resofastfinalfee').val(final);
        $('.text_tuition_fees_total').prop('disabled', true);
        
     </script>
     <?php
 }
                                     ?>