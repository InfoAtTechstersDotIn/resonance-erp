<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <select name="role" style="width: 100%;" class="select2 form-control mb" onchange="loadrights(this.value)" required>
                    <option value="">Select Role</option>
                    <?php
                    foreach ($lookups['roleslookup'] as $role) :
                    ?>
                        <option value="<?php echo $role->roleid; ?>" <?php echo $roleid == $role->roleid ? "selected" : "" ?>><?php echo $role->rolename; ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="tblRights" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Operation Name</th>
                            <th>_add</th>
                            <th>_view</th>
                            <th>_edit</th>
                            <th>_delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lookups['rightslookup'] as $key => $right) {
                            if ($right->roleid == $roleid && $right->parent == 0) :
                        ?>
                                <tr>
                                    <td><?php echo $key + 1 ?></td>
                                    <td><?php echo $right->operationname ?></td>
                                    <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right->operationid ?>, 'add')" <?php echo $right->_add == 1 ? "checked" : "" ?>></td>
                                    <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right->operationid ?>, 'view')" <?php echo $right->_view == 1 ? "checked" : "" ?>></td>
                                    <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right->operationid ?>, 'edit')" <?php echo $right->_edit == 1 ? "checked" : "" ?>></td>
                                    <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right->operationid ?>, 'delete')" <?php echo $right->_delete == 1 ? "checked" : "" ?>></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="5">
                                        <table id="tblRights" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Operation Name</th>
                                                    <th>_add</th>
                                                    <th>_view</th>
                                                    <th>_edit</th>
                                                    <th>_delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($lookups['rightslookup'] as $key1 => $right1) {
                                                    if ($right1->roleid == $roleid && $right1->parent == $right->operationid) :
                                                ?>
                                                        <tr>
                                                            <td><?php echo $right1->operationname ?></td>
                                                            <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right1->operationid ?>, 'add')" <?php echo $right1->_add == 1 ? "checked" : "" ?>></td>
                                                            <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right1->operationid ?>, 'view')" <?php echo $right1->_view == 1 ? "checked" : "" ?>></td>
                                                            <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right1->operationid ?>, 'edit')" <?php echo $right1->_edit == 1 ? "checked" : "" ?>></td>
                                                            <td><input type="checkbox" onchange="setRights(this.checked, <?php echo $right1->operationid ?>, 'delete')" <?php echo $right1->_delete == 1 ? "checked" : "" ?>></td>
                                                        </tr>
                                                <?php
                                                    endif;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                        <?php
                            endif;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function loadrights(roleid) {
        window.location.href = "<?php echo base_url('admin/rights') ?>?roleid=" + roleid;
    }

    function setRights(checked, operationid, right) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/setrights') ?>",
            data: {
                setright: true,
                checked: checked,
                operationid: operationid,
                right: right,
                roleid: <?php echo $roleid == "" ? 0 : $roleid  ?>
            }
        });
    }
</script>