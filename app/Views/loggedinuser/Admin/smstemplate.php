<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">SMS Templates 
                    <a class="btn btn-success" style="float: right;" data-toggle="modal" data-target="#add">Add Template</a>
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Template Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($smstemplates as $result) :
                                ?>
                                    <tr>
                                        <td><i><?php echo $result->smstemplatename ?></i></td>
                                        <td><i onclick="edit('<?php echo $result->smstemplateid ?>', '<?php echo  $result->smstemplatename ?>', '<?php echo  $result->smstemplate ?>')" data-toggle="modal" data-target="#edit" class="fa fa-pencil-square-o editbtn"></i></td>
                                        <td><i onclick="remove('<?php echo $result->smstemplateid ?>')" class='fa fa-trash'></i></td>
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
                            <h2 class="modal-title">Add Template</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/addsmstemplate') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Template Name</label>
                                        <input type="text" placeholder="Template Name" name="smstemplatename" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Template</label>
                                        <textarea placeholder="Class Description" name="smstemplate" class="form-control mb" required></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Template</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title">Edit Template</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="<?php echo base_url('admin/updatesmstemplate') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Template Name</label>
                                        <input type="text" placeholder="Template Name" name="smstemplatename" id="smstemplatename" class="form-control mb" required>
                                        <input type="hidden" name="smstemplateid" id="smstemplateid" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Template</label>
                                        <textarea placeholder="Class Description" name="smstemplate" id="smstemplate" class="form-control mb" required></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Template</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function edit(smstemplateid, smstemplatename, smstemplate) {
        $('#smstemplateid').val(smstemplateid);
        $('#smstemplatename').val(smstemplatename);
        $('#smstemplate').val(smstemplate);
    }

    function remove(smstemplateid) {
        if(confirm('Are you sure?'))
        {
            window.location.href = "<?php echo base_url('admin/deletesmstemplate?smstemplateid=') ?>" + smstemplateid;
        }
    }
</script>