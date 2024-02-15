<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Application Details Report
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Batch</label>
                    <select name="batchid" id="batchid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['batchlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->batchid; ?>" <?php echo (isset($_GET['batchid']) && $_GET['batchid'] != "" && $_GET['batchid'] == $result->batchid) ? "selected" : "" ?>><?php echo $result->batchname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Branch</label>
                    <select name="branchid" id="branchid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['branchlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->branchid; ?>" <?php echo (isset($_GET['branchid']) && $_GET['branchid'] != "" && $_GET['branchid'] == $result->branchid) ? "selected" : "" ?>><?php echo $result->branchname; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Course</label>
                    <select name="courseid" id="courseid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['courselookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->courseid; ?>" <?php echo (isset($_GET['courseid']) && $_GET['courseid'] != "" && $_GET['courseid'] == $result->courseid) ? "selected" : "" ?>><?php echo $result->coursename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Admission Type</label>
                    <select name="admissiontypeid" id="admissiontypeid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['admissiontypelookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->admissiontypeid; ?>" <?php echo (isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] != "" && $_GET['admissiontypeid'] == $result->admissiontypeid) ? "selected" : "" ?>><?php echo $result->admissiontypename; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Referred By</label>
                    <select name="referredbyid" id="referredbyid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($EmployeeDetails as $result) :
                        ?>
                            <option value="<?php echo $result->userid; ?>" <?php echo (isset($_GET['referredbyid']) && $_GET['referredbyid'] != "" && $_GET['referredbyid'] == $result->userid) ? "selected" : "" ?>><?php echo $result->name; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Gender</label>
                    <select name="genderid" id="genderid" onchange="filter(0)" style="width: 100%;" class="form-control mb">
                        <option value="">Select</option>
                        <?php
                        foreach ($lookups['genderlookup'] as $result) :
                        ?>
                            <option value="<?php echo $result->genderid; ?>" <?php echo (isset($_GET['genderid']) && $_GET['genderid'] != "" && $_GET['genderid'] == $result->genderid) ? "selected" : "" ?>><?php echo $result->gendername; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Application Date From</label>
                    <input type="text" onchange="filter(0)" placeholder="Application Date From" name="AdmissionDateFrom" class="datepicker form-control mb" value="<?php echo (isset($_GET['AdmissionDateFrom']) && $_GET['AdmissionDateFrom'] != "") ? $_GET['AdmissionDateFrom'] : "" ?>">
                </div>
                <div class="col-md-3">
                    <label class="text-uppercase text-sm">Application Date To</label>
                    <input type="text" onchange="filter(0)" placeholder="Application Date To" name="AdmissionDateTo" class="datepicker form-control mb" value="<?php echo (isset($_GET['AdmissionDateTo']) && $_GET['AdmissionDateTo'] != "") ? $_GET['AdmissionDateTo'] : "" ?>">
                </div>
            </div>
        </form>
        <a class="btn btn-primary" onclick="filter(1)">Download</a>
        <br />
        <br />
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                        </style>
                        <table class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Admission Details</th>
                                    <th>Student Details</th>
                                    <th>Fee Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($studentDetails != null) :
                                    foreach ($studentDetails as $result) :
                                ?>
                                        <tr>
                                            <td>
                                                <b>Application Date:</b> <?php echo date_format(date_create($result->admissiondate), 'd/m/Y') ?><br />
                                                <b>Application Number:</b> <?php echo $result->application_ukey ?><br />
                                                <b>Campus:</b> <?php echo $result->branchname ?><br />
                                                <b>Course Name:</b> <?php echo $result->coursename ?><br />
                                                <b>Admission Type:</b> <?php echo $result->admissiontypename ?><br />
                                                <b>Application Status:</b> <?php echo $result->reservationstatusname ?><br />
                                            </td>
                                            <td>
                                                <b>Student Name:</b> <?php echo $result->name ?><br />
                                                <b>Father Name:</b> <?php echo $result->fathername ?><br />
                                                <b>Gender:</b> <?php echo $result->gendername ?><br />
                                                <b>Date Of Birth:</b> <?php echo date_format(date_create($result->dateofbirth), 'd/m/Y') ?><br />
                                                <b>Mobile:</b> <?php echo $result->mobile1 . ", " . $result->mobile2 ?><br />
                                                <b>Email:</b> <?php echo $result->email ?><br />
                                            </td>
                                            <td>
                                                <b>Discount Requested:</b> <?php echo $result->discountrequested ?><br />
                                                <b>Paid Fee:</b> <?php echo $result->TotalFeesPaid ?><br />
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filter(download = 0) {
        var URL = "<?php echo base_url('reports/report_applicationdetails') ?>" + "?" + $('#filterForm').serialize();

        if (download == 1) {
            URL = URL + "&download=1";
        }

        window.location.href = URL;
    }
</script>