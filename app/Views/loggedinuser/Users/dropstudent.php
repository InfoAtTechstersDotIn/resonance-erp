<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <h1>Drop Student</h1>
                <br />
                <div class="col-md-6">
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
                <div class="col-md-6">
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

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Invoices</h2>
                <br>
                <table id="tblinvoices" class="DataTable table table-striped" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>InvoiceId</th>
                            <th>Branch</th>
                            <th>Course - Admission Type - Section</th>
                            <th>Total Invoice Value</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($InvoiceDetails as $result) :
                        ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><?php echo $result->invoiceid ?></a></td>
                                <td><?php echo $result->branchname ?></td>
                                <td><?php echo $result->coursename . ", " . $result->admissiontypename . "<br />Section: " . $result->sectionname ?></td>
                                <td><?php echo $result->TotalValue ?></td>
                                <td>
                                    <a title="View" target="_blank" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=view"><i class="fa fa-eye"></i></a>&nbsp;
                                    <a title="Download" href="<?php echo base_url('payments/generateinvoice') ?>?invoiceid=<?php echo $result->invoiceid ?>&type=download"><i class="fa fa-download"></i></a>&nbsp;
                                    <a title="Send Email" onclick="sendinvoiceemail('<?php echo $result->invoiceid ?>', '<?php echo $result->userid ?>')"><i class="fa fa-paper-plane"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h2>Payments</h2>
                <table id="tblPayments" class="table table-striped DataTable" style="width: 100% !important;">
                    <thead>
                        <tr>
                            <th>Application Number</th>
                            <th>Payment Status</th>
                            <th>Payment</th>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Payment Details</th>
                            <th>Amount Received By</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($PaymentDetails as $result) :
                        ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo base_url('payments/generatereceipt') ?>?paymentid=<?php echo $result->paymentid ?>&type=view"><?php echo $result->paymentid ?></a></td>
                                <td><?php echo $result->paymentstatusname ?></td>
                                <td><?php echo $result->paymentamount ?></td>
                                <td><?php echo date_format(date_create($result->paymentdate), 'd/m/Y') ?></td>
                                <td><?php echo $result->paymenttypename ?></td>
                                <td><?php echo $result->otherdetails ?></td>
                                <td><?php echo $result->receivedby ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h2>Issue Refund</h2>
                <h6>(Refund should be always a negative amount)</h6>
                <form method="post" action="<?php echo base_url('users/issueRefundAndDropStudent') ?>">
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-uppercase text-sm">Refund Amount</label>
                            <input type="number" placeholder="Payment Amount" max="0" name="paymentamount" class="form-control mb" required>
                            <input type="hidden" name="returnURL" value="users/studentdetails?id=<?php echo $userid ?>" />
                            <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                        </div>
                        <div class="col-md-6">
                            <label class="text-uppercase text-sm">Refund Details</label>
                            <input type="text" placeholder="UTR No / Check No / Recipt No" name="otherdetails" class="form-control mb" required>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-6">
                            <label class="text-uppercase text-sm">Refund Date</label>
                            <input type="text" placeholder="dd/mm/yy" name="paymentdate" class="form-control mb datepicker" required>
                        </div> -->
                        <div class="col-md-6">
                            <label class="text-uppercase text-sm">Remarks</label>
                            <input type="text" placeholder="Remarks" name="remarks" class="form-control mb">
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <label class="text-uppercase text-sm">Refunded By</label>
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
                    <button type="submit" class="btn btn-danger">Issue Refund and Drop Student</button>
                </form>
            </div>
        </div>
    </div>
</div>