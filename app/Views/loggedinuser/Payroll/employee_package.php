<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Employee Package
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Name/ Employee Id</th>
                                    <th>Branch</th>
                                    <th>Role</th>
                                    <th>Package</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($employee_packages as $result) :

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
                                        <td><?php echo $result->name ?><br /><a target="_blank" href="<?php echo base_url('users/employeedetails') . '/' . $result->userid ?>"><?php echo $result->employeeid ?></a></td>
                                        <td><?php echo rtrim($branches, ', '); ?></td>
                                        <td><?php echo $result->rolename ?></td>
                                        <td><input type="number" id="package_<?php echo $result->userid ?>" value="<?php echo $result->package ?>" /></td>
                                        <td><a onclick="updatePackage('package_<?php echo $result->userid ?>', '<?php echo $result->userid ?>')" class="btn btn-primary">Update</a></td>
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
    function updatePackage(a, b) {
        newPackage = $('#' + a).val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('payroll/update_employee_package') ?>",
            data: {
                newpackage: newPackage,
                userid: b
            },
            success: () => {
                alert('Package Updated');
            }
        });
    }
</script>