<!DOCTYPE html>
<html>
    <head>
        <title>Upload File to Amazon AWS S3 Bucket in Codeigniter 4 - Nicesnippets.com</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
<body>
<div class="container">
    <br>
     
    <?php if (session('msg')) : ?>
        <div class="alert alert-info alert-dismissible">
            <?= session('msg') ?>
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        </div>
    <?php endif ?>
 
    <div class="row">
        <div class="col-md-9">
                <form action="<?php echo base_url('admin/store');?>" name="ajax_form" id="ajax_form" method="post" accept-charset="utf-8" enctype="multipart/form-data">
     
                <div class="form-group">
                    <label for="formGroupExampleInput">Name</label>
                    <input type="file" name="file" class="form-control" id="file">
                </div> 
     
                <div class="form-group">
                    <button type="submit" id="send_form" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>