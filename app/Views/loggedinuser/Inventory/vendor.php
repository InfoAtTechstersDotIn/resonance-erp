<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Vendors
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Vendor</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Vendor Name</th>
                                    <th>Vendor GST</th>
                                    <th>Vendor PAN</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th>IFSC</th>
                                    <th>Account No.</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($vendors as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->gst ?></td>
                                        <td><?php echo $result->pan ?></td>
                                        <td><?php echo $result->bank_name ?></td>
                                        <td><?php echo $result->bank_branch ?></td>
                                        <td><?php echo $result->bank_ifsc ?></td>
                                        <td><?php echo $result->bank_account ?></td>
                                        <td><i onclick="edit('<?php echo $result->id ?>', '<?php echo  $result->name ?>','<?php echo  $result->gst ?>','<?php echo  $result->pan ?>','<?php echo  $result->bank_name ?>','<?php echo  $result->bank_branch ?>','<?php echo  $result->bank_ifsc ?>','<?php echo  $result->bank_account ?>','<?php echo  $result->bank_account_holder ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td><i onclick="remove('<?php echo $result->id ?>')" class='fa fa-trash'></i></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Add Vendor</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/addvendor') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Vendor Name</label>
                                        <input type="text" placeholder="Vendor Name" name="vendorname" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Vendor GST</label>
                                        <input type="text" placeholder="Vendor GST" name="vendorgst" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Vendor PAN</label>
                                        <input type="text" placeholder="Vendor PAN" name="vendorpan" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Bank Name</label>
                                        <input type="text" placeholder="Bank Name" name="bank_name" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Branch Name</label>
                                        <input type="text" placeholder="Branch Name" name="bank_branch" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Bank IFSC</label>
                                        <input type="text" placeholder="Bank IFSC" name="bank_ifsc" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Bank Account No.</label>
                                        <input type="text" placeholder="Bank Account No." name="bank_account" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Account Holder</label>
                                        <input type="text" placeholder="Account Holder" name="bank_account_holder" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Vendor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Vendor</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/updatevendor') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Vendor Name</label>
                                        <input type="text" placeholder="Vendor Name" name="vendorname" id="vendorname" class="form-control mb" required>
                                        <input type="hidden" name="vendorid" id="vendorid" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Vendor GST</label>
                                        <input type="text" placeholder="Vendor GST" name="vendorgst" id="vendorgst" class="form-control mb" required>
                                    </div>
                                
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Vendor PAN</label>
                                        <input type="text" placeholder="Vendor PAN" name="vendorpan" id="vendorpan"  class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Bank Name</label>
                                        <input type="text" placeholder="Bank Name" name="bank_name" id="bank_name" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Branch Name</label>
                                        <input type="text" placeholder="Branch Name" name="bank_branch" id="bank_branch" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Bank IFSC</label>
                                        <input type="text" placeholder="Bank IFSC" name="bank_ifsc" id="bank_ifsc" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Bank Account No.</label>
                                        <input type="text" placeholder="Bank Account No." name="bank_account" id="bank_account" class="form-control mb" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="text-uppercase text-sm">Account Holder</label>
                                        <input type="text" placeholder="Account Holder" name="bank_account_holder" id="bank_account_holder" class="form-control mb" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Vendor</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function edit(id, name,gst,pan, bank_name, bank_branch, bank_ifsc, bank_account, bank_account_holder) {
        $('#vendorid').val(id);
        $('#vendorname').val(name);
        $('#vendorgst').val(gst);
        $('#vendorpan').val(pan);
        $('#bank_name').val(bank_name);
        $('#bank_branch').val(bank_branch);
        $('#bank_ifsc').val(bank_ifsc);
        $('#bank_account').val(bank_account);
        $('#bank_account_holder').val(bank_account_holder);
    }

    function remove(vendorid) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('Inventory/deletevendor?id=') ?>" + vendorid;
        }
    }
</script>