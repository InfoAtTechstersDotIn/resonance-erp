<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Reservation Payments
                    <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                        <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addpayment">Add Payment</a>
                    <?php endif; ?>
                </h2>
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
                                    <option value="<?php echo $section->sectionid; ?>" <?php echo isset($_GET['sectionid']) && $_GET['sectionid'] == $section->sectionid ? "selected" : "" ?>><?php echo $section->sectionname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <select name="paymentstatusid" style="width: 100%;" class="form-control">
                                <option value="">Select Payment Status</option>
                                <?php
                                foreach ($lookups['paymentstatuslookup'] as $paymentstatus) :
                                ?>
                                    <option value="<?php echo $paymentstatus->paymentstatusid; ?>" <?php echo isset($_GET['paymentstatusid']) && $_GET['paymentstatusid'] == $paymentstatus->paymentstatusid ? "selected" : "" ?>><?php echo $paymentstatus->paymentstatusname; ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblPayments" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>PaymentId</th>
                                    <th>Name</th>
                                    <th>Course - Admission Type - Section</th>
                                    <th>Payment Status</th>
                                    <th>Payment</th>
                                    <th>Payment Date</th>
                                    <th>Payment Type</th>
                                    <th>Payment Details</th>
                                    <th>Amount Received By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($PaymentDetails as $result) :
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
                                    if (isset($_GET['paymentstatusid'])) {
                                        if ($_GET['paymentstatusid'] == "" || $result->paymentstatusid == $_GET['paymentstatusid']) {
                                        } else {
                                            continue;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td><a target="_blank" href="<?php echo base_url('payments/generatereservationreceipt') ?>?reservationpaymentid=<?php echo $result->reservation_paymentid ?>&type=view"><?php echo $result->reservation_paymentid    ?></a></td>
                                        <td><a target="_blank" href="<?php echo base_url('users/reservationDetails') ?>?id=<?php echo $result->reservationid; ?>"><b><?php echo $result->studentName ?></b></a>
                                        </td>
                                        <td><?php echo $result->coursename . ", " . $result->admissiontypename . "<br />Section: " . $result->sectionname ?></td>
                                        <td><?php echo $result->paymentstatusname ?></td>
                                        <td><?php echo $result->paymentamount ?></td>
                                        <td><?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?></td>
                                        <td><?php echo $result->paymenttypename ?></td>
                                        <td><?php echo $result->otherdetails ?></td>
                                        <td><a target="_blank" href="<?php echo base_url('users/employeedetails') . "/" . $result->receivedbyid; ?>"><b><?php echo $result->receivedby ?></b></a></td>
                                        <!-- <td><?php echo $result->receivedby ?></td> -->
                                        <td>
                                            <a title="View" target="_blank" href="<?php echo base_url('payments/generatereservationreceipt') ?>?reservationpaymentid=<?php echo $result->reservation_paymentid ?>&type=view"><i class="fa fa-eye"></i></a>&nbsp;
                                            <a title="Download" href="<?php echo base_url('payments/generatereservationreceipt') ?>?reservationpaymentid=<?php echo $result->reservation_paymentid ?>&type=download"><i class="fa fa-download"></i></a>&nbsp;
                                            <!-- <a title="Send Email" onclick="sendpaymentemail('<?php echo $result->paymentid ?>', '<?php echo $result->userid ?>')"><i class="fa fa-paper-plane"></i></a> -->
                                            <br /><br />
                                            <!-- <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_edit == 1) :
                                                if ($result->paymentstatusname != "Approved") :
                                            ?>
                                                    <i data-toggle="modal" data-target="#editpayment" class="fa fa-pencil-square-o" onclick="editPayment('<?php echo $result->paymentid ?>','<?php echo $result->name ?>','<?php echo $result->paymenttypeid ?>','<?php echo $result->paymentamount ?>','<?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?>','<?php echo $result->otherdetails ?>','<?php echo $result->remarks ?>')"></i>
                                            <?php
                                                endif;
                                            endif; ?> -->
                                            &nbsp;
                                            <!-- <?php if ($_SESSION['rights'][array_search('Payment', array_column($_SESSION['rights'], 'operationname'))]->_delete == 1) : ?>
                                                <?php
                                                $html = "<a href='" . base_url('payments/deletepayment') . "?paymentid=" . $result->paymentid . "' class='btn-del'><i class='fa fa-trash'></i></a>";
                                                echo $html; ?>
                                            <?php endif; ?> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
                                        <input type="hidden" name="returnURL" value="payments/payment" />
                                        <select name="reservationid" style="width: 100%;" class="select2 form-control mb" required>
                                            <option value="">Select Student</option>
                                            <?php

                                            foreach ($StudentDetails as $student) :
                                            ?>
                                                <option value="<?php echo $student->reservationid; ?>"><?php echo $student->reservation_ukey . " - " .  $student->name; ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select>
                                        <br><br>
                                    </div>
                                    <div class="col-md-6">
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
                                        <input type="hidden" name="returnURL" value="payments/payment" />
                                        <input type="hidden" name="paymentid" id="paymentid" />
                                        <label class="text-uppercase text-sm">Student Name</label>
                                        <input type="text" id="name" class="form-control mb" disabled>
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
        </div>
    </div>
</div>

<script>
    // function sendpaymentemail(paymentid, userid) {
    //     $.ajax({
    //         type: "GET",
    //         url: "<?php echo base_url('payments/sendInvoiceReceiptEmail') ?>",
    //         data: {
    //             paymentid: paymentid,
    //             userid: userid
    //         },
    //         success: () => {
    //             alert('Email Sent Successfully');
    //         }
    //     });
    // }

    function editPayment(paymentid, name, paymenttypeid, paymentamount, paymentdate, otherdetails, remarks) {
        document.getElementById('paymentid').value = paymentid;
        document.getElementById('name').value = name;
        document.getElementById('paymenttypeid').value = paymenttypeid;
        $('#paymenttypeid').trigger('change');

        document.getElementById('paymentamount').value = paymentamount;
        document.getElementById('remarks').value = remarks;
        document.getElementById('paymentdate').value = paymentdate;
        document.getElementById('otherdetails').value = otherdetails;

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