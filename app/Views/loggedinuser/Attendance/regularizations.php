<div class="content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Late Coming Regularizations
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Login Time</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($loginregularizations as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->loginTime ?></td>
                                        <td><?php echo $result->reason ?></td>
                                        <td> <a href="<?php echo base_url("admin/regularize/{$result->attendance_id}/1"); ?>" class="btn btn-success">Approve</a>&nbsp;&nbsp;&nbsp;
                                             <a href="<?php echo base_url("admin/regularize/{$result->attendance_id}/0"); ?>" class="btn btn-danger">Disapprove</a>
                                           </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-title">Early Going Regularizations
                </h2>
                <div class="row">
                    <div class="col-md-12">
                        <table id="tblotherusers" class="DataTable table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Logout Time</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($logoutregularizations as $result) :
                                ?>
                                    <tr>
                                        <td><?php echo $result->name ?></td>
                                        <td><?php echo $result->loginTime ?></td>
                                        <td><?php echo $result->reason ?></td>
                                        <td> <a href="<?php echo base_url("admin/regularizelogout/{$result->attendance_id}/1"); ?>" class="btn btn-success">Approve</a>&nbsp;&nbsp;&nbsp;
                                             <a href="<?php echo base_url("admin/regularizelogout/{$result->attendance_id}/0"); ?>" class="btn btn-danger">Disapprove</a>
                                           </td>
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