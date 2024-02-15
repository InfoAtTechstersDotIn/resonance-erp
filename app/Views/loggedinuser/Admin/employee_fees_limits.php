<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Employee Fees Limits
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped DataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <!--<th>Max Discount Permitted(Each Application)</th>-->
                            <th>Available Limit/ Total Limit</th>
                            <th>Add Limit</th>
                            <th>View Discount Logs</th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($employee_fees_limits as $employee) :
                        ?>
                            <tr>
                                <td><?php echo $employee->name . " (<b>" . $employee->empid . "</b>) " ?></td>
                                <!--<td>-->
                                    <!--<input type="text" class="form-control" value="<?php echo $employee->discount == null ? 0 : $employee->discount ?>">-->
                                    <!--<a onclick="AddUpdateMaxDiscount(this, '<?php echo $employee->userid ?>')">Update</a>-->
                                <!--</td>-->
                                <td><?php echo "<h4>" . $employee->availablelimit . "/<h6>" . $employee->totallimit . "</h6></h4>"  ?></td>
                                <td>
                                    <input type="text" class="form-control">
                                    <a onclick="AddUpdateLimit(this, '<?php echo $employee->userid ?>')">Update</a>
                                </td>
                                <td>
                                    <a class="btn btn-warning" data-toggle="modal" data-target="#DiscountLogs_<?php echo $employee->userid ?>" style="float: right;margin-left:10px">View Discount Logs</a>
                                    <a class="btn btn-"></a>
                                </td>
                                <td>
                                    <div class="modal fade" id="DiscountLogs_<?php echo $employee->userid ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document" style="width: 80vw">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title">Discount Logs - <?php echo $employee->name . " (<b>" . $employee->empid . "</b>) " ?></h2>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped DataTable" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Student Name(Application Number)</th>
                                                                <th>Discount</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($discountLogs as $log) :
                                                                if ($log->discount_by == $employee->userid) :
                                                            ?>
                                                                    <tr>
                                                                        <td><?php echo $log->name . " (<b>" . $log->applicationnumber . "</b>) " ?></td>
                                                                        <td><?php echo $log->discount ?></td>
                                                                        <td><?php echo date_format(date_create($log->date), 'd/m/Y') ?></td>
                                                                    </tr>
                                                            <?php
                                                                endif;
                                                            endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function AddUpdateMaxDiscount(value, userid) {
        var discount = value.previousElementSibling.value;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/AddUpdateMaxDiscount') ?>",
            data: {
                discount: discount,
                userid: userid
            },
            success: () => {
                alert("Value Updated");
                location.reload();
            }
        });
    }

    function AddUpdateLimit(value, userid) {
        var limit = value.previousElementSibling.value;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/AddUpdateLimit') ?>",
            data: {
                limit: limit,
                userid: userid
            },
            success: (data) => {
                alert("Value Updated");
                location.reload();
            }
        });
    }
</script>