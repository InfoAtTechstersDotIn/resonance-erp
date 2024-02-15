<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Employee Attendance
                </h2>
            </div>
        </div>
        <form id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <label class="text-uppercase text-sm"> Date</label>
                    <input type="text" style="height: 30px !important" onchange="filter()" value="<?php echo (isset($_GET['date']) && $_GET['date'] != "") ? "{$_GET['date']}" : "" ?>" placeholder="dd/mm/yy" id="date" name="date" class="form-control mb datepicker" required>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <?php
                $date = isset($_GET['date']) && $_GET['date'] != "" ? $_GET['date'] : "";

                if ($date != "") :
                ?>
                 <form>
                     <input type="hidden" name="date" value="<?php echo $_GET['date'];?>">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branchid" style="width: 100%;" class="form-control mb">
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
                            <select name="late" style="width: 100%;" class="form-control mb">
                                <option value="">Select</option>
                                <option value="1" <?php echo isset($_GET['late']) && $_GET['late'] == 1 ? "selected" : "" ?>>Present</option>
                                <option value="0" <?php echo isset($_GET['late']) && $_GET['late'] == 0 ? "selected" : "" ?>>Absent</option>
                                <option value="2" <?php echo isset($_GET['late']) && $_GET['late'] == 2 ? "selected" : "" ?>>Late Login</option>
                                <option value="3" <?php echo isset($_GET['late']) && $_GET['late'] == 3 ? "selected" : "" ?>>Early Logout</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
<?php  $count=0;?>
                    <form method="post" id="add_attendance" action="<?php echo base_url('users/add_employee_attendance') ?>">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Attendance</th>
                                    <th>Time</th>
                                    <th>Late Login</th>
                                    <th>Early Logout</th>
                                    <th>Other Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                              
                                foreach ($attendance_info as $result) :
                                    
                                    $branchids = explode(',', $result->branchid);
                                    if (isset($_GET['branchid'])) {
                                        if ($_GET['branchid'] == "" || in_array($_GET['branchid'], $branchids)) {
                                        } else {
                                            continue;
                                        }
                                    }
                                    if (isset($_GET['late'])) {
                                        if($_GET['late']==1 || $_GET['late']==0)
                                        {
                                        if ($result->status==$_GET['late']) {
                                        } else {
                                            continue;
                                        }
                                        }else
                                        {
                                           if($_GET['late']==2)
                                            {
                                                if ($result->isLatelogin==1) {
                                                    } else {
                                                        continue;
                                                    }
                                            }else
                                            {
                                                if ($result->isEarlyLogout==1) {
                                                    } else {
                                                        continue;
                                                    }
                                                
                                            }
                                        }
                                    }
                                ?>
                                    <tr style="color: white;background-color: <?php 
                                    
                                    if($result->status == 1 && ($result->isLatelogin !=1 || $result->isEarlyLogout !=1)){ echo 'green';}else{ echo 'red';} ?> ">
                                        <td><?php echo $result->name ?></td>
                                        <td>
                                            Present: <input type="radio" name="<?php echo $result->userid ?>_status[]" value="1" <?php echo $result->status == 1 ? "checked" : "" ?> style="margin-right: 20px; !important" />
                                            Absent: <input type="radio" name="<?php echo $result->userid ?>_status[]" value="0" <?php echo $result->status == 0 ? "checked" : "" ?> style="margin-right: 20px; !important" />
                                            <!--Late: <input type="radio" name="<?php echo $result->userid ?>_status[]" value="2" <?php echo $result->status == 2 ? 'checked' : '' ?> style="margin-right: 20px; !important" />-->
                                            <input type="hidden" name="userid[]" value="<?php echo $result->userid ?>" />

                                        </td>
                                        <td>
                                            <?php
                                            if ($result->status == 2 || $result->status == 1) {
                                                echo "Login Time: " . $result->loginTime . "<br />";
                                                echo "Logout Time: " . $result->logoutTime . "<br />";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                        Is Late Login: <input type="checkbox" name="<?php echo $result->userid ?>_login[]" <?php echo $result->isLatelogin == 1 ? "checked" : "" ?> style="margin-right: 20px; !important" />
                                        </td>
                                        <td>
                                        Is Early Logout: <input type="checkbox" name="<?php echo $result->userid ?>_logout[]" <?php echo $result->isEarlyLogout == 1 ? "checked" : "" ?> style="margin-right: 20px; !important" />
                                        </td>
                                        <td>
                                            Late Login: <?php echo $result->isLatelogin == 1 ? "Yes" : "No"; ?><br />
                                            Late Reason: <?php echo $result->lateLoginReason; ?><br />
                                            Login Regularised: <?php echo $result->loginregularised == 1 ? "Yes" : "No"; ?><br />
                                            Early Logout: <?php echo $result->isEarlyLogout == 1 ? "Yes" : "No"; ?><br />
                                            Early Logout Reason: <?php echo $result->earlyLogoutReason; ?><br />
                                            Logout Regularised: <?php echo $result->logoutregularised == 1 ? "Yes" : "No"; ?><br />
                                        </td>
                                    </tr>
                                <?php $count++; endforeach; ?>
                                <input type="hidden" name="date" value="<?php echo $_GET['date'] ?>" />
                            </tbody>
                        </table>
                        <?php if ($_SESSION['rights'][array_search('Attendance', array_column($_SESSION['rights'], 'operationname'))]->_add == 1) : ?>
                            <button type="submit" class="btn btn-primary">Update</button>
                        <?php endif; ?>
                    <?php
                endif;
                    ?>
                    </form>
                <?php
                echo $count;?> Records
            </div>
        </div>
    </div>
</div>

<script>
    function filter() {
        var teacherid = $('#date').val();

        var URL = "<?php echo base_url('users/employee_attendance') ?>" + "?" + $('#filterForm').serialize();
        window.location.href = URL;
    }
</script>