<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Salary Payments
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#generateCurrentMonthSalaries">Generate Current Month Salaries</a>
                </h2>
                <br />
               <form>
                    <div class="row">
                        <div class="col-md-4">
                            <?php if (isset($_GET['date'])) {
                                $date = $_GET['date'];
                            } else {
                                $date = '';
                            }
                            ?>
                            <label class="text-uppercase text-sm">Filter By Month/ Year</label>
                            <input type="month" name="date" class="form-control mb" required value="<?php echo $date; ?>">
                        </div>
                        <div class="col-md-4">
                            <br />
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Branch</th>
                                    <th>Role</th>
                                    <th>Breakdown</th>
                                    <th>Edit</th>
                                    <th>Regenerate</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($salaries != null) :
                                    foreach ($salaries as $result) :

                                        $branchids = explode(',', $result->branchid);
                                        if (isset($_GET['branchid'])) {
                                            if ($_GET['branchid'] == "" || in_array($_GET['branchid'], $branchids)) {
                                            } else {
                                                continue;
                                            }
                                        }
                                        if (isset($_GET['roleid'])) {
                                            if ($_GET['roleid'] == "" || $result->roleid == $_GET['roleid']) {
                                            } else {
                                                continue;
                                            }
                                        }
                                        $branches = "";
                                        if ($result->branchid != null) {
                                            foreach ($branchids as $branchid) {
                                                foreach ($lookups['branchlookup'] as $branch) {
                                                    if ($branch->branchid == $branchid) {
                                                        $branches .= $branch->branchname . ', ';
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                ?>
                                        <tr>

                                            <td><a target="_blank" href="<?php echo base_url('users/employeedetails') . '/' . $result->userid ?>"><?php echo $result->name ?></a></td>
                                            <td><?php echo rtrim($branches, ', '); ?></td>
                                            <td><?php echo $result->rolename ?></td>
                                             <td>
                                                <a data-toggle="modal" data-target="#addsalarygrade_<?php echo $result->salarypaymentid ?>"><i class="fa fa-sticky-note-o"></i></a>
                                                <div class="modal fade" id="addsalarygrade_<?php echo $result->salarypaymentid ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document" style="width: 90vw">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h2 class="modal-title">Salary Breakdown</h2>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <b>Name:</b> <?php echo $result->name . " ({$result->employeeid})"; ?><br />
                                                                        <b>Package:</b> <?php echo $result->ctc; ?><br />
                                                                        <b>Monthly:</b> <?php echo $result->monthly; ?><br />
                                                                        <b>Daily:</b> <?php echo $result->daily; ?><br />
                                                                        <b>Date:</b> <?php echo $result->salarydate; ?><br />
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <b>Basic:</b> <?php echo $result->basic; ?><br />
                                                                        <b>House Rental Allowance:</b> <?php echo $result->houserentalallowance; ?><br />
                                                                        <b>Special Allowance:</b> <?php echo $result->specialallowance; ?><br />
                                                                        <b>Transport Allowance:</b> <?php echo $result->transportallowance; ?><br /><br />
                                                                        <b>Basic Arrears:</b> <?php echo $result->basic_arrears; ?><br />
                                                                        <b>Other Arrears:</b> <?php echo $result->other_arrears; ?><br />
                                                                        <b>Bonus:</b> <?php echo $result->bonus; ?><br /><br />
                                                                        <b>Gross:</b> <?php echo $result->gross; ?><br />
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <b>PT:</b> <?php echo $result->pt; ?><br />
                                                                        <b>TDS:</b> <?php echo $result->tds; ?><br />
                                                                        <b>Loan/Advance Deductions:</b> <?php echo $result->emi_deduction; ?><br />
                                                                        <b>Penalty:</b> <?php echo $result->penalty; ?><br />
                                                                        <b>Other Deductions:</b> <?php echo $result->other_decuctions; ?><br /><br />
                                                                        <b>Net:</b> <?php echo $result->net; ?><br /><br />
                                                                        <b>Comments:</b> <?php echo $result->comments; ?><br /><br />
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <b>Total Business Days:</b> <?php echo $result->totalbusinessdays; ?><br />
                                                                        <b>Total Paid Days:</b> <?php echo $result->paiddays; ?><br />
                                                                        <b>Total Unpaid Days:</b> <?php echo $result->unpaiddays; ?><br />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                           <td>
                                                <?php
                                                $todaysDate = date_create(date("Y-m-d"));
                                                $todaysmonth = (date("Y-m-d"));
                                                $newdate = date("m", strtotime('-1 month', strtotime($todaysmonth)));
                                                $salaryDate = date_create($result->salarydate);

                                                if (
                                                    $newdate == date_format($salaryDate, "m") &&
                                                    date_format($todaysDate, "Y") == date_format($salaryDate, "Y")
                                                ) : ?>
                                                    <a href="<?php echo base_url('payroll/edit_payslip') . '/' . $result->salarypaymentid ?>"><i class="fa fa-pencil-square-o editbtn"></i></a>
                                                <?php
                                                endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $todaysDate = date_create(date("Y-m-d"));
                                                $salaryDate = date_create($result->salarydate);
                                                if (
                                                    $newdate == date_format($salaryDate, "m") &&
                                                    date_format($todaysDate, "Y") == date_format($salaryDate, "Y")
                                                ) : ?>
                                                    <a href="<?php echo base_url("payroll/regenerate_salary/{$result->userid}/{$result->salarydate}") ?>" onclick="return confirm('Are you sure to regenerate salary?')"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                                <?php
                                                endif; ?>
                                            </td>
                                            <td><a target="_blank" href="<?php echo base_url("payments/generatepayslip/{$result->salarypaymentid}") ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>

                                        </tr>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="generateCurrentMonthSalaries" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document" style="width: 60vw">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Generate Current Month Salaries</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('payroll/generate_current_month_salaries') ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Month/ Year</label>
                                        <input type="month" min="<?php echo date('Y-m', strtotime('-1 months')); ?>" max="<?php echo date('Y-m', strtotime('-1 months')); ?>" name="salarydate" class="form-control mb" required>
                                    </div>
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
                                </div>
                                <button type="submit" class="btn btn-primary">Generate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #tooltip1 {
        position: relative;
    }

    #tooltip1 a span {
        display: none;
        color: #FFFFFF;
    }

    #tooltip1 a:hover span {
        display: block;
        position: absolute;
        width: 300px;
        height: 530px;
        left: 100px;
        background: #aaa;
        top: -10px;
        color: #FFFFFF;
        padding: 0 5px;
    }
</style>
<script>
    $('.date-picker').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/yy'
    });

    function edit(id, value) {
        $('#id').val(id);
        $('#name').val(value);
    }

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('master/deletesection?id=') ?>" + id;
        }
    }
</script>