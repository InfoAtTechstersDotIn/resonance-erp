<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Invoices</h2>
                <form>
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branchid" style="width: 100%;" class="form-control">
                                <option value="">Select Branch</option>
                                <?php
                                foreach ($lookups['branchlookup'] as $branch) :
                                ?>
                                    <option value="<?php echo $branch->branchid; ?>" <?php echo isset($_GET['branchid']) && $_GET['branchid'] == $branch->branchid ? "selected" : "" ?>><?php echo $branch->branchname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="courseid" style="width: 100%;" class="form-control">
                                <option value="">Select Course</option>
                                <?php
                                foreach ($lookups['courselookup'] as $course) :
                                ?>
                                    <option value="<?php echo $course->courseid; ?>" <?php echo isset($_GET['courseid']) && $_GET['courseid'] == $course->courseid ? "selected" : "" ?>><?php echo $course->coursename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="admissiontypeid" style="width: 100%;" class="form-control">
                                <option value="">Select Admission Type</option>
                                <?php
                                foreach ($lookups['admissiontypelookup'] as $admissiontype) :
                                ?>
                                    <option value="<?php echo $admissiontype->admissiontypeid; ?>" <?php echo isset($_GET['admissiontypeid']) && $_GET['admissiontypeid'] == $admissiontype->admissiontypeid ? "selected" : "" ?>><?php echo $admissiontype->admissiontypename; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="sectionid" style="width: 100%;" class="form-control mb">
                                <option value="">Select Section</option>
                                <?php
                                foreach ($lookups['sectionlookup'] as $section) :
                                ?>
                                    <option value="<?php echo $section->sectionid; ?>"><?php echo $section->sectionname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblinvoices" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>InvoiceId</th>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Course - Admission Type - Section</th>
                                    <th>Total Invoice Value</th>
                                    <!-- <th>Total Paid</th> -->
                                    <!-- <th>Remaining Amount</th> -->
                                    <th>Download</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                foreach ($InvoiceDetails as $result) :
                                    if (isset($_GET['branchid'])) {
                                        if ($_GET['branchid'] == "" || $result->branchid == $_GET['branchid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['courseid'])) {
                                        if ($_GET['courseid'] == "" || $result->courseid == $_GET['courseid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['admissiontypeid'])) {
                                        if ($_GET['admissiontypeid'] == "" || $result->admissiontypeid == $_GET['admissiontypeid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['sectionid'])) {
                                        if ($_GET['sectionid'] == "" || $result->sectionid == $_GET['sectionid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td><a target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><?php echo $result->invoiceid ?></a></td>
                                        <td><a target="_blank" href="<?php echo base_url('users/studentdetails') ?>?id=<?php echo $result->userid; ?>"><b><?php echo $result->name ?></b></a>
                                        </td>
                                        <td><?php echo $result->branchname ?></td>
                                        <td><?php echo $result->coursename . ", " . $result->admissiontypename . "<br />Section: " . $result->sectionname ?></td>
                                        <td><?php echo $result->TotalValue ?></td>
                                        <!-- <td><?php echo $result->TotalPaid == NULL ? "0.00" : $result->TotalPaid ?></td> -->
                                        <!-- <td><?php echo $result->RemainingAmount == NULL ? $result->TotalValue : $result->RemainingAmount ?></td> -->
                                        <td>
                                            <a title="View" target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><i class="fa fa-eye"></i></a>&nbsp;
                                            <a title="Download" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=download"><i class="fa fa-download"></i></a>&nbsp;
                                            <a title="Send Email" onclick="sendinvoiceemail('<?php echo $result->invoiceid ?>', '<?php echo $result->userid ?>')"><i class="fa fa-paper-plane"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function sendinvoiceemail(invoiceid, userid) {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('payments/sendInvoiceReceiptEmail') ?>",
            data: {
                invoiceid: invoiceid,
                userid: userid
            },
            success: () => {
                alert('Email Sent Successfully');
            }
        });
    }
</script>