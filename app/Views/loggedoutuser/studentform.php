<?php

if ($StudentDetails->verifiedbyuser == 0) {

?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <form class="well form-horizontal" action="<?php echo base_url('users/verifyStudentDetails') ?>" enctype='multipart/form-data' method="post" id="contact_form">
        <fieldset>
            <legend>
                <center>
                    <h2><b><img src="<?php echo base_url('images/logo.png') ?>" height="50px"></img> Student Details</b></h2>
                    All the details provided should be as per SSC, CBSE, ICSE, Others.
                </center>
            </legend>
            <div class="container">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Application Number</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" class="form-control" value="<?php echo $StudentDetails->applicationnumber ?>" disabled required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Admission Type</label>
                            <select class="form-control mb" disabled required>
                                <option value="">Select Admission Type</option>
                                <?php
                                foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                ?>
                                    <option <?php echo $StudentDetails->admissiontypeid == $admissiontype->admissiontypeid ? "selected" : "" ?> value="<?php echo $admissiontype->admissiontypeid; ?>"><?php echo $admissiontype->admissiontypename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Branch</label>
                            <select class="form-control mb" disabled required>
                                <option value="">Select Branch</option>
                                <?php
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <option <?php echo $StudentDetails->branchid == $branch->branchid ? "selected" : "" ?> value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Course</label>
                            <select class="form-control mb" disabled required>
                                <option value="">Select Course</option>
                                <?php
                                foreach ($lookups['courselookup'] as $course) :
                                ?>
                                    <option <?php echo $StudentDetails->courseid == $course->courseid ? "selected" : "" ?> value="<?php echo $course->courseid; ?>"><?php echo $course->coursename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Second Language</label>
                            <select class="form-control mb" disabled required>
                                <option value="">Select Second Language</option>
                                <?php
                                foreach ($lookups['secondlanguagelookup'] as $secondlanguage) :
                                ?>
                                    <option <?php echo $StudentDetails->secondlanguageid == $secondlanguage->secondlanguageid ? "selected" : "" ?> value="<?php echo $secondlanguage->secondlanguageid; ?>"><?php echo $secondlanguage->secondlanguagename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Student Name</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="name" class="form-control mb" value="<?php echo $StudentDetails->name ?>" required>
                                    <input type="hidden" name="uniqueid" class="form-control mb" value="<?php echo $StudentDetails->uniqueid ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Date Of Birth</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" id="dateofbirth" name="dateofbirth" class="form-control mb" value="<?php echo $StudentDetails->dateofbirth ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Gender</label>
                            <select name="genderid" class="form-control mb" required>
                                <?php
                                foreach ($lookups['genderlookup'] as $gender) :
                                ?>
                                    <option <?php echo $StudentDetails->genderid == $gender->genderid ? "selected" : ""; ?> value="<?php echo $gender->genderid; ?>"><?php echo $gender->gendername; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Nationality</label>
                            <select name="nationalityid" class="form-control mb" required>
                                <?php
                                foreach ($lookups['nationalitylookup'] as $nationality) :
                                ?>
                                    <option <?php echo $StudentDetails->nationalityid == $nationality->nationalityid ? "selected" : "" ?> value="<?php echo $nationality->nationalityid; ?>"><?php echo $nationality->nationalityname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Religion</label>
                            <select name="religionid" class="form-control mb" required>
                                <?php
                                foreach ($lookups['religionlookup'] as $religion) :
                                ?>
                                    <option <?php echo $StudentDetails->religionid == $religion->religionid ? "selected" : "" ?> value="<?php echo $religion->religionid; ?>"><?php echo $religion->religionname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <select name="categoryid" class="form-control mb" required>
                                <?php
                                foreach ($lookups['categorylookup'] as $category) :
                                ?>
                                    <option <?php echo $StudentDetails->categoryid == $category->categoryid ? "selected" : "" ?> value="<?php echo $category->categoryid; ?>"><?php echo $category->categoryname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Aadhaar Number</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="studentaadhaar" class="form-control mb" value="<?php echo $StudentDetails->studentaadhaar ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Father Name/ Guardian Name</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="fathername" class="form-control mb" value="<?php echo $StudentDetails->fathername ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Mother Name</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="mothername" class="form-control mb" value="<?php echo $StudentDetails->mothername ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Parent Occupation</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="parentoccupation" class="form-control mb" value="<?php echo $StudentDetails->parentoccupation ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Mobile 1</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="number" name="mobile1" class="form-control mb" value="<?php echo $StudentDetails->mobile1 ?>" disabled required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Mobile 2</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="number" name="mobile2" class="form-control mb" value="<?php echo $StudentDetails->mobile2 ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Email Address</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="email" name="email" class="form-control mb" value="<?php echo $StudentDetails->email ?>" disabled required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <?php
                $Address = json_decode($StudentDetails->address);
                $permanentAddress = $Address->permanent;
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">
                                <h4>Address</h4>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Door No./ Street Name</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="door_street" class="form-control mb" value="<?php echo $permanentAddress->door_street ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <select onchange="getdistricts_perm(this.value);" id="state" name="state" style="width: 100%;" class="select2 form-control mb" required>
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
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">District</label>
                            <select id="district" name="district" style="width: 100%;" class="select2 form-control mb" required>
                                <option value="">Select District</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">City/ Town</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="city_town" class="form-control mb" value="<?php echo $permanentAddress->city_town ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Village/ Mandal</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="village_mandal" class="form-control mb" value="<?php echo $permanentAddress->village_mandal ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Pin</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="pin" class="form-control mb" value="<?php echo $permanentAddress->pin ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Landmark</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input type="text" name="landmark" class="form-control mb" value="<?php echo $permanentAddress->landmark ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br />
                <?php
                $PreviousClassesInfo = json_decode($StudentDetails->previous_class_information);
                if ($PreviousClassesInfo != "") {
                    foreach ($PreviousClassesInfo as $classInfo) {
                        $classInfo = $classInfo;
                    }
                }
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                <h4>Last Studied Information</h4>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">School</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input name="school" placeholder="School Name" class="form-control" type="text" value="<?php echo $classInfo->school ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Board</label>
                            <select name="board" class="form-control mb" required>
                                <?php
                                foreach ($lookups['boardlookup'] as $board) :
                                ?>
                                    <option <?php echo $classInfo->board == $board->boardid ? "selected" : "" ?> value="<?php echo $board->boardid; ?>"><?php echo $board->boardname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Area/ Place</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input name="place" class="form-control" type="text" value="<?php echo $classInfo->place ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Grade/ Marks</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input name="grade" class="form-control" type="text" value="<?php echo $classInfo->grade ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">HallTicket No.</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input name="hallticketNo" class="form-control" type="text" value="<?php echo $classInfo->hallticketNo ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Reservation Amount(Minimum Rs. 10,500)</label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input name="reservationamount" class="form-control" type="number" min="10500" value="10500" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"></label>
                            <div>
                                <button type="submit" class="btn btn-warning" name="saveStudentDetails">Proceed to pay Reservation Amount&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-send"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    <script>
        function enableSubmit() {
            document.getElementsByName('saveStudentDetails')[0].disabled = false
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

        $(document).ready(function() {
            $('#dateofbirth').datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "dd/mm/yy",
                minDate: '-20Y',
                maxDate: '-12Y',
            });
            validateForm();
        });

        function validateForm() {
            $('#contact_form').bootstrapValidator({
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    }
                })
                .on('success.form.bv', function(e) {
                    $('#success_message').slideDown({
                        opacity: "show"
                    }, "slow") // Do something ...
                    $('#contact_form').data('bootstrapValidator').resetForm();

                    // Prevent form submission
                    e.preventDefault();

                    // Get the form instance
                    var $form = $(e.target);

                    // Get the BootstrapValidator instance
                    var bv = $form.data('bootstrapValidator');

                    // Use Ajax to submit form data
                    $.post($form.attr('action'), $form.serialize(), function(result) {
                        console.log(result);
                    }, 'json');
                });
        }
    </script>
    <style>
        #success_message {
            display: none;
        }
    </style>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

<?php
} else {
    echo "User not found Or Already filled in details";
}
?>