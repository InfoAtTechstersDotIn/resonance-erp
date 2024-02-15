<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Email Templates
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
                                foreach ($emailtemplates as $result) :
                                ?>
                                    <tr>
                                        <td><i><?php echo $result->emailtemplatename ?></i></td>
                                        <td>
                                            <i data-toggle="modal" data-target="#edit_<?php echo $result->emailtemplateid ?>" class="fa fa-pencil-square-o editbtn"></i>
                                            <div class="modal fade" id="edit_<?php echo $result->emailtemplateid ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h2 class="modal-title">Edit Template</h2>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="<?php echo base_url('admin/updateemailtemplate') ?>">
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <label class="text-uppercase text-sm">Template Name</label>
                                                                        <br />
                                                                        <input type="text" style="width: 100%;" placeholder="Template Name" name="emailtemplatename" value="<?php echo $result->emailtemplatename ?>" class="form-control mb" required>
                                                                        <input type="hidden" name="emailtemplateid" value="<?php echo $result->emailtemplateid ?>" />
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="text-uppercase text-sm">Template</label>
                                                                        <div class="emailtemplate_<?php echo $result->emailtemplateid ?>" name="emailtemplate">
                                                                            <?php echo $result->emailtemplate ?>
                                                                        </div>
                                                                        <input type="hidden" name="emailtemplate" id="emailtemplate_<?php echo $result->emailtemplateid ?>" >
                                                                    </div>
                                                                </div>
                                                                <br />
                                                                <button type="submit" id="btn-submit_<?php echo $result->emailtemplateid ?>" class="btn btn-primary">Update Template</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                var quill = new Quill('.emailtemplate_<?php echo $result->emailtemplateid ?>', {
                                                    theme: 'snow'
                                                });

                                                $('#btn-submit_<?php echo $result->emailtemplateid ?>').on('click', () => {
                                                    var html = $('.emailtemplate_<?php echo $result->emailtemplateid ?> > .ql-editor')[0].innerHTML;
                                                    $('#emailtemplate_<?php echo $result->emailtemplateid ?>').val(html)
                                                })
                                            </script>
                                        </td>
                                        <td><i onclick="remove('<?php echo $result->emailtemplateid ?>')" class='fa fa-trash'></i></td>
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
                            <form method="post" action="<?php echo base_url('admin/addemailtemplate') ?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Template Name</label>
                                        <input type="text" placeholder="Template Name" name="emailtemplatename" class="form-control mb" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="text-uppercase text-sm">Template</label>
                                        <div class="emailtemplate">
                                        </div>
                                        <input type="hidden" name="emailtemplate" id="emailtemplate">
                                    </div>
                                </div>
                                <br />
                                <button type="submit" class="btn btn-primary" id="btn-submit">Add Template</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var quill = new Quill('.emailtemplate', {
        theme: 'snow'
    });

    $('#btn-submit').on('click', () => {
        var html = quill.root.innerHTML;
        $('#emailtemplate').val(html)
    })
</script>
<script>
    function edit(emailtemplateid, emailtemplatename, emailtemplate) {
        $('#emailtemplateid').val(emailtemplateid);
        $('#emailtemplatename').val(emailtemplatename);
        $('#emailtemplate').val(emailtemplate);
    }

    function remove(emailtemplateid) {
        if (confirm('Are you sure?')) {
            window.location.href = "<?php echo base_url('admin/deleteemailtemplate?emailtemplateid=') ?>" + emailtemplateid;
        }
    }
</script>