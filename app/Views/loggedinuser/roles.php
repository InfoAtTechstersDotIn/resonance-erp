<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Roles
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#addroles">Add Role</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($lookups['roleslookup'] as $key => $role) :
                                ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo $role->rolename ?></td>
                                        <td>
                                            <i class="fa fa-pencil-square-o"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-trash"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addroles" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Role</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/createrole') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="rolename" class="text-uppercase text-sm">Role Name</label>
                                        <input type="text" placeholder="Role Name" name="rolename" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" name="createrole" class="btn btn-primary">Create Role</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Operations
                    <a class="btn btn-success" style="float: right;display:block" data-toggle="modal" data-target="#addoperation">Add Operation</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblseniormanagement" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operation Name</th>
                                    <th>Parent</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($lookups['operationslookup'] as $key => $operation) :
                                ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo $operation->operationname ?></td>
                                        <td><?php
                                            if (array_search($operation->parent, array_column($lookups['operationslookup'], 'operationid')) === false) {
                                                echo "-";
                                            } else {
                                                echo $lookups['operationslookup'][array_search($operation->parent, array_column($lookups['operationslookup'], 'operationid'))]->operationname;
                                            }
                                            ?></td>
                                        <td>
                                            <i class="fa fa-pencil-square-o"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-trash"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addoperation" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Operation</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/createoperation') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="operationname" class="text-uppercase text-sm">Operation Name</label>
                                        <input type="text" placeholder="Operation Name" name="operationname" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="parent" class="text-uppercase text-sm">Select Parent Operation</label>
                                        <select name="parent" style="width: 100%;" class="select2 form-control mb">
                                            <option value="">Select Parent</option>
                                            <?php
                                            foreach ($lookups['operationslookup'] as $operation) :
                                                if ($operation->parent == 0) :
                                            ?>
                                                    <option value="<?php echo $operation->operationid; ?>"><?php echo $operation->operationname; ?></option>
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="createoperation" class="btn btn-primary">Create Operation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>