<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Distribute Category
                </h2>
                <form method='get' action=''>
                <select class="select2 mb" name='category' onchange="this.form.submit()">
                                                <option>Select Distribute Category
                                                </option>
                                                <option value='1'  <?php if($_GET['category']==1){echo "selected";}?>>Student
                                                </option>
                                                <option value='2' <?php if($_GET['category']==2){echo "selected";}?>>Employee
                                                </option>
                                            </select>
                                            <input type='hidden' value="<?php echo $_GET['inventorydetailsid'] ;?>" name="inventorydetailsid">
                                           
                </form>
                <div class="row">
                    <?php
                    $remainingcount = array();
                    foreach($InventoryDetails as $inventory){
                       
                        ?>
                        <div class="col-md-4">
                        <label class="text-uppercase text-sm">Product Name</label><br />
                        <?php echo $inventory->productname ?>
                        <input type="hidden" name="productid" value="<?php echo $inventory->productid ?>" />
                        <input type="hidden" name="inventorydetailsid" value="<?php echo $inventory->inventorydetailsid ?>" />
                    </div>
                   
                    <div class="col-md-4">
                        <label class="text-uppercase text-sm">Original Total</label><br />
                        <?php echo $inventory->quantity ?>
                    </div>
                    <div class="col-md-4">
                        <label class="text-uppercase text-sm">Remaining Total</label><br />
                        <span class="remaining"><?php echo $inventory->available_quantity ?></span>
                    </div>
                        <?php
                    array_push($remainingcount,$inventory->available_quantity);
                       
                    }
                    $res = min($remainingcount);
                   ?>
                   <input type="hidden" name="remainingtotal" id="hdnremainingtotal" value="<?php echo $res ?>" />
                </div>
                <br />
                <?php if ($_GET['category'] == "Admin") : ?>
                    <form method="post" action="<?php echo base_url('Inventory/admin_inventory') ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="productid" value="<?php echo $InventoryDetails[0]->productid ?>" />
                                <input type="hidden" name="inventorydetailsid" value="<?php echo $InventoryDetails[0]->inventorydetailsid ?>" />
                                <input type="hidden" name="remainingtotal" value="<?php echo $InventoryDetails[0]->remainingtotal ?>" />

                                <label class="text-uppercase text-sm">Utilized Count</label><br />
                                <input type="number" placeholder="Utilized Count" min="0" max="<?php echo $InventoryDetails[0]->remainingtotal ?>" name="count" class="form-control mb" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-uppercase text-sm">Comment</label><br />
                                <input type="text" placeholder="Comment" name="comment" class="form-control mb" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Distribute</button>
                    </form>
                <?php elseif ($_GET['category'] == "2") : ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblotherusers" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Distributed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($EmployeeDetails as $employee) :
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $employee->name . " ({$employee->employeeid})" ?>
                                            </td>
                                            <td>
                                                <input type="checkbox" <?php echo $employee->givenby != "" ? 'checked disabled' : '' ?> onclick="distributeEmployee(this, '<?php echo $InventoryDetails[0]->productid ?>','<?php echo $employee->userid ?>','<?php echo $InventoryDetails[0]->inventorydetailsid ?>')" />
                                                <?php echo ($employee->date != "" ? " - " . date_format(date_create($employee->date), 'd/m/Y') : "") ?>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                <?php elseif ($_GET['category'] == "1") :
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tblotherusers" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Distributed</th>
                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($StudentDetails as $student) :
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    if ($student->reservation_ukey == NULL || $student->reservation_ukey == '') {
                                                        echo $student->name . $student->branchid . " ({$student->applicationnumber})";
                                                    } else {
                                                        echo $student->name . " ({$student->applicationnumber})" . " ({$student->reservation_ukey})";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    
                                                    <input type="checkbox" <?php echo $student->date != "" ? 'checked disabled' : '' ?> onclick="distributeStudent(this, '<?php if(count($product) > 0 ) { print_r(implode(',',$product)); }else{ echo $InventoryDetails[0]->productid ;} ?>','<?php echo $student->userid ?>','<?php echo $InventoryDetails[0]->id ?>')" />
                                                    <?php echo " - " . ($student->date != "" ? date_format(date_create($student->date), 'd/m/Y') : "") ?>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="<?php echo base_url('inventory/print_InventoryReceipt') . '?userid=' . $student->userid . '&inventorydetailsid=' . $InventoryDetails[0]->productid ?>"><i class='fa fa-print'></i></a>
                                                </td>
                                            </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                <?php elseif ($InventoryDetails[0]->distributecategory == "Reservation") : ?>
                    <div class="row">
                        <div class="col-md-12">

                            <table id="tblotherusers" class="DataTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Distributed</th>
                                        <th>Print</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ReservationStudentDetails as $student) :
                                        if (($InventoryDetails[0]->courseid == 0 || $student->courseid == $InventoryDetails[0]->courseid)) :
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php echo $student->name . $student->branchname . " ({$student->reservation_ukey})" ?>
                                                </td>
                                                <td>
                                                    <input type="checkbox" <?php echo $student->givenby != "" ? 'checked disabled' : '' ?> onclick="distributeReservationStudent(this, '<?php echo $InventoryDetails[0]->productid ?>','<?php echo $student->reservationid ?>','<?php echo $InventoryDetails[0]->inventorydetailsid ?>')" />
                                                    <?php echo " - " . ($student->date != "" ? date_format(date_create($student->date), 'd/m/Y') : "") ?>
                                                </td>
                                                <td>
                                                    <a target="_blank" href="<?php echo base_url('inventory/print_InventoryReceipt1') . '?userid=' . $student->reservationid . '&inventorydetailsid=' . $InventoryDetails[0]->id ?>"><i class='fa fa-print'></i></a>
                                                </td>
                                            </tr>
                                    <?php
                                        endif;
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function distributeEmployee(current, productid, userid, inventorydetailsid) {
        remainingtotal = document.getElementById('hdnremainingtotal').value;
        $.ajax({
            url: "<?php echo base_url('Inventory/employee_inventory') ?>",
            type: "POST",
            async: false,
            data: {
                productid: productid,
                userid: userid,
                inventorydetailsid: inventorydetailsid,
                remainingtotal: remainingtotal,
            },
            success: function(data) {
                if (data == 1) {
                    current.disabled = 'true';
                    document.getElementById('hdnremainingtotal').value = remainingtotal - 1;
                    document.getElementsByClassName('remaining').innerText = remainingtotal - 1;
                } else {
                    alert("You dont have items remaining");
                    current.checked = false;
                }
            }
        });
    }

    function distributeStudent(current, productid, userid, inventorydetailsid) {
        remainingtotal = document.getElementById('hdnremainingtotal').value;
        var elements = document.getElementsByClassName("remaining");
        if(remainingtotal == 0)
        {
            alert("You dont have items remaining");
                    current.checked = false;
                    return false;
        }
        $.ajax({
            url: "<?php echo base_url('Inventory/student_inventory') ?>",
            type: "POST",
            async: false,
            data: {
                productid: productid,
                userid: userid,
                inventorydetailsid: inventorydetailsid,
                remainingtotal: remainingtotal,
            },
            success: function(data) {
                if (data == 1) {
                    current.disabled = 'true';
                    document.getElementById('hdnremainingtotal').value = remainingtotal - 1;
                    for(var i=0;i<elements.length;i++)
                    {
                      elements[i].innerHTML = elements[i].innerText - 1;
                    }
                } else {
                    alert("You dont have items remaining");
                    current.checked = false;
                }
            }
        });
    }

    function distributeReservationStudent(current, productid, userid, inventorydetailsid) {
        remainingtotal = document.getElementById('hdnremainingtotal').value;
        
        $.ajax({
            url: "<?php echo base_url('Inventory/reservation_inventory') ?>",
            type: "POST",
            async: false,
            data: {
                productid: productid,
                userid: userid,
                inventorydetailsid: inventorydetailsid,
                remainingtotal: remainingtotal,
            },
            success: function(data) {
                if (data == 1) {
                    current.disabled = 'true';
                    document.getElementById('hdnremainingtotal').value = remainingtotal - 1;
                    document.getElementsByClassName('remaining').innerText = remainingtotal - 1;
                } else {
                    alert("You dont have items remaining");
                    current.checked = false;
                }
            }
        });
    }
</script>