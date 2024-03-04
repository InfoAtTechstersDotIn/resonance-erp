<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Asset Audits
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Create Asset Audit</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Date</th>
                                    <th>Remark</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asset_audits as $result) : ?>
                                <tr>
                                    <td><?php echo $result->branchname ?></td>
                                    <td><?php echo $result->date ?></td>
                                    <td><?php echo $result->remark ?></td>
                                    <td><a href="<?php echo base_url('Inventory/asset_audit_details/'.$result->id) ?>">View Details</a></td>
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
                            <h2 class="modal-title">Add Asset Audit</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('Inventory/add_asset_audit') ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select name="branch_id" style="width: 100%;" class="form-control mb">
                                            <option value="">Select Branch</option>
                                            <?php
                                            foreach ($lookups['branchlookup'] as $branch) : ?>
                                                <option value="<?php echo $branch->branchid; ?>"><?php echo $branch->branchname; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Remark</label>
                                        <input type="text" placeholder="Remark" name="remark" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Audit Date</label>
                                        <input type="date" name="date" class="form-control mb" required>
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        
        </div>
    </div>
</div>

<script>

    function remove(id) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('Inventory/delete_asset_audit?asset_audit_id=') ?>" + id;
        }
    }
</script>