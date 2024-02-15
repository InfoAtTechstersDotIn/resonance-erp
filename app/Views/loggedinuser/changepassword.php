<div class="content-wrapper">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Change Password</h2>
                <form method="post" action="<?php echo base_url('home/updatepassword') ?>">
                    <br>
                    <div class="row">
                        <!-- <div class="col-md-6">
                            <label class="text-uppercase text-sm">Old Password</label>
                            <input type="text" placeholder="Old Password" name="oldpassword" class="form-control mb" required>
                        </div> -->
                        <div class="col-md-6">
                            <label class="text-uppercase text-sm">New Password</label>
                            <input type="text" placeholder="New Password" name="newpassword" class="form-control mb" required>
                            <input type="hidden" name="userid" class="form-control mb" value="<?php echo $userid ?>">
                        </div>
                    </div>
                    <button type="submit" name="changepassword" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>