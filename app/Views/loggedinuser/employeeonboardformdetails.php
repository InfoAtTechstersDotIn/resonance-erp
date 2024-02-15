<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Employee Details</h2>
                <br />
                <form method="post" id="reservationform" enctype="multipart/form-data" action="<?php

                                                                                                use App\Models\HelperModel;

                                                                                                echo base_url('users/updateonboardemployeedetails') ?>">


                    <ul class="nav nav-tabs f-16">

                        <li class="active"><a id="BasicTab" data-toggle="tab" href="#basic">Personal Details</a></li>
                        <li><a id="AddressTab" data-toggle="tab" href="#address">Address</a></li>
                        <li><a id="FamilyTab" data-toggle="tab" href="#family">Family Details</a></li>
                        <li><a id="AdditionalTab" data-toggle="tab" href="#additional">Additional Details</a></li>
                        <li><a id="PreviewTab" data-toggle="tab" href="#preview" onclick="generatePreview()">Preview & Create</a></li>
                    </ul>

                    <div class="tab-content tab-validate">

                        <div id="basic" class="tab-pane fade in active">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Employee Id</label>
                                    <input type="text" value="MDG0<?php echo $nextemployeeid; ?>" placeholder="Employee Id" disabled class="form-control mb" required>
                                    <input type="hidden" name="employee_id" value="MDG0<?php echo $nextemployeeid; ?>" id="reservationid" class="form-control formfield" required>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Name<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Name" id="name" name="name" value="<?php echo $details[0]->name; ?>" class="form-control mb" required>
                                    <input type="hidden" placeholder="Name" id="name" value="<?php echo $details[0]->userid; ?>" name="userid" class="form-control mb">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Date Of Birth<i style="color: red;">*</i></label>
                                    <input type="text" onchange="this.classList.remove('error')" placeholder="dd/mm/yy" value="<?php echo $details[0]->dob; ?>" id="dateofbirth" name="dateofbirth" class="form-control mb datepicker" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Mobile<i style="color: red;">*</i></label>
                                    <input type="number" placeholder="Mobile" disabled value="<?php echo $details[0]->mobile; ?>" class="form-control mb" required>

                                    <input type="hidden" placeholder="Mobile" value="<?php echo $details[0]->mobile; ?>" id="mobile" name="mobile" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Email Address</label>
                                    <input type="text" placeholder="Email Address" id="email" name="email" value="<?php echo $details[0]->email; ?>" class="form-control mb">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Aadhaar Number<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Aadhaar Number" id="aadhaar" name="aadhaar" value="<?php echo $details[0]->aadhar; ?>" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Pan Card Number<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Aadhaar Number" id="pancard" name="pancard" class="form-control mb" value="<?php echo $details[0]->pancard; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Select Gender<i style="color: red;">*</i></label>
                                    <select onchange="this.classList.remove('error')" id="genderid" name="genderid" style="width: 100%;" class="select2 form-control mb select" required>
                                        <option value="">Select Gender<i style="color: red;">*</i></option>
                                        <?php
                                        foreach ($lookups['genderlookup'] as $gender) :
                                        ?>
                                            <option <?php if ($details[0]->gender == $gender->genderid) {
                                                        echo "selected";
                                                    } ?> value="<?php echo $gender->genderid; ?>"><?php echo $gender->gendername; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Blood Group<i style="color: red;">*</i></label>
                                    <input type="text" placeholder="Blood Group" id="bloodgroup" name="bloodgroup" value="<?php echo $details[0]->bloodgroup; ?>" class="form-control mb" required>
                                </div>
                                <!-- <div class="col-md-6">
                                      <label class="text-uppercase f-16">Upload Profile Picture</label>
                                    <input type="file" name="profile_image" required class="form-control mb" >
                                    <br><br>
                                </div> -->


                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">

                                    <a class="btn btn-primary" onclick="$('#AddressTab').click()">Next</a>
                                </div>
                            </div>

                        </div>

                        <div id="address" class="tab-pane fade">
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">HO-NO</label>
                                    <input type="text" name="h_no" id="h_no" value="<?php echo $details[0]->h_no; ?>" placeholder="H-no" class='form-control mb text_tuition_fees_total' required />

                                </div>

                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">STREET/VILLAGE</label>
                                    <input type='text' name='village' id='village' placeholder="STREET/VILLAGE" value="<?php echo $details[0]->village; ?>" class='form-control mb'>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">MANDAL/AREA</label>
                                    <input type='text' name='mandal' id='mandal' placeholder="MANDAL" value="<?php echo $details[0]->mandal; ?>" class='form-control mb'>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">DISTRICT</label>
                                    <input type='text' name='district' id='district' placeholder="DISTRICT" value="<?php echo $details[0]->district; ?>" class='form-control mb'>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">STATE</label>
                                    <input type='text' name='state' id='state' placeholder="STATE" value="<?php echo $details[0]->state; ?>" class='form-control mb'>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">PIN CODE</label>
                                    <input type='text' name='pincode' id='pincode' placeholder="PIN" value="<?php echo $details[0]->pin; ?>" class='form-control mb'>
                                </div>
                            </div>
                            <br />

                            <br />

                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#BasicTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#FamilyTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="family" class="tab-pane fade">
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Father Name</label>
                                    <input type="text" name="father" id="father" value="<?php echo $details[0]->father; ?>" placeholder="Father Name" class='form-control mb' required />

                                </div>

                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Mother Name</label>
                                    <input type='text' name='mother' id='mother' placeholder="Mother Name" value="<?php echo $details[0]->mother; ?>" class='form-control mb'>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-uppercase f-16">Spouse Name</label>
                                    <input type='text' name='spouse' id='spouse' placeholder="Spouse Name" value="<?php echo $details[0]->spouse; ?>" class='form-control mb'>
                                </div>

                            </div>
                            <br />

                            <br />

                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#AddressTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#AdditionalTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="additional" class="tab-pane fade">
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Branch</label>
                                    <select name="branchid[]" style="width: 100%;" class="select2 form-control mb" multiple>
                                        <?php
                                        foreach ($lookups['branchlookup'] as $branch) :
                                        ?>
                                            <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Role</label>
                                    <select name="roleid" style="width: 100%;" class="select2 form-control mb" required>
                                        <option value="">Select Role</option>
                                        <?php
                                        foreach ($lookups['roleslookup'] as $role) :
                                        ?>
                                            <option value="<?php echo $role->roleid; ?>"><?php echo $role->rolename; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Designation</label>
                                    <input type="text" placeholder="Designation" name="designation" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Date of Joining</label>
                                    <input type="date" placeholder="Date of Joining" name="joiningdate" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Login Time</label>
                                    <input id="logintime" type="time" placeholder="Login Time" name="logintime" class="form-control mb" required>

                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Logout Time</label>
                                    <input id="logouttime" type="time" placeholder="Logout Time" class="form-control mb" name="logouttime">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Total Leaves</label>
                                    <input id="totalleaves" type="number" placeholder="Leaves" name="totalleaves" class="form-control mb" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase text-sm">Reporting Employee(Leaves)</label>
                                    <select onchange="this.classList.remove('error')" name="reportperson" style="width: 100%;" class="select2 form-control mb">
                                        <option value="">Select Reporting Employee(Leaves)</option>
                                        <?php
                                        foreach ($EmployeeDetails as $reference) :
                                        ?>
                                            <option value="<?php echo $reference->userid ?>"><?php echo $reference->employeeid . " - " . $reference->name; ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="colour" class="col-form-label">Select Week Off Days:</label>
                                    <br>
                                    <input type="checkbox" class="checkhour" name="sunday" value="1">sunday
                                    <input type="checkbox" class="checkhour" name="monday" value="1">monday
                                    <input type="checkbox" class="checkhour" name="tuesday" value="1">tuesday
                                    <input type="checkbox" class="checkhour" name="wednesday" value="1">wednesday
                                    <input type="checkbox" class="checkhour" name="thursday" value="1">thursday
                                    <input type="checkbox" class="checkhour" name="friday" value="1">friday
                                    <input type="checkbox" class="checkhour" name="saturday" value="1">saturday
                                </div>

                            </div>
                            <br />

                            <br />

                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-primary" onclick="$('#FamilyTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" onclick="$('#PreviewTab').click()">Next</a>
                                </div>
                            </div>
                        </div>
                        <div id="preview" class="tab-pane fade">
                            <div id="print_preview">
                                <table style="width: 100%;margin: 0;">
                                    <br />

                                    <tr>
                                        <th style="float: left !important;"><br /><i>Personal Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Name: <b><span id="preview_name"></span></b></td>
                                        <td>Mobile: <b><span id="preview_mobile"></span></b></td>
                                        <td>Date Of Birth: <b><span id="preview_dateofbirth"></span></b></td>
                                        <td>Gender: <b><span id="preview_gender"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>Aadhaar Number: <b><span id="preview_aadhaar"></span></b></td>
                                        <td>Pan Card: <b><span id="preview_pancard"></span></b></td>
                                        <td>Email Address: <b><span id="preview_email"></span></b></td>
                                        <td>Blood Group: <b><span id="preview_bloodgroup"></span></b></td>
                                    </tr>
                                    <tr>
                                        <th style="float: left !important;"><br /><i>Address</i></th>
                                    </tr>
                                    <tr>
                                        <td>H-no: <b><span id="preview_h-no"></span></b></td>
                                        <td>STREET/VILLAGE: <b><span id="preview_village"></span></b></td>
                                        <td>MANDAL/AREA: <b><span id="preview_mandal"></span></b></td>
                                        <td>DISTRICT: <b><span id="preview_district"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td>STATE: <b><span id="preview_state"></span></b></td>
                                        <td>PIN CODE: <b><span id="preview_pin"></span></b></td>
                                    </tr>
                                    <tr>
                                        <th style="float: left !important;"><br /><i>Family Details</i></th>
                                    </tr>
                                    <tr>
                                        <td>Father Name: <b><span id="preview_father"></span></b></td>
                                        <td>Mother Name: <b><span id="preview_mother"></span></b></td>
                                        <td>Spouse Name: <b><span id="preview_spouse"></span></b></td>

                                    </tr>

                                </table>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-7 mb">
                                    <button type="submit" name="createstudent" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-md-5">
                                    <a class="btn btn-primary" onclick="$('#AdditionalTab').click()">Previous</a>&nbsp;&nbsp;&nbsp;
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
                                <form method="get" action="<?php echo base_url('agentdashboard/addApplicant') ?>">
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
    </script>
</div>


<style>
    .nav-tabs>li>a {
        background-color: #29abe0;
        border-color: #fff;
        color: #fff;
        border-bottom-color: 1px solid #fff;
        font-size: 14px;
        margin-top: 4px;
    }

    .nav-tabs>li.active>a,
    .nav-tabs>li.active>a:hover,
    .nav-tabs>li.active>a:focus {
        color: #fff;
        background-color: #93c54b;
        border: 1px solid #93c54b;
        /* border-bottom-color: transparent; */
        cursor: default;
    }

    .nav-tabs>li>a:hover {
        background-color: #93c54b;
        border-color: #fff;
        color: #fff;
        border-bottom-color: 1px solid #fff;
    }

    .nav-tabs {
        border-bottom: 1px solid transparent;
    }

    .select2-container .select2-selection--single {
        height: 50px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-top: 13px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 12px;
    }
</style>
<script>
    var genderlookup_json = <?php echo $lookups['genderlookup_json']; ?>;

    function generatePreview() {
        var fakeURL = "http://www.example.com/t.html?" + $('#reservationform').serialize();
        var createURL = new URL(fakeURL);
        $('#preview_name').html(createURL.searchParams.get('name'));
        $('#preview_dateofbirth').html(createURL.searchParams.get('dateofbirth'));
        genderlookup_json.forEach((a) => {
            if (a.genderid == createURL.searchParams.get('genderid')) {
                $('#preview_gender').html(a.gendername)
            }
        });

        $('#preview_aadhaar').html(createURL.searchParams.get('aadhaar'));
        $('#preview_pancard').html(createURL.searchParams.get('pancard'));

        $('#preview_father').html(createURL.searchParams.get('father'));
        $('#preview_mother').html(createURL.searchParams.get('mother'));
        $('#preview_spouse').html(createURL.searchParams.get('spouse'));


        $('#preview_mobile').html(createURL.searchParams.get('mobile'));
        $('#preview_bloodgroup').html(createURL.searchParams.get('bloodgroup'));
        $('#preview_h-no').html(createURL.searchParams.get('h_no'));
        $('#preview_village').html(createURL.searchParams.get('village'));

        $('#preview_mandal').html(createURL.searchParams.get('mandal'));
        $('#preview_district').html(createURL.searchParams.get('district'));
        $('#preview_state').html(createURL.searchParams.get('state'));
        $('#preview_pin').html(createURL.searchParams.get('pincode'));
        $('#preview_email').html(createURL.searchParams.get('email'));



    }
</script>